<?php


namespace Tests\Acceptance;

use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\MailerLite;
use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationMailerLiteCest
{
    use MailerLite, DataGenerator;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_mailerLite_push_data(AcceptanceTester $I): void
    {
//        $hgg = $this->fetchData("lucituzic@gmail.co");
//        dd($hgg);
        $pageName = __FUNCTION__.'_'.rand(1,100);
        $extraListOrService =['Group List'=>getenv('MAILERLITE_GROUP')];
        $customName=[
            'email'=>'Email',
            'nameFields'=>'Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'nameFields'],
        ],'yes',$customName);
        $this->configureMailerLite($I, "MailerLite");

        $fieldMapping= [
            'Email'=>'Email',
            'Name'=>'Name'
        ];
//        print_r($fieldMapping);
        $this->mapMailerLiteFields($I,$fieldMapping,$extraListOrService);
        $this->preparePage($I,$pageName);

        $fillAbleDataArr = [
            'Email'=>'email',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
        ];
        $returnedFakeData = $this->generatedData($fillAbleDataArr);
//        print_r($returnedFakeData);

        foreach ($returnedFakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);
        $remoteData = $this->fetchMailerLiteData($I, $returnedFakeData['Email'],);
//        print_r($remoteData);

        if (isset($remoteData['data'])) {
            $email = $remoteData['data']['email'];
            $name = $remoteData['data']['fields']['name'];

            $I->assertString([
                $returnedFakeData['Email'] => $email,
                $returnedFakeData['First Name']." ". $returnedFakeData['Last Name'] => $name,

            ]);
        }else{
            $I->fail("Data not found");
        }


    }
}