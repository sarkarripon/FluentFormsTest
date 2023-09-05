<?php


namespace Tests\Acceptance;

use Tests\Support\Helper\Acceptance\Integrations\IContact;
use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationIContactCest
{
    use IntegrationHelper, IContact;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
//        $I->loginWordpress();
    }

    // tests
    public function test_iContact_push_data(AcceptanceTester $I): void
    {
        $cjnj= $this->fetchData('qa@wpmanageninja.com');
        print_r($cjnj);
        exit();








        $pageName = __FUNCTION__.'_'.rand(1,100);
        $extraListOrService =['iContact List'=>getenv('ICONTACT_CONTACT_LIST')];
        $customName=[
            'email'=>'Email Address',
            'nameFields'=>'Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'nameFields'],
        ],'yes',$customName);
        $this->configureSendinblue($I, "Sendinblue");

        $fieldMapping=[
            'email'=>'Email Address',
            'nameFields'=>['First Name','Last Name'],
        ];
        $this->mapSendinblueFields($I,$fieldMapping,$extraListOrService);
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
        $remoteData = $this->fetchSendinblueData($I, $returnedFakeData['Email Address'],);
//        print_r($remoteData);
        if (!isset($remoteData['message'])) {
            $email = $remoteData['email'];
            $firstName = $remoteData['attributes']['FIRSTNAME'];
            $lastName = $remoteData['attributes']['LASTNAME'];

            $I->assertString([
                $returnedFakeData['Email Address'] => $email,
                $returnedFakeData['First Name'] => $firstName,
                $returnedFakeData['Last Name'] => $lastName,
            ]);
        }else{
            $I->fail("Data not found");
        }
    }
}
