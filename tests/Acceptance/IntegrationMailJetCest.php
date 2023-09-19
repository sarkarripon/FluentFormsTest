<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\MailJet;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationMailJetCest
{
    use MailJet, IntegrationHelper, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_mailJet_push_data(AcceptanceTester $I)
    {
//        $dhfv = $this->fetchMailJetData($I, 'nogowem@gmail.com');
//        dd($dhfv);

        $pageName = __FUNCTION__.'_'.rand(1,100);
        $extraListOrService = [
            'Mailjet Services' => 'Contact',
        ];
        $customName=[
            'email' => 'Contact Email',
            'nameFields'=>'Contact Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'nameFields'],
        ],'yes',$customName);
        $this->configureMailJet($I, "Mailjet");

        $fieldMapping = ['Contact Email' => 'Contact Email', 'Contact Name' => 'Contact Name'];
//        unset($fieldMapping['Last Name']);
//        print_r($fieldMapping);
        $this->mapMailJetFields($I,$fieldMapping,$extraListOrService);
        $this->preparePage($I,$pageName);

//        $I->amOnPage("test_airtable_push_data_57/");
        $fillAbleDataArr = [
            'Contact Email'=>'email',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
        ];
        $returnedFakeData = $this->generatedData($fillAbleDataArr);
//        print_r($returnedFakeData);
//        exit();

        foreach ($returnedFakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);

        $remoteData = $this->fetchMailJetData($I, $returnedFakeData['Contact Email']);
//        print_r($remoteData);

        if (isset($remoteData)) {
            $name =  $remoteData['Name'];;
            $email = $remoteData['Email'];

            $I->assertString([
                $returnedFakeData['Contact Email'] => $email,
                $returnedFakeData['First Name']." ".$returnedFakeData['Last Name'] => $name,
            ]);
        }else{
            $I->fail("Data not found");
        }

    }
}