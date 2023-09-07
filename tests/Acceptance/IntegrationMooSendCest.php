<?php


namespace Tests\Acceptance;

use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\MooSend;
use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationMooSendCest
{
    use MooSend, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_mooSend_push_data(AcceptanceTester $I): void
    {
        $pageName = __FUNCTION__.'_'.rand(1,100);
        $extraListOrService =['MooSend Mailing Lists'=>getenv('MOOSEND_MAILING_LIST')];
        $customName=[
            'email'=>'Email Address',
            'nameFields'=>'Full Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'nameFields'],
        ],'yes',$customName);
        $this->configureMooSend($I, "MooSend");
        $fieldMapping=[
            'Name'=>'Full Name',
        ];

        $this->mapMooSendFields($I,$fieldMapping,$extraListOrService);
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

        $remoteData = $this->fetchMooSendData($I, $returnedFakeData['Email Address'],);
//        print_r($remoteData);
        if (isset($remoteData['Context'])) {
            $email = $remoteData['Context']['Email'];
            $name = $remoteData['Context']['Name'];

            $I->assertString([
                $returnedFakeData['Email Address'] => $email,
                $returnedFakeData['First Name']." ".$returnedFakeData['Last Name'] => $name,
            ]);
        }else{
            $I->fail("Data not found");
        }
    }
}
