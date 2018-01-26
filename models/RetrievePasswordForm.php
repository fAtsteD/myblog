<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This model for view "retrievePassword"
 * 
 * @var const string SCENARIO_FIND_USERNAME constant for scenario, when demand only username from user
 * @var const string SCENARIO_RETRIEVE_PASSWORD constant for scenario, when demand only password from user
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
			[['password', 'repeatePassword'], 'string', 'length' => [6, 255]],
			[['username'], 'string', 'length' => [3, 255]],
			[['repeatePassword'], 'compare', 'compareAttribute' => 'repeatePassword'],
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
