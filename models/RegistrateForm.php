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
class RegistrateForm extends Model
{
	public $username;
	public $password;
	public $repeatePassword;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['username', 'password', 'repeatePassword'], 'required'],
			[['username'], 'string', 'max' => 255, 'min' => 3],
			[['password', 'repeatePassword'], 'string', 'max' => 255, 'min' => 6],
			[['repeatePassword'], 'validatePassword'],
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
	 * Validates the passwords.
	 * This method serves as the inline validation for passwords.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 * @return void
	 */
	public function validatePassword($attribute, $params)
	{
		if ($this->password !== $this->repeatePassword) {
			$this->addError($attribute, 'Пароль не совпадает.');
		}
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
				$auth = Yii::$app->authManager;
				$auth->assign($auth->getRole('registrateUser'), $user->getId());

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
