<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\PipeDrive;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationPipeDriveCest
{
    use IntegrationHelper,PipeDrive, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_pipedrive_people_creation(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__.'_'.rand(1,100);
        $extraListOrService =[
            'Services'=>'Person',
            'Owner'=>getenv('PIPEDRIVE_OWNER'),
            'Visible to'=>'item owner',
        ];
        $customName=[
            'email'=>'Email Address',
            'nameFields'=>'Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'nameFields'],
        ],'yes',$customName);
        $this->configurePipeDrive($I, "Pipedrive");

        $fieldMapping= [
            'Email'=>'Email',
            'Name'=>'Name',
        ];
        print_r($fieldMapping);
        $this->mapPipeDriveFields($I,$fieldMapping,$extraListOrService);
        $this->preparePage($I,$pageName);

        $fillAbleDataArr = [
            'Email Address'=>'email',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
        ];
        $returnedFakeData = $this->generatedData($fillAbleDataArr);
//        print_r($returnedFakeData);

        foreach ($returnedFakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);
        $remoteData = $this->fetchPipeDriveData($I, $returnedFakeData['Email Address'],);
//        print_r($remoteData);

        if (isset($remoteData)) {
            $email = $remoteData[0]['item']['primary_email'];
            $name = $remoteData[0]['item']['name'];

            $I->assertString([
                $returnedFakeData['Email Address'] => $email,
                $returnedFakeData['First Name']." ".$returnedFakeData['Last Name'] => $name,
            ]);
        }else{
            $I->fail("Data not found");
        }


    }
}