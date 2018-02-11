<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * View information about user by id.
 * Update information if you have permission.
 * 
 * @property int $userId
 * @property string $username
 * @property string $password
 * @property string $repeatPassword
 */
class ViewAndUpdateForm extends Model
{
	public $userId;
	public $username;
	public $password;
	public $repeatePassword;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['username'], 'string', 'length' => [3, 255]],
			[['password', 'repeatePassword'], 'string', 'length' => [6, 255]],
			[['password'], 'compare', 'compareAttribute' => 'repeatePassword'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'username' => 'Логин',
			'password' => 'Пароль',
			'repeatePassword' => 'Повторите пароль',
		];
	}

	/**
	 * Get info about user by id.
	 * Information that user do not have to know will be not given.
	 *
	 * @param int $id id of user
	 * @return bool if user exists "true"
	 */
	public function getInfo($id)
	{
		if (!($user = Users::findIdentity($id))) {
			return false;
		}

		$this->username = $user->username;
		$this->userId = $user->getId();

		return true;
	}

	/**
	 * Change data user by id.
	 *
	 * @param string $id id of user
	 * @return Users|null
	 */
	public function changeData($id)
	{
		if (!($user = Users::findIdentity($id))) {
			return null;
		}

		if ($this->validate() && $user->getId() === Yii::$app->user->getId()) {
			if ($this->username) {
				$user->username = $this->username;
			}

			if ($this->password) {
				$user->setPassword($this->password);
			}

			if ($user->validate() && $user->save(false)) {
				return $user;
			} else {
				$this->addErrors($user->getErrors());
				return null;
			}
		}

		return null;
	}
}
