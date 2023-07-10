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
    public function platformly_Integration_Test(AcceptanceTester $I, Example $example, Platformly $integration): void
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

        $integration->configureIntegration($integrationPositionNumber, $api, $projectId);
        $integration->mapPlatformlyFields();
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
        $remoteData = json_decode($integration->fetchDataFromPlatformly($api,$example['email']));
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
                echo 'Hurray!! Integration test pass. All data has been sent to Platform.ly';
            }

        //checking tags
        $I->assertContains($tags[0], $remoteTagArray);
        $I->assertContains($tags[1], $remoteTagArray);




    }




}
