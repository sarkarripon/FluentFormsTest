<?php

namespace Tests\Acceptance;

use Codeception\Attribute\After;
use Codeception\Attribute\Before;
use Codeception\Attribute\Depends;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Factories\DataProvider\ShortCodes;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\UserRegistration;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationUserRegistrationCest
{
    use IntegrationHelper;
    use UserRegistration;
    use ShortCodes;
    public function _before(AcceptanceTester $I): void
    {
       $I->loadDotEnvFile();
       $I->loginWordpress();
    }

//    public function testing(AcceptanceTester $I): void
//    {
////        $I->cleanCookies();
//        $I->amOnPage('/test_user_registration');
//        exit();
//    }

    public function test_user_registration(AcceptanceTester $I,DataGenerator $faker): array
    {
        global $newUser;
        $pageName = __FUNCTION__.'_'.rand(1,100);

        $extraListOrService =['Services'=>'User Registration'];
        $customName=[
            'email'=>'Email Address',
            'simpleText'=>['Username','First Name','Last Name'],
            'passwordField'=>'Password'
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email','simpleText'],
            'advancedFields' => ['passwordField']
        ],'yes',$customName);

        $this->configureUserRegistration($I, 1);
        $this->mapUserRegistrationField($I,$customName,$extraListOrService);
        $this->preparePage($I, $pageName);

        $I->restartSession();
        $I->amOnPage('/' . $pageName);
        $fillAbleDataArr = [
            'Email Address'=>'email',
            'Username'=>'userName',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
            'Password'=>'password',
        ];
        $returnedFakeData = $faker->generatedData($fillAbleDataArr);
        foreach ($returnedFakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->wait(1);
        $I->clicked(FieldSelectors::submitButton);
        $I->wait(1);

        $I->loginWordpress($returnedFakeData['Username'],$returnedFakeData['Password']);
        $I->seeText([
            $returnedFakeData['First Name'],
        ]);
        $newUser =[
            'user' => $returnedFakeData['Username'],
            'password' => $returnedFakeData['Password'],
        ];
        return $newUser;
    }

    public function test_user_update(AcceptanceTester $I, DataGenerator $faker): void
    {
        global $newUser;
        $pageName = __FUNCTION__.'_'.rand(1,100);
        if (empty($newUser)) {
            $newUser = $this->test_user_registration($I,$faker);
        }
        $I->loginWordpress();
        $extraListOrService =['Services'=>'User Update'];
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
        ],'yes',$customName);

        $this->configureUserRegistration($I, 1);
        $this->mapUserRegistrationField($I,$customName,$extraListOrService);
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
        $returnedFakeData = $faker->generatedData($fillAbleDataArr);
        foreach ($returnedFakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->wait(1);
        $I->clicked(FieldSelectors::submitButton);
        $I->wait(1);

        $I->loginWordpress($returnedFakeData['Email Address'],$returnedFakeData['Password']);
        $I->seeText([
            $returnedFakeData['First Name'],
        ]);
    }
}
