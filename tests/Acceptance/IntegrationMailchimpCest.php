<?php


namespace Tests\Acceptance;

use Codeception\Example;
use DateTime;
use Exception;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\ShortCodes;
use Tests\Support\Helper\Acceptance\Integrations\General;
use Tests\Support\Helper\Acceptance\Integrations\Mailchimp;
use Tests\Support\Selectors\FieldSelectors;

class IntegrationMailchimpCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->env();
        $I->wpLogin();
    }

    /**
     * @dataProvider \Tests\Support\Factories\DataProvider\FormData::fieldData
     *
     * @throws Exception
     */
    public function test_mailchimp_push_data(AcceptanceTester $I, Mailchimp $mailchimp, General $general, ShortCodes $shortCodes): void
    {
        $general->prepareForm(__FUNCTION__, ['generalFields' => ['email', 'nameFields']]);
        $mailchimp->configureMailchimp(8);

        $otherFieldArray = $shortCodes->getShortCodeArray(['First Name', 'Last Name']);

        $mailchimp->mapMailchimpFields('yes', $otherFieldArray);
        $general->preparePage(__FUNCTION__);
//        $I->amOnPage('/' . __FUNCTION__);
        $fillAbleDataArr = FieldSelectors::getFieldDataArray(['first_name', 'last_name', 'email']);

        foreach ($fillAbleDataArr as $selector => $value) {
            if ($selector == FieldSelectors::country) {
                $I->selectOption($selector, $value);
            } elseif ($selector == FieldSelectors::dateTime) {
                $dateTime = new DateTime($value);
                $formattedDate = $dateTime->format('d/m');
                $I->fillByJS($selector, $formattedDate);
            }else {
                $I->fillByJS($selector, $value);
            }
        }
        $I->clicked(FieldSelectors::submitButton);

        $remoteData = $mailchimp->fetchMailchimpData($fillAbleDataArr["//input[contains(@id,'email')]"]);

        $checkAbleArr = [
            $fillAbleDataArr["//input[contains(@id,'email')]"] => $remoteData->email_address,
            $fillAbleDataArr["//input[contains(@id,'_first_name_')]"] => $remoteData->merge_fields->FNAME,
            $fillAbleDataArr["//input[contains(@id,'_last_name_')]"] => $remoteData->merge_fields->LNAME,
        ];
        $I->assertString($checkAbleArr);



    }
}
