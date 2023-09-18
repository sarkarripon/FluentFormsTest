<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\Insightly;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationInsightlyCest
{
    use Insightly, IntegrationHelper, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_insightly_push_data(AcceptanceTester $I)
    {
//        $hbvdf = $this->fetchInsightlyData($I, 'qa@wpmanageninja.com');
//        dd($hbvdf);

        $pageName = __FUNCTION__.'_'.rand(1,100);
        $extraListOrService = [
            'Insightly Services' => 'Contact',
        ];
        $customName=[
            'email' => 'Email',
            'nameFields'=>'Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'nameFields'],
        ],'yes',$customName);
        $this->configureInsightly($I, "Insightly");

        $fieldMapping = array_merge($this->buildArrayWithKey($customName), ['Email' => 'Email']);
//        unset($fieldMapping['Last Name']);
//        print_r($fieldMapping);
        $this->mapInsightlyFields($I,$fieldMapping,$extraListOrService);
        $this->preparePage($I,$pageName);

//        $I->amOnPage("test_airtable_push_data_57/");
        $fillAbleDataArr = [
            'Email'=>'email',
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

        $remoteData = $this->fetchInsightlyData($I, $returnedFakeData['Email']);
//        print_r($remoteData);

        if (isset($remoteData)) {
            $firstName =  $remoteData['FIRST_NAME'];;
            $lastName = $remoteData['LAST_NAME'];
            $email = $remoteData['EMAIL_ADDRESS'];

            $I->assertString([
                $returnedFakeData['Email'] => $email,
                $returnedFakeData['First Name'] => $firstName,
                $returnedFakeData['Last Name'] => $lastName,
            ]);
        }else{
            $I->fail("Data not found");
        }
    }
}
