<?php


namespace Tests\Acceptance;

use Tests\Support\Helper\Acceptance\Integrations\Salesflare;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationSalesflareCest
{
    use Salesflare, IntegrationHelper, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_Salesflare_push_data(AcceptanceTester $I)
    {
//        $jhvhf = $this->fetchSalesflareData($I,"bysywagu@gmail.co");
//        dd($jhvhf);

        $pageName = __FUNCTION__.'_'.rand(1,100);

        $customName=[
            'email' => 'Email Address',
            'nameFields'=>'Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'nameFields'],
        ],'yes',$customName);
        $this->configureSalesflare($I, "Salesflare");

        $fieldMapping = $this->buildArrayWithKey($customName);
//        unset($fieldMapping['Last Name']);
//        print_r($fieldMapping);
        $this->mapSalesflareFields($I,$fieldMapping);
        $this->preparePage($I,$pageName);

//        $I->amOnPage("test_salesflare_push_data_93");
        $fillAbleDataArr = [
            'Email Address'=>'email',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
        ];
        $fakeData = $this->generatedData($fillAbleDataArr);
//        print_r($fakeData);
//        exit();

        foreach ($fakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);

        $remoteData = $this->fetchSalesflareData($I, $fakeData['Email Address']);
//        print_r($remoteData);

        if (isset($remoteData)) {
            $firstName =  $remoteData[0]['firstname'];;
            $LastName =  $remoteData[0]['lastname'];;
            $email = $remoteData[0]['email'];

            $I->assertString([
                $fakeData['Email Address'] => $email,
                $fakeData['First Name'] => $firstName,
                $fakeData['Last Name'] => $LastName,
            ]);
        }else{
            $I->fail("Data not found");
        }

    }
}
