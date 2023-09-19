<?php


namespace Tests\Acceptance;

use Tests\Support\Helper\Acceptance\Integrations\Slack;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationSlackCest
{
    use Slack, IntegrationHelper, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
//        $I->loginWordpress();
    }

    // tests
    public function test_slack_push_data(AcceptanceTester $I)
    {
        $kjf = $this->fetchSlackData($I,"Dolorem vitae quis et laborum molestiae eos qui.");

        if (!empty($kjf)) {
            $gg = $I->checkValuesInArray($kjf, ['Natalie','Deckow','janet.rowe@gmx.co','hgvsdgsvs']);
            print_r($gg);
        }else{
            $I->fail("Data not found");
        }
        exit();
//        dd($kjf);

//        $pageName = __FUNCTION__.'_'.rand(1,100);
//
//        $customName=[
//            'email' => 'Email Address',
//            'nameFields'=>'Name',
//            'simpleText'=>'Message',
//        ];
//        $this->prepareForm($I, $pageName, [
//            'generalFields' => ['email', 'nameFields','simpleText'],
//        ],'yes',$customName);
//        $this->configureSlack($I, "Slack","Fluentform submission notification","Fluentform submission received");
//        $this->preparePage($I,$pageName);

        $I->amOnPage("test_slack_push_data_28");
        $fillAbleDataArr = [
            'Email Address'=>'email',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
            'Message'=> 'sentence',
        ];
        $returnedFakeData = $this->generatedData($fillAbleDataArr);
        print_r($returnedFakeData);
//        exit();

        foreach ($returnedFakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);

        $remoteData = $this->fetchSlackData($I, $returnedFakeData['Message']);
        print_r($remoteData);

        if (!empty($remoteData)) {
            $I->searchArrayValues($remoteData, [$returnedFakeData['Last Name']]);
//            $firstName =  $remoteData[0]['firstname'];;
//            $LastName =  $remoteData[0]['lastname'];;
//            $email = $remoteData[0]['email'];
//
//            $I->assertString([
//                $returnedFakeData['Email Address'] => $email,
//                $returnedFakeData['First Name'] => $firstName,
//                $returnedFakeData['Last Name'] => $LastName,
//            ]);
        }else{
            $I->fail("Data not found");
        }

    }
}
