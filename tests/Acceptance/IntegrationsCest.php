<?php
namespace Tests\Acceptance;

use Codeception\Attribute\After;
use Codeception\Attribute\Before;
use Codeception\Attribute\Skip;
use Codeception\Example;
use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\Platformly;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsAllEntries;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationsCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

    /**
     * @dataProvider \Tests\Support\Factories\DataProvider\FormData::fieldData
     */
    public function test_platformly_push_data(AcceptanceTester $I, Example $example, Platformly $platformly): void
    {
        global $pageUrl;

        $formName = 'test_platformly_push_data';
        $integrationPositionNumber = 12;
        $api = '4XIamp9fiLokeugrcmxSLMQjoRyXyStw';
        $projectId = '2919';

        $I->deleteExistingForms();
        $I->initiateNewForm();
        $requiredField = [
            'generalFields' =>['nameFields','email','phone'],
        ];
        $I->createFormField($requiredField);
        $I->click(FluentFormsSelectors::saveForm);
        $I->wait(1);
        $I->seeSuccess('Form created successfully.');
        $I->renameForm($formName);
        $I->seeSuccess('Form renamed successfully.');

        $platformly->configurePlatformly($integrationPositionNumber, $api, $projectId);
        $platformly->mapPlatformlyFields('yes', [],[],[],[],'');

        $I->deleteExistingPages();
        $I->createNewPage($formName);
        $I->wantTo('Fill the form with sample data');
        $I->amOnUrl($pageUrl);

        $I->wait(1);
        $I->fillField(FieldSelectors::first_name, ($example['first_name']));
        $I->fillField(FieldSelectors::last_name, ($example['last_name']));
        $I->fillField(FieldSelectors::email, ($example['email']));
        $I->fillField(FieldSelectors::phone, ($example['phone']));
        $I->click(FieldSelectors::submitButton);

//        $I->wait(3);
//        $remoteData = json_decode($platformly->fetchDataFromPlatformly($api,'lac22@gmail.com'));
        $remoteData = json_decode($platformly->fetchDataFromPlatformly($api,$example['email']));
//        echo gettype($remoteData);
        if(property_exists($remoteData, 'status'))
        {
            for ($i=0; $i<5; $i++)
            {
                $remoteData = json_decode($platformly->fetchDataFromPlatformly($api,$example['email']));
                if(property_exists($remoteData, 'status'))
                {
                    $I->wait(10);
                }else
                {
                    break;
                }
            }
        }
        $referenceData = [
            'first_name' => $example['first_name'],
            'last_name' => $example['last_name'],
            'email' => $example['email'],
            'phone' => $example['phone'],
        ];

        $absentData = array_diff_assoc($referenceData, (array)$remoteData);

        $message = '';
        if (!empty($absentData))
        {
            foreach ($absentData as $missingField => $value)
            {
                $message .= $missingField.', ';
            }
            $I->fail($message . " is not present to the remote.");
        }else
        {
            echo ' Hurray!! Integration test pass. All data has been sent to Platform.ly' . "\n";
        }
    }


    /**
     * @dataProvider \Tests\Support\Factories\DataProvider\FormData::fieldData
     */
    public function test_platformly_can_push_other_data(AcceptanceTester $I, Example $example, Platformly $platformly): void
    {
        global $pageUrl;
        global $tags;

        $formName = 'test_platformly_can_push_other_data';
        $integrationPositionNumber = 12;
        $api = '4XIamp9fiLokeugrcmxSLMQjoRyXyStw';
        $projectId = '2919';
        $tags = ['Non_US', 'Asian'];

        $I->deleteExistingForms();
        $I->initiateNewForm();
        $requiredField = [
            'generalFields' =>['email','addressFields'],
        ];
        $I->createFormField($requiredField);
        $I->click(FluentFormsSelectors::saveForm);
        $I->wait(1);
        $I->seeSuccess('Form created successfully.');
        $I->renameForm($formName);
        $I->seeSuccess('Form renamed successfully.');

        $platformly->configurePlatformly($integrationPositionNumber, $api, $projectId);

        $otherFieldsArray = [
            2=>'{inputs.address_1.address_line_1}',
            3=>'{inputs.address_1.address_line_2}',
            4=>'{inputs.address_1.city}',
            5=>'{inputs.address_1.state}',
            6=>'{inputs.address_1.zip}',
        ];
        $platformly->mapPlatformlyFields('', $otherFieldsArray,[],[],[],'');
        $I->deleteExistingPages();
        $I->createNewPage($formName);
        $I->wantTo('Fill the form with sample data');
        $I->amOnUrl($pageUrl);

        $I->wait(1);

        $I->fillField(FieldSelectors::email, ($example['email']));
        $I->fillField(FieldSelectors::address_line_1, ($example['address_line_1']));
        $I->fillField(FieldSelectors::address_line_2, ($example['address_line_2']));
        $I->fillField(FieldSelectors::city, ($example['city']));
        $I->fillField(FieldSelectors::state, ($example['state']));
        $I->fillField(FieldSelectors::zip, ($example['zip']));
        $I->selectOption(FieldSelectors::country, ($example['country']));
        $I->click(FieldSelectors::submitButton);

        $I->wait(3);
        $remoteData = json_decode($platformly->fetchDataFromPlatformly($api,$example['email']));
//        $remoteData = json_decode($integration->fetchDataFromPlatformly($api,'cojizuc@gmail.com'));
        $I->wait(3);

        $referenceData = [

            'email' => $example['email'],
            'address' => $example['address_line_1'],
            'address2' => $example['address_line_2'],
            'city' => $example['city'],
            'state' => $example['state'],
            'zip' => $example['zip'],
        ];

        $absentData = array_diff_assoc($referenceData, (array)$remoteData);

            $message = '';
            if (!empty($absentData))
            {
                foreach ($absentData as $missingField => $value)
                {
                    $message .= $missingField.', ';
                }
                $I->fail($message . " is not present to the remote.");
            }else
            {
                echo ' Hurray!! Additional data has been sent to Platform.ly' . "\n";
            }
    }

    /**
     * @dataProvider \Tests\Support\Factories\DataProvider\FormData::fieldData
     */
    public function test_platformly_static_tag_apply(AcceptanceTester $I, Example $example, Platformly $platformly): void
    {
        global $pageUrl;

        $formName = 'test_platformly_static_tag_apply';
        $integrationPositionNumber = 12;
        $api = '4XIamp9fiLokeugrcmxSLMQjoRyXyStw';
        $projectId = '2919';
        $tags = ['Asian','Non_US'];

        $I->deleteExistingForms();
        $I->initiateNewForm();
        $requiredField = [
            'generalFields' =>['email'],
        ];
        $I->createFormField($requiredField);
        $I->click(FluentFormsSelectors::saveForm);
        $I->wait(1);
        $I->seeSuccess('Form created successfully.');
        $I->renameForm($formName);
        $I->seeSuccess('Form renamed successfully.');

        $platformly->configurePlatformly($integrationPositionNumber, $api, $projectId);
        $platformly->mapPlatformlyFields('',[],$tags,[],[],'');

        $I->deleteExistingPages();
        $I->createNewPage($formName);
        $I->wantTo('Fill the form with sample data');
        $I->amOnUrl($pageUrl);

        $I->wait(1);

        $I->fillField(FieldSelectors::email, ($example['email']));
        $I->click(FieldSelectors::submitButton);

        $I->wait(3);
        $remoteData = json_decode($platformly->fetchDataFromPlatformly($api,$example['email']));
//        $remoteData = json_decode($integration->fetchDataFromPlatformly($api,'cojizuc@gmail.com'));

        //retrieving tags from remote
        $remoteTag = $remoteData->project[0]->data->tags;
        $remoteTagArray = [];
        foreach ($remoteTag as $tag)
        {
            $remoteTagArray[] = $tag->name;
        }
        $I->wait(3);

        //checking static tags
        foreach ($tags as $tag)
        {
            $I->assertContains($tag, $remoteTagArray);
        }
        echo ' Hurray!! Static Tag applied to platform.ly'. "\n";
    }

    /**
     * @dataProvider \Tests\Support\Factories\DataProvider\FormData::fieldData
     */
    public function test_platformly_dynamic_tag_apply(AcceptanceTester $I, Example $example, Platformly $platformly): void
    {
        global $pageUrl;

        $formName = 'test_platformly_dynamic_tag_apply';
        $integrationPositionNumber = 12;
        $api = '4XIamp9fiLokeugrcmxSLMQjoRyXyStw';
        $projectId = '2919';

        $I->deleteExistingForms();
        $I->initiateNewForm();
        $requiredField = [
            'generalFields' =>['email','nameFields'],
        ];
        $I->createFormField($requiredField);
        $I->click(FluentFormsSelectors::saveForm);
        $I->wait(1);
        $I->seeSuccess('Form created successfully.');
        $I->renameForm($formName);
        $I->seeSuccess('Form renamed successfully.');

        $platformly->configurePlatformly($integrationPositionNumber, $api, $projectId);
        $dynamicTagArray = [
            'European'=>['names[First Name]','contains','John'],

        ];

        $platformly->mapPlatformlyFields('',[],[],$dynamicTagArray,[],'');

        $I->deleteExistingPages();
        $I->createNewPage($formName);
        $I->wantTo('Fill the form with sample data');
        $I->amOnUrl($pageUrl);

        $I->wait(1);

        $I->fillField(FieldSelectors::email, ($example['email']));
        $I->fillField(FieldSelectors::first_name, "John ".($example['first_name']));
        $I->fillField(FieldSelectors::last_name, ($example['last_name']));
        $I->click(FieldSelectors::submitButton);

        $I->wait(3);
        $remoteData = json_decode($platformly->fetchDataFromPlatformly($api,$example['email']));
//        $remoteData = json_decode($integration->fetchDataFromPlatformly($api,'cojizuc@gmail.com'));

        //retrieving tags from remote
        $remoteTag = $remoteData->project[0]->data->tags;
        $remoteTagArray = [];
        foreach ($remoteTag as $tag)
        {
            $remoteTagArray[] = $tag->name;
        }
        $I->wait(3);

        //checking static tags
        foreach ($dynamicTagArray as $tag => $value)
        {
            $I->assertContains($tag, $remoteTagArray);
        }
        echo ' Hurray!! Dynamic Tag applied to platform.ly'. "\n";

    }

    /**
     * @dataProvider \Tests\Support\Factories\DataProvider\FormData::fieldData
     */
    public function test_platformly_activated_when_satisfy_all_conditions(AcceptanceTester $I, Example $example, Platformly $platformly): void
    {
        global $pageUrl;

        $formName = 'test_platformly_dynamic_tag_apply';
        $integrationPositionNumber = 12;
        $api = '4XIamp9fiLokeugrcmxSLMQjoRyXyStw';
        $projectId = '2919';

        $I->deleteExistingForms();
        $I->initiateNewForm();
        $requiredField = [
            'generalFields' =>['email','nameFields'],
        ];
        $I->createFormField($requiredField);
        $I->click(FluentFormsSelectors::saveForm);
        $I->wait(1);
        $I->seeSuccess('Form created successfully.');
        $I->renameForm($formName);
        $I->seeSuccess('Form renamed successfully.');

        $platformly->configurePlatformly($integrationPositionNumber, $api, $projectId);
        $dynamicTagArray = [
            'names[First Name]' =>['starts with','John'],
            'names[Last Name]' =>['equal','Doe'],
            'Email' =>['contains','@gmail.com'],
        ];

        $platformly->mapPlatformlyFields('',[],[],[],$dynamicTagArray,'');

        $I->deleteExistingPages();
        $I->createNewPage($formName);
        $I->wantTo('Fill the form with sample data');
        $I->amOnUrl($pageUrl);

        $I->wait(1);

        $I->fillField(FieldSelectors::email, ($example['email']));
        $I->fillField(FieldSelectors::first_name, "John ".($example['first_name']));
        $I->fillField(FieldSelectors::last_name, 'Doe');
        $I->click(FieldSelectors::submitButton);

        $I->assertStringContainsStringIgnoringCase('Success',$I->checkAPICallStatus());

    }

//    /**
//     * @dataProvider \Tests\Support\Factories\DataProvider\FormData::fieldData
//     */
//    public function test_platformly_activated_when_satisfy_any_condition(AcceptanceTester $I, Example $example, Platformly $platformly): void
//    {
//        global $pageUrl;
//
//        $formName = 'test_platformly_activated_when_satisfy_any_condition';
//        $integrationPositionNumber = 12;
//        $api = '4XIamp9fiLokeugrcmxSLMQjoRyXyStw';
//        $projectId = '2919';
//
//        $I->deleteExistingForms();
//        $I->initiateNewForm();
//        $requiredField = [
//            'generalFields' =>['email','nameFields'],
//        ];
//        $I->createFormField($requiredField);
//        $I->click(FluentFormsSelectors::saveForm);
//        $I->wait(1);
//        $I->seeSuccess('Form created successfully.');
//        $I->renameForm($formName);
//        $I->seeSuccess('Form renamed successfully.');
//
//        $platformly->configurePlatformly($integrationPositionNumber, $api, $projectId);
//        $dynamicTagArray = [
//            'names[First Name]' =>['starts with','John'],
//            'names[Last Name]' =>['not equal','Doe'],
//            'Email' =>['equal','@gmail.com'],
//        ];
//
//        $platformly->mapPlatformlyFields('',[],[],[],$dynamicTagArray,'Any');
//
//        $I->deleteExistingPages();
//        $I->createNewPage($formName);
//        $I->wantTo('Fill the form with sample data');
//        $I->amOnUrl($pageUrl);
//
//        $I->wait(1);
//
//        $I->fillField(FieldSelectors::email, ($example['email']));
//        $I->fillField(FieldSelectors::first_name, "John ".($example['first_name']));
//        $I->fillField(FieldSelectors::last_name, 'Doe');
//        $I->click(FieldSelectors::submitButton);
//
//        $I->dontSee(FluentFormsAllEntries::noLogFound);
//        $I->assertStringContainsStringIgnoringCase('Success',$I->checkAPICallStatus());
//
////
////        $I->wait(3);
////        $remoteData = json_decode($platformly->fetchDataFromPlatformly($api,$example['email']));
//////        $remoteData = json_decode($integration->fetchDataFromPlatformly($api,'cojizuc@gmail.com'));
////
////        //retrieving tags from remote
////        $remoteTag = $remoteData->project[0]->data->tags;
////        $remoteTagArray = [];
////        foreach ($remoteTag as $tag)
////        {
////            $remoteTagArray[] = $tag->name;
////        }
////        $I->wait(3);
////
////        //checking static tags
////        foreach ($dynamicTagArray as $tag => $value)
////        {
////            $I->assertContains($tag, $remoteTagArray);
////        }
////        echo ' Hurray!! Dynamic Tag applied to platform.ly'. "\n";
//
//    }
    #[skip]
    public function formPreparation_platformly_activated_when_satisfy_any_condition(AcceptanceTester $I, Platformly $platformly): void
    {
        global $pageUrl;

        $formName = 'test_platformly_activated_when_satisfy_any_condition';
        $integrationPositionNumber = 12;
        $api = '4XIamp9fiLokeugrcmxSLMQjoRyXyStw';
        $projectId = '2919';

        $I->deleteExistingForms();
        $I->initiateNewForm();
        $requiredField = [
            'generalFields' =>['email','nameFields'],
        ];
        $I->createFormField($requiredField);
        $I->click(FluentFormsSelectors::saveForm);
        $I->wait(1);
        $I->seeSuccess('Form created successfully.');
        $I->renameForm($formName);
        $I->seeSuccess('Form renamed successfully.');

        $platformly->configurePlatformly($integrationPositionNumber, $api, $projectId);
        $dynamicTagArray = [
            'names[First Name]' =>['starts with','John'],
            'names[Last Name]' =>['not equal','Doe'],
            'Email' =>['contains','@gmail.com'],
        ];

        $platformly->mapPlatformlyFields('',[],[],[],$dynamicTagArray,'Any');

        $I->deleteExistingPages();
        $I->createNewPage($formName);
        return;
    }

    /**
     * @dataProvider \Tests\Support\Factories\DataProvider\FormData::fieldDataForConditionalForm
     */
    public function test_platformly_activated_when_satisfy_any_condition(AcceptanceTester $I, Example $example, Platformly $platformly): void
    {
        if($example['id'] == 1)
        {
            $this->formPreparation_platformly_activated_when_satisfy_any_condition($I,$platformly);
        }
        global $pageUrl;

        $I->wantTo('Fill the form with sample data');
        $I->amOnUrl($pageUrl);
        $I->wait(1);

        $I->fillField(FieldSelectors::email, ($example['email']));
        $I->fillField(FieldSelectors::first_name, ($example['first_name']));
        $I->fillField(FieldSelectors::last_name, ($example['last_name']));
        $I->click(FieldSelectors::submitButton);


        if($example['id'] == 1)
        {
            $I->dontSee(FluentFormsAllEntries::noLogFound);
            $I->assertStringContainsStringIgnoringCase('Success',$I->checkAPICallStatus('Success', FluentFormsAllEntries::logSuccessStatus));
        }
        if ($example['id'] == 2)
        {
            $I->dontSee(FluentFormsAllEntries::logSuccessStatus);
            $I->assertStringContainsStringIgnoringCase('Sorry, No Logs found!',$I->checkAPICallStatus('Sorry',FluentFormsAllEntries::noLogFound));
        }


    }








}
