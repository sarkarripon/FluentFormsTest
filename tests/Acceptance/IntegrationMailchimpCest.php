<?php


namespace Tests\Acceptance;

use Codeception\Example;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\ShortCodes;
use Tests\Support\Helper\Acceptance\Integrations\General;
use Tests\Support\Helper\Acceptance\Integrations\Mailchimp;
use Tests\Support\Selectors\FieldSelectors;

class IntegrationMailchimpCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

    /**
     * @dataProvider \Tests\Support\Factories\DataProvider\FormData::fieldData
     *
     */
    public function test_mailchimp_push_data(AcceptanceTester $I, Example $example, Mailchimp $mailchimp, General $general, ShortCodes $shortCodes): void
    {
//        $general->prepareForm(__FUNCTION__,
//            ['generalFields' => ['email', 'nameFields', 'phone', 'addressFields', 'timeDate']]);
//        $mailchimp->configureMailchimp(8);
//
//        $otherFieldArray = $shortCodes->getPreparedArray(['First Name', 'Last Name', 'Phone Number', 'Address', 'Birthday']);
//        $mailchimp->mapMailchimpFields('yes', $otherFieldArray);
//        $general->preparePage(__FUNCTION__);
        $I->amOnPage('/' . __FUNCTION__);

        $fillAbleDataArr = [
            FieldSelectors::first_name => $example['first_name'],
            FieldSelectors::last_name => $example['last_name'],
            FieldSelectors::email => $example['email'],
            FieldSelectors::phone => $example['phone'],
            FieldSelectors::address_line_1 => $example['address_line_1'],
            FieldSelectors::address_line_2 => $example['address_line_2'],
            FieldSelectors::city => $example['city'],
            FieldSelectors::state => $example['state'],
            FieldSelectors::zip => $example['zip'],
            FieldSelectors::country => $example['country'],
            FieldSelectors::dateTime => $example['dateTime'],

        ];
        foreach ($fillAbleDataArr as $selector => $value) {
            if ($selector == FieldSelectors::country) {
                $I->selectOption($selector, $value);
            } else {
                $I->fillByJS($selector, $value);
            }
        }
        $I->clicked(FieldSelectors::submitButton);
        $remoteData = $mailchimp->fetchMailchimpData($example['email']);
        print_r($remoteData);
        exit();

        $referenceData = [


        ];
        $general->missingFieldCheck('',$remoteData);

        dd('im here');


    }
}
