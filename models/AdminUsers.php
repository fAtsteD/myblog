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

	public function search($params)
	{
		$query = Users::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate('username')) {
			$temp = $this->getErrors();
			return $dataProvider;
		}

		$query->andFilterWhere(['id' => $this->userId])
			->andFilterWhere(['like', 'username', $this->username]);

		return $dataProvider;
	}
}
