<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is model for view "registrate"
 * 
 * @property string $username
 * @property string $password
 */
class Registrate extends Model
{
	public $username;
	public $password;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['username', 'password'], 'required'],
			[['username', 'password'], 'string', 'max' => 255, 'min' => 3],
			[['password'], 'string', 'min' => 6],
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
		];
	}

	/**
	 * Registrate user.
	 *
	 * @return Users|null if user registrates return true
	 */
	function signUp()
	{
		if ($this->validate()) {
			$user = new Users();
			$user->username = $this->username;
			$user->setPassword($this->password);
			$user->setAuthKey();
			if ($user->save()) {
				return $user;
			} else {
				$this->addErrors($user->getErrors());
				return null;
			}
		} else {
			return null;
		}
	}
}
