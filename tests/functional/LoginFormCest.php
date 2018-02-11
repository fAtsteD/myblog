<?php

use app\tests\fixtures\UsersFixture;
use app\models\Users;

class LoginFormCest
{
    private $username = 'admin-test';
    private $password = 'admin921';

    public function _fixtures()
    {
        return [
            'users' => [
                'class' => UsersFixture::className(),
                'dataFile' => codecept_data_dir() . 'users.php',
            ]
        ];
    }

    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('/');
        $I->click('Войти');
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('Войти');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginById(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage('/');
        $I->see($this->username);
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByInstance(\FunctionalTester $I)
    {
        $I->amLoggedInAs(Users::findByUsername($this->username));
        $I->amOnPage('/');
        $I->see($this->username);
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Необходимо заполнить «Логин».');
        $I->see('Необходимо заполнить «Пароль».');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'wrong-admin',
            'LoginForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Не правильный логин или пароль.');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => $this->username,
            'LoginForm[password]' => $this->password,
        ]);
        $I->see($this->username);
        $I->dontSeeElement('form#login-form');
    }
}