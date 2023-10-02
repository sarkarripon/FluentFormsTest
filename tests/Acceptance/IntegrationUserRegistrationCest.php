<?php

namespace Tests\Acceptance;

use Codeception\Attribute\After;
use Codeception\Attribute\Before;
use Codeception\Attribute\Depends;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Factories\DataProvider\ShortCodes;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\UserRegistration;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationUserRegistrationCest
{
    use IntegrationHelper, UserRegistration, DataGenerator, FieldCustomizer;
    public function _before(AcceptanceTester $I): void
    {
       $I->loadDotEnvFile();
//       $I->loginWordpress();
    }


    public function test_user_registration(AcceptanceTester $I): array
    {
//        global $newUser;
//        $pageName = __FUNCTION__.'_'.rand(1,100);
//
//        $listOrService =['Services'=>'User Registration', "Email Address" => "Email Address"];
//        $customName=[
//            'email'=>'Email Address',
//            'simpleText'=>['Username','First Name','Last Name'],
//            'passwordField'=>'Password'
//        ];
//        $this->prepareForm($I, $pageName, [
//            'generalFields' => ['email','simpleText'],
//            'advancedFields' => ['passwordField']
//        ],true ,$customName);
//
//
//        $this->configureUserRegistration($I, "User Registration or Update");
//        $fieldMapping = $this->buildArrayWithKey($customName);
//
//        $this->mapUserRegistrationField($I,$fieldMapping,$listOrService);
//        $this->preparePage($I, $pageName);
//
//        $I->restartSession();
//        $I->amOnPage('/' . $pageName);
        $fillAbleDataArr = [
            'Email Address'=>'email',
            'Username'=>'userName',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
            'Password'=>['password'=>[10, true, true, true, false]],
        ];
        $fakeData = $this->generatedData($fillAbleDataArr);
        print_r($fakeData);
        exit();
        foreach ($fakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->wait(1);
        $I->clicked(FieldSelectors::submitButton);
        $I->wait(1);

        $I->loginWordpress($fakeData['Username'],$fakeData['Password']);
        $I->seeText([
            $fakeData['First Name'],
        ]);
        $newUser =[
            'Email Address' => $fakeData['Email Address'],
            'user' => $fakeData['Username'],
            'password' => $fakeData['Password'],
        ];
        return $newUser;
    }

    public function test_user_update(AcceptanceTester $I ): void
    {
        global $newUser;
        $pageName = __FUNCTION__.'_'.rand(1,100);
        if (empty($newUser)) {
            $newUser = $this->test_user_registration($I);
        }
        $I->loginWordpress();
        $listOrService =['Services'=>'User Update'];
        $customName=[
            'simpleText'=>['Username','First Name','Last Name','Nickname'],
            'textArea'=>'Biographical Info',
            'websiteUrl'=>'Website Url',
            'email'=>'Email Address',
            'passwordField'=>['Password','Repeat Password'],
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['simpleText','email','websiteUrl','textArea'],
            'advancedFields' => ['passwordField']
        ],true ,$customName);

        $this->configureUserRegistration($I, "User Registration or Update");

        $fieldMapping = $this->buildArrayWithKey($customName);
        $this->mapUserRegistrationField($I,$fieldMapping,$listOrService);
        $this->preparePage($I, $pageName);
        $I->restartSession();
        $I->loginWordpress($newUser['user'],$newUser['password']);
        $I->amOnPage('/' . $pageName);
        $fillAbleDataArr = [
            'Username'=>'userName',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
            'Nickname'=>'name',
            'Biographical Info'=>'text',
            'Website Url'=>'url',
            'Email Address'=>'email',
            'Password'=>'password',
            'Repeat Password'=>'password',
        ];
        $fakeData = $this->generatedData($fillAbleDataArr);
        foreach ($fakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->wait(1);
        $I->clicked(FieldSelectors::submitButton);
        $I->wait(1);

        $I->loginWordpress($fakeData['Email Address'],$fakeData['Password']);
        $I->seeText([
            $fakeData['First Name'],
        ]);
    }
}
