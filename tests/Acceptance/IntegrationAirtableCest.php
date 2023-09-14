<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\Airtable;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationAirtableCest
{
    use Airtable, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();

    }

    // tests
    public function test_airtable_push_data(AcceptanceTester $I)
    {
//        $jvj = $this->fetchAirtableData($I,"Quarterly launch");
//        print_r($jvj);
//        exit();

        $pageName = __FUNCTION__.'_'.rand(1,100);
        $extraListOrService =['Airtable Configuration'=>getenv('AIRTABLE_BASE_NAME')];
        $customName=[
            'nameFields'=>'Name',
            'simpleText'=>'Status',
            'timeDate'=>'Start date',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['nameFields','simpleText','timeDate'],
        ],'yes',$customName);
        $this->configureAirtable($I, "Airtable");

        $fieldMapping= [
            'Name'=>'Name',
            'Status'=>'Status',
            'Start date'=>'Start date',
        ];

        $this->mapAirtableFields($I,$fieldMapping,$extraListOrService);
        $this->preparePage($I,$pageName);

//        $I->amOnPage("test_airtable_push_data_57/");
        $fillAbleDataArr = [
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
            'Status'=>'status',
            'Start date'=>['date'=>'m-d-Y'],
        ];
        $returnedFakeData = $this->generatedData($fillAbleDataArr);
//        print_r($returnedFakeData);
//        exit();

        foreach ($returnedFakeData as $selector => $value) {
            if (str_contains(FluentFormsSelectors::fillAbleArea($selector), 'Start date')){
                $I->fillByJS(FluentFormsSelectors::fillAbleArea($selector), $value);
            }else{
                $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
            }
        }
        $I->clicked(FieldSelectors::submitButton);

        $remoteData = $this->fetchAirtableData($I, $returnedFakeData['First Name']." ".$returnedFakeData['Last Name']);
//        print_r($remoteData);

        if (isset($remoteData)) {
            $name =  $remoteData['fields']['Name'];;
            $status = $remoteData['fields']['Status'];

            $I->assertString([
                $returnedFakeData['Status'] => $status,
                $returnedFakeData['First Name']." ".$returnedFakeData['Last Name'] => $name,
            ]);
        }else{
            $I->fail("Data not found");
        }

    }
}
