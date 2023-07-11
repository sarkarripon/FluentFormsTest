<?php
namespace Tests\Acceptance;

use Codeception\Example;
use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\Platformly;
use Tests\Support\Selectors\FieldSelectors;
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
    public function test_platformly_can_push_data(AcceptanceTester $I, Example $example, Platformly $platformly): void
    {
        global $pageUrl;
        global $tags;

        $formName = 'Platformly Integration';
        $integrationPositionNumber = 12;
        $api = '4XIamp9fiLokeugrcmxSLMQjoRyXyStw';
        $projectId = '2919';
        $tags = ['Non_US', 'Asian'];

        $I->deleteExistingForms();
        $I->initiateNewForm();
        $requiredField = [
            'generalFields' =>['nameFields','email','addressFields' ,'phone'],
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
            7=>'{inputs.address_1.country}',
        ];
        $platformly->mapPlatformlyFields('yes', $otherFieldsArray,'yes');
        $I->deleteExistingPages();
        $I->createNewPage($formName);
        $I->wantTo('Fill the form with sample data');
        $I->amOnUrl($pageUrl);

        $I->wait(1);
        $I->fillField(FieldSelectors::first_name, ($example['first_name']));
        $I->fillField(FieldSelectors::last_name, ($example['last_name']));
        $I->fillField(FieldSelectors::email, ($example['email']));
        $I->fillField(FieldSelectors::address_line_1, ($example['address_line_1']));
        $I->fillField(FieldSelectors::address_line_2, ($example['address_line_2']));
        $I->fillField(FieldSelectors::city, ($example['city']));
        $I->fillField(FieldSelectors::state, ($example['state']));
        $I->fillField(FieldSelectors::zip, ($example['zip']));
        $I->selectOption(FieldSelectors::country, ($example['country']));
        $I->fillField(FieldSelectors::phone, ($example['phone']));
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


        $referenceData = [
            'first_name' => $example['first_name'],
            'last_name' => $example['last_name'],
            'email' => $example['email'],
            'phone' => $example['phone'],
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
                echo ' Hurray!! Integration test pass. All data has been sent to Platform.ly' . "\n";
            }

        //checking static tags
        $I->assertContains($tags[0], $remoteTagArray, 'Tag '.$tags[0].' is present to the remote');
        $I->assertContains($tags[1], $remoteTagArray,'Tag '.$tags[1].' is present to the remote');

    }

    /**
     * @dataProvider \Tests\Support\Factories\DataProvider\FormData::fieldData
     */
    public function test_platformly_can_be_enabled_conditionally(AcceptanceTester $I, Example $example, Platformly $platformly): void
    {
        global $pageUrl;
        global $tags;

        $formName = 'Platformly tag';
        $integrationPositionNumber = 12;
        $api = '4XIamp9fiLokeugrcmxSLMQjoRyXyStw';
        $projectId = '2919';
        $tags = ['Non_US', 'Asian'];

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
        $platformly->mapPlatformlyFields('',[],'yes', '');
        $I->deleteExistingPages();
        $I->createNewPage($formName);
        $I->wantTo('Fill the form with sample data');
        $I->amOnUrl($pageUrl);

        $I->wait(1);
        $I->fillField(FieldSelectors::email, ($example['email']));


        $I->click(FieldSelectors::submitButton);

    }







}
