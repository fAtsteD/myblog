<?php

use app\tests\fixtures\UsersFixture;


class RegistrateFormCest
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
    
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/registrate');
    }

    public function openRegistratePage(FunctionalTester $I)
    {
        $I->see('Регистрация', 'h1');
    }

    public function registrateWithSmallPasswordAndUsername(FunctionalTester $I)
    {
        $I->submitForm('#registrate-form', [
            'Registrate[username]' => 're',
            'Registrate[password]' => 'hello',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Пароль should contain at least 6 characters.');
        $I->see('Логин should contain at least 3 characters.');
    }

    public function registrateSuccessfully(FunctionalTester $I)
    {
        $I->submitForm('#registrate-form', [
            'Registrate[username]' => 'registrateUser',
            'Registrate[password]' => 'hello123456789',
        ]);
        $I->see('Logout (registrateUser)');
        $I->dontSeeElement('form#registrate-form');
    }

    public function registrateExistUser(FunctionalTester $I)
    {
        $I->submitForm('#registrate-form', [
            'Registrate[username]' => 'admin-test',
            'Registrate[password]' => 'admin921',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Username "admin-test" has already been taken.');
    }


    public function loginWithEmptyCredentials(FunctionalTester $I)
    {
        $I->submitForm('#registrate-form', []);
        $I->expectTo('see validations errors');
        $I->see('Логин cannot be blank.');
        $I->see('Пароль cannot be blank.');
    }
}
