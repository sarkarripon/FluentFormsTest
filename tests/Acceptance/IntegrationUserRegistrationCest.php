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

    public function test_user_registration(AcceptanceTester $I,DataGenerator $faker): array
    {
        global $newUser;
        $extraListOrService =['Services'=>'User Registration'];
        $customName=[
            'email'=>'Email Address',
            'simpleText'=>['Username','First Name','Last Name'],
            'passwordField'=>'Password'
        ];
        $this->prepareForm($I, __FUNCTION__, [
            'generalFields' => ['email','simpleText'],
            'advancedFields' => ['passwordField']
        ],'yes',$customName);

        $this->configureUserRegistration($I, 1);
        $this->mapUserRegistrationField($I,$customName,$extraListOrService);
        $this->preparePage($I, __FUNCTION__);

        $I->restartSession();
        $I->amOnPage('/' . __FUNCTION__);
        $I->cleanCookies();
        $fillAbleDataArr = [
            'Email Address'=>'email',
            'Username'=>'userName',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
            'Password'=>'password',
        ];
        $data = $faker->generatedData($fillAbleDataArr);
        foreach ($data as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);
        $err = $I->checkText('Sorry, No corresponding form found');
        echo $err;
        if ($err){
            $I->amOnPage('/' . __FUNCTION__);
            foreach ($data as $selector => $value) {
                $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
            }
            $I->clicked(FieldSelectors::submitButton);
        }

        $I->loginWordpress($data['Username'],$data['Password']);
        $I->seeText([
            $data['First Name'],
        ]);
        $newUser =[
            'user' => $data['Username'],
            'password' => $data['Password'],
        ];
        return $newUser;
    }

    /**
     */
    #[Before('test_user_registration')]
    public function test_user_update(AcceptanceTester $I, DataGenerator $faker): void
    {
        $I->wait(2);
        $I->loginWordpress();
        global $newUser;
//        $faker = \Faker\Factory::create();
        $extraListOrService =['Services'=>'User Update'];
        $customName=[
            'simpleText'=>['Username','First Name','Last Name','Nickname'],
            'textArea'=>'Biographical Info',
            'websiteUrl'=>'Website Url',
            'email'=>'Email Address',
            'passwordField'=>['Password','Repeat Password'],
        ];
        $this->prepareForm($I, __FUNCTION__, [
            'generalFields' => ['simpleText','email','websiteUrl','textArea'],
            'advancedFields' => ['passwordField']
        ],'yes',$customName);

        $this->configureUserRegistration($I, 1);
        $this->mapUserRegistrationField($I,$customName,$extraListOrService);
        $this->preparePage($I, __FUNCTION__);
//        exit();
        $I->restartSession();
        $I->loginWordpress($newUser['user'],$newUser['password']);
//        $fillAbleDataArr = FieldSelectors::getFieldDataArray(['email','first_name', 'last_name','password']);
//        $password='#'.$faker->word().$faker->randomNumber(2).$faker->word().'@';
//        $fillAbleDataArr = [
//            'Username'=>$faker->userName(),
//            'First Name'=>$faker->firstName(),
//            'Last Name'=>$faker->lastName(),
//            'Nickname'=>$faker->name(),
//            'Biographical Info'=>$faker->text(),
//            'Website Url'=>$faker->url(),
//            'Email Address'=>$faker->email(),
//            'Password'=>$password,
//            'Repeat Password'=>$password
//        ];
        $I->amOnPage('/' . __FUNCTION__);
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
        $data = $faker->generatedData($fillAbleDataArr);
        foreach ($data as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        print_r($data);
        $I->clicked(FieldSelectors::submitButton);
        $I->wait(2);
        $I->loginWordpress($data['Email Address'],$data['Password']);
        $I->seeText([
            $data['First Name'],
        ]);
    }
}
