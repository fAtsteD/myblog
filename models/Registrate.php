<?php

namespace app\models;

use Yii;

/**
 * This is model for view "registrate"
 * 
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 */
class Registrate extends Users
{
	/**
	 * Registrate user.
	 *
	 * @return bool if user registrates return true
	 */
	function signUp()
	{
		if ($this->validate()) {
			$this->password = Yii::$app->security->generatePasswordHash($this->password);
			$this->auth_key = Yii::$app->security->generateRandomString();
			if ($this->save(false)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
