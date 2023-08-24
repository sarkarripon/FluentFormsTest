<?php

namespace Tests\Acceptance;

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
//       $I->loginWordpress();
    }

    public function test_user_registration(AcceptanceTester $I): void
    {
        $otherFieldArray = $this->getShortCodeArray(['First Name', 'Last Name','Password']);
        $extraListOrService =['Services'=>'User Registration', 'Email Address'=>'Email'];

        $this->prepareForm($I, __FUNCTION__, [
            'generalFields' => ['email', 'nameFields', 'simpleText'],
            'advancedFields' => ['passwordField']
        ]);
        $this->configureUserRegistration($I, 1);
        $this->mapUserRegistrationField($I,$otherFieldArray,$extraListOrService);
        $this->preparePage($I, __FUNCTION__);
        $I->restartSession();
        $I->amOnPage('/' . __FUNCTION__);
        $fillAbleDataArr = FieldSelectors::getFieldDataArray(['email','first_name', 'last_name','password']);
        foreach ($fillAbleDataArr as $selector => $value) {
            $I->filledField($selector, $value);
        }
        $I->clicked(FieldSelectors::submitButton);
        $I->wait(2);

        $I->loginWordpress($fillAbleDataArr["//input[contains(@id,'email')]"],$fillAbleDataArr["//input[contains(@id,'password')]"]);
        $I->seeText([
            $fillAbleDataArr["//input[contains(@id,'_first_name_')]"],
        ]);
    }
    public function test_user_update(AcceptanceTester $I, DataGenerator $faker): void
    {
//        $faker = \Faker\Factory::create();
//        $extraListOrService =['Services'=>'User Update'];
//        $customName=[
//            'simpleText'=>['Username','First Name','Last Name','Nickname'],
//            'textArea'=>'Biographical Info',
//            'websiteUrl'=>'Website Url',
//            'email'=>'Email Address',
//            'passwordField'=>['Password','Repeat Password'],
//        ];
//        $this->prepareForm($I, __FUNCTION__, [
//            'generalFields' => ['simpleText','email','websiteUrl','textArea'],
//            'advancedFields' => ['passwordField']
//        ],'yes',$customName);
//
//        $this->configureUserRegistration($I, 1);
//        $this->mapUserRegistrationField($I,$customName,$extraListOrService);
//        $this->preparePage($I, __FUNCTION__);
//        exit();
//        $I->restartSession();
//        $I->amOnPage('/' . __FUNCTION__);
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
        print_r($data);
        exit();

        foreach ($fillAbleDataArr as $label => $value) {
            $I->filledField(FluentFormsSelectors::fillAbleArea($label), $value);
        }
        $I->clicked(FieldSelectors::submitButton);
        $I->wait(2);

        $I->loginWordpress($fillAbleDataArr["//input[contains(@id,'email')]"],$fillAbleDataArr["//input[contains(@id,'password')]"]);
        $I->seeText([
            $fillAbleDataArr["//input[contains(@id,'_first_name_')]"],
        ]);
    }
}
