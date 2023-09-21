<?php


namespace Tests\Acceptance;

use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\OnePageCrm;
use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationOnePageCrmCest
{
    use OnePageCrm, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_push_onePageCrm_data(AcceptanceTester $I)
    {
//        $remoteData = $this->fetchData('annetta.wisoky@aol.co');
////        print_r($remoteData);
//        if (isset($remoteData['data']['contacts']) and !empty($remoteData['data']['contacts'])) {
//            print_r($remoteData['data']['contacts']);
//        }
//        exit();

        $pageName = __FUNCTION__.'_'.rand(1,100);
        $listOrService =['OnePageCRM Services'=>'Contact'];
        $customName=[
            'email'=>'Enter Email',
            'nameFields'=>'Name',
            'simpleText'=>'Company Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'nameFields','simpleText'],
        ],'yes',$customName);
        $this->configureOnePageCrm($I, "OnePageCrm");

        $fieldMapping= array_merge($this->buildArrayWithKey($customName), ['Enter Email'=>'Enter Email']);

//        print_r($fieldMapping);

        $this->mapOnePageCrmFields($I,$fieldMapping,$listOrService);
        $this->preparePage($I,$pageName);

        $fillAbleDataArr = [
            'Enter Email'=>'email',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
            'Company Name'=>'company',
        ];
        $fakeData = $this->generatedData($fillAbleDataArr);
//        print_r($fakeData);

        foreach ($fakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);

        $remoteData = $this->fetchOnePageCrmData($I, $fakeData['Enter Email'],);
//        print_r($remoteData);
        if (isset($remoteData['data']['contacts']) and !empty($remoteData['data']['contacts'])) {
            $email = $remoteData['data']['contacts'][0]['contact']['emails'][0]['value'];
            $first_name = $remoteData['data']['contacts'][0]['contact']['first_name'];
            $last_name = $remoteData['data']['contacts'][0]['contact']['last_name'];

            $I->assertString([
                $fakeData['Enter Email'] => $email,
                $fakeData['First Name'] => $first_name,
                $fakeData['Last Name'] => $last_name,
            ]);
        }else{
            $I->fail("Data not found");
        }


    }
}
