<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\GetGist;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationGetGistCest
{
    use GetGist, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_getGist_push_data(AcceptanceTester $I)
    {
//        $kjnvj = $this->fetchGetGistData($I,"raul.metz@hotmail.co");
//        print_r($kjnvj);
//        exit();

        $pageName = __FUNCTION__.'_'.rand(1,100);
        $customName=[
            'email'=>'Email Address',
            'nameFields'=>'Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'nameFields'],
        ],'yes',$customName);
        $this->configureGetGist($I, "GetGist");

        $fieldMapping= [
            'Name'=>'Name',
        ];
        print_r($fieldMapping);
        $this->mapGetGistFields($I,$fieldMapping);
        $this->preparePage($I,$pageName);

        $I->amOnPage('/'.__FUNCTION__);
        $fillAbleDataArr = [
            'Email Address'=>'email',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
        ];
        $fakeData = $this->generatedData($fillAbleDataArr);
//        print_r($fakeData);

        foreach ($fakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);
        $remoteData = $this->fetchGetGistData($I, $fakeData['Email Address'],);
//        print_r($remoteData);

        if (isset($remoteData['contact'])) {
            $email = $remoteData['contact']['email'];
            $fullName = $remoteData['contact']['full_name'];

            $I->assertString([
                $fakeData['Email Address'] => $email,
                $fakeData['First Name']." ".  $fakeData['Last Name'] => $fullName,
            ]);
        }else{
            $I->fail("Data not found");
        }
    }
}
