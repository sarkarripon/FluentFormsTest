<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\Zoho;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationZohoCest
{
    use IntegrationHelper, Zoho, DataGenerator, FieldCustomizer;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }
    public function test_zoho_push_data(AcceptanceTester $I)
    {
//        $vdf = $this->fetchZohoData($I,"xidulu@mailinator.com");
//        dd($vdf);

        $pageName = __FUNCTION__.'_'.rand(1,100);
        $listOrService =['Services'=>'Contact'];
        $customName=[
            'email' => 'Email',
            'nameFields'=>'Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'nameFields'],
        ],'yes',$customName);
        $this->configureZoho($I, "Zoho CRM");

        $fieldMapping = array_merge($this->buildArrayWithKey($customName),['Email'=>'Email']);
        unset($fieldMapping['First Name']);

        $this->mapZohoFields($I,$fieldMapping,$listOrService);
        $this->preparePage($I,$pageName);

//        $I->amOnPage("test_airtable_push_data_57/");
        $fillAbleDataArr = [
            'Email'=>'email',
            'Last Name'=>'firstName',
        ];
        $fakeData = $this->generatedData($fillAbleDataArr);
//        print_r($fakeData);
//        exit();

        foreach ($fakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);

        $remoteData = $this->fetchZohoData($I, $fakeData['Email']);
//        print_r($remoteData);

        if (isset($remoteData)) {
            $lastName =  $remoteData['Last_Name'];;
            $email = $remoteData['Email'];

            $I->assertString([
                $fakeData['Email'] => $email,
                $fakeData['Last Name'] => $lastName,
            ]);
        }else{
            $I->fail("Data not found");
        }

    }
}
