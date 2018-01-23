<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $token_retrieve_password
 */
class Users extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'auth_key'], 'required'],
            [['username', 'password', 'auth_key', 'token_retrieve_password'], 'string', 'max' => 255],
            [['username', 'token_retrieve_password'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'token_retrieve_password' => 'Token RetrievePassword'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token_retrieve_password' => $token]);
    }

    /**
     * Find user by username.
     *
     * @param string $username
     * @return Users
     */
    public static function findByUsername(string $username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Create password by hashing.
     *
     * @param string $password
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Create auth key from random string.
     *
     * @return void
     */
    public function setAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function setTokenRetrievePassword()
    {
        $this->token_retrieve_password = Yii::$app->security->generateRandomString();
        while (!$this->validate(['token_retrieve_password'])) {
            $this->token_retrieve_password = Yii::$app->security->generateRandomString();
        }
        $this->save();
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password.
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
}
