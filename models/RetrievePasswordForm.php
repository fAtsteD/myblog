<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This model for view "retrievePassword"
 * 
 * @property string $username user, that want to retrieve password
 * @property string $password typing new passwrord by user
 * @property string $repeatePassword typing new password by user again
 */
class RetrievePasswordForm extends Model
{
	const SCENARIO_FIND_USERNAME = 'findUsername';
	const SCENARIO_RETRIEVE_PASSWORD = 'retrievePassword';

	public $username;
	public $password;
	public $repeatePassword;

	/**
	 * @inheritDoc
	 */
	function rules()
	{
		return [
			[['password', 'repeatePassword'], 'string', 'max' => 255, 'min' => 6],
			[['username'], 'string', 'min' => 3, 'max' => 255],
			[['repeatePassword'], 'validatePassword'],
			[['username'], 'required', 'on' => self::SCENARIO_FIND_USERNAME],
			[['password', 'repeatePassword'], 'required', 'on' => self::SCENARIO_RETRIEVE_PASSWORD],
		];
	}

	/**
	 * @inheritDoc
	 */
	function attributeLabels()
	{
		return [
			'username' => 'Логин',
			'password' => 'Пароль',
			'repeatePassword' => 'Повторите пароль',
		];
	}

	/**
	 * @inheritDoc
	 */
	function scenarios()
	{
		return [
			self::SCENARIO_FIND_USERNAME => ['username'],
			self::SCENARIO_RETRIEVE_PASSWORD => ['password', 'repeatePassword'],
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
	 * Find user for retriving password.
	 *
	 * @return Users|null
	 */
	public function findUser()
	{
		if ($this->validate()) {
			if ($user = Users::findByUsername($this->username)) {
				$user->setTokenRetrievePassword();
				return $user;
			}

			$this->addError('username', 'Такого пользователя не существует.');
			return null;
		}

		return null;
	}

	/**
	 * Set password fo defining user.
	 *
	 * @param string $token model of user that want retrieve password
	 * @return Users|null
	 */
	public function retrievePassword($token)
	{
		if ($this->validate() && $user = Users::findIdentityByAccessToken($token)) {
			$user->setPassword($this->password);
			$user->token_retrieve_password = null;
			$user->save();
			return $user;
		}

		return null;
	}
}
