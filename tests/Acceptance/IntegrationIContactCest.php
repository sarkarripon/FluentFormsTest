<?php


namespace Tests\Acceptance;

use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\IContact;
use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationIContactCest
{
    use IntegrationHelper, IContact, DataGenerator, FieldCustomizer;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_iContact_push_data(AcceptanceTester $I): void
    {
//        $cjnj= $this->fetchIContactData($I,'qa@wpmanageninja.com');
//        print_r($cjnj);
//        exit();


        $pageName = __FUNCTION__.'_'.rand(1,100);
        $extraListOrService =['iContact List'=>getenv('ICONTACT_CONTACT_LIST')];
        $customName=[
            'email'=>'Email Address',
            'nameFields'=>'Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'nameFields'],
        ],'yes',$customName);
        $this->configureIContact($I, "iContact");

        $fieldMapping= $this->buildArrayWithKey($customName);
        $this->mapIContactFields($I,$fieldMapping,$extraListOrService);
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
        $remoteData = $this->fetchIContactData($I, $returnedFakeData['Email Address'],);
//        print_r($remoteData);
        if (isset($remoteData) and !empty($remoteData)) {
            $email = $remoteData['email'];
            $firstName = $remoteData['firstName'];
            $lastName = $remoteData['lastName'];

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
