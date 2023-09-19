<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\ConvertKit;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationCovertKitCest
{
    use ConvertKit, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_convertKit_push_data(AcceptanceTester $I)
    {
//        $kjnfdj = $this->fetchConvertKitData($I,'jasitowe@gmail.com');
//        dd($kjnfdj);


        $pageName = __FUNCTION__.'_'.rand(1,100);
        $extraListOrService =['ConvertKit Form'=>getenv('CONVERTKIT_LIST')];
        $customName=[
            'email' => 'Email Address',
            'nameFields'=>'Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'nameFields'],
        ],'yes',$customName);
        $this->configureConvertKit($I, "ConvertKit");

        $fieldMapping = $this->buildArrayWithKey($customName);
        unset($fieldMapping['Last Name']);

        $this->mapConvertKitFields($I,$fieldMapping,$extraListOrService);
        $this->preparePage($I,$pageName);

//        $I->amOnPage("test_airtable_push_data_57/");
        $fillAbleDataArr = [
            'Email Address'=>'email',
            'First Name'=>'firstName',
        ];
        $returnedFakeData = $this->generatedData($fillAbleDataArr);
        print_r($returnedFakeData);
//        exit();

        foreach ($returnedFakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);

        $remoteData = $this->fetchConvertKitData($I, $returnedFakeData['Email Address']);
//        print_r($remoteData);

        if (isset($remoteData)) {
            $firstName =  $remoteData['first_name'];;
            $email = $remoteData['email_address'];

            $I->assertString([
                $returnedFakeData['Email Address'] => $email,
                $returnedFakeData['First Name'] => $firstName,
            ]);
        }else{
            $I->fail("Data not found");
        }


    }
}