<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Model for controlling user's data.
 * 
 * @property int $userId
 * @property string $username
 * @property string $password
 * @property string $userRole
 */
class AdminUsers extends Model
{
	public $userId;
	public $username;
	public $password;
	public $userRole;

	public function rules()
	{
		return [
			[['userId'], 'integer'],
			[['username'], 'string'],
			[['password'], 'string'],
			[['userRole'], 'string'],
		];
	}

	/**
	 * Search users by parameters
	 *
	 * @param array $params
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = Users::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate('username')) {
			return $dataProvider;
		}

		$auth = Yii::$app->authManager;
		if ($this->userRole) {
			foreach ($auth->getUserIdsByRole($this->userRole) as $id) {
				$query->andFilterWhere(['id' => $id]);
			}
		}

		$query->andFilterWhere(['id' => $this->userId])
			->andFilterWhere(['like', 'username', $this->username]);

		return $dataProvider;
	}

	/**
	 * Create object by found by id
	 *
	 * @param int $id
	 * @return null|AdminUsers
	 */
	public static function findUser($id)
	{
		if (!$user = Users::findIdentity($id)) {
			return null;
		}

		$adminUsers = new AdminUsers();

		$adminUsers->userId = $user->id;
		$adminUsers->username = $user->username;
		$roles = Yii::$app->authManager->getRolesByUser($user->id);

		foreach ($roles as $role) {
			$adminUsers->userRole .= $role->name . "\n";
		}
		
		return $adminUsers;
	}

	public function updateData($id)
	{
		$this->userId = $id;
		if (!$user = Users::findIdentity($this->userId)) {
			return null;
		}

		$user->username = $this->username;

		if (!$user->save()) {
			$this->addErrors($user->getErrors());
			return null;
		}

		$auth = Yii::$app->authManager;
		$oldRoles = $auth->getRolesByUser($this->userId);
		foreach ($oldRoles as $oldRole) {
			$auth->revoke($oldRole, $this->userId);
		}
		
		if (!$roleUser = $auth->getRole($this->userRole)) {
			$this->addError('userRole', 'Не правильная роль.');
			return null;
		}

		$auth->assign($auth->getRole($this->userRole), $this->userId);
		
		return true;
	}
}
