<?php

use app\tests\fixtures\UsersFixture;
use app\models\Users;

class LoginFormCest
{
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
        $I->amOnRoute('site/login');
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('Войти', 'h1');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginById(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage('/');
        $I->see('Logout (admin-test)');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByInstance(\FunctionalTester $I)
    {
        $I->amLoggedInAs(Users::findByUsername('admin-test'));
        $I->amOnPage('/');
        $I->see('Logout (admin-test)');
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Логин cannot be blank.');
        $I->see('Пароль cannot be blank.');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'admin',
            'LoginForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Не правильный логин или пароль.');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'admin-test',
            'LoginForm[password]' => 'admin921',
        ]);
        $I->see('Logout (admin-test)');
        $I->dontSeeElement('form#login-form');
    }
}