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
            'RegistrateForm[username]' => 're',
            'RegistrateForm[password]' => 'hello',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Значение «Логин» должно содержать минимум 3 символа.');
        $I->see('Значение «Пароль» должно содержать минимум 6 символов.');
    }

    public function registrateSuccessfully(FunctionalTester $I)
    {
        $I->submitForm('#registrate-form', [
            'RegistrateForm[username]' => 'registrateUser',
            'RegistrateForm[password]' => 'hello123456789',
        ]);
        $I->see('registrateUser');
        $I->dontSeeElement('form#registrate-form');
    }

    public function registrateExistUser(FunctionalTester $I)
    {
        $I->submitForm('#registrate-form', [
            'RegistrateForm[username]' => 'admin-test',
            'RegistrateForm[password]' => 'admin921',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Значение «admin-test» для «Логин» уже занято.');
    }


    public function loginWithEmptyCredentials(FunctionalTester $I)
    {
        $I->submitForm('#registrate-form', []);
        $I->expectTo('see validations errors');
        $I->see('Необходимо заполнить «Логин».');
        $I->see('Необходимо заполнить «Пароль».');
    }
}
