<?php


namespace Tests\Acceptance;

use Codeception\Attribute\Group;
use DateTime;
use Exception;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\ShortCodes;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\Mailchimp;
use Tests\Support\Selectors\FieldSelectors;

class IntegrationMailchimpCest
{
    use IntegrationHelper, Mailchimp, ShortCodes;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    /**
     * @dataProvider \Tests\Support\Factories\DataProvider\FormData::fieldData
     *
     * @throws Exception
     */
    #[Group('Integration')]
    public function test_mailchimp_push_data(AcceptanceTester $I): void
    {
        $this->prepareForm($I,__FUNCTION__, ['generalFields' => ['email', 'nameFields']]);
        $this->configureMailchimp($I,8);
        $otherFieldArray = $this->getShortCodeArray(['First Name', 'Last Name']);
        $this->mapMailchimpFields($I,'yes', $otherFieldArray);
        $this->preparePage($I,__FUNCTION__);
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
        $remoteData = $this->fetchMailchimpData($I,$fillAbleDataArr["//input[contains(@id,'email')]"]);
        if (empty($remoteData)) {
            $I->amOnPage('/' . __FUNCTION__);
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
            $remoteData = $this->fetchMailchimpData($I,$fillAbleDataArr["//input[contains(@id,'email')]"]);
        }
        if(!empty($remoteData)){
            $I->assertString([
                $fillAbleDataArr["//input[contains(@id,'email')]"] => $remoteData->email_address,
                $fillAbleDataArr["//input[contains(@id,'_first_name_')]"] => $remoteData->merge_fields->FNAME,
                $fillAbleDataArr["//input[contains(@id,'_last_name_')]"] => $remoteData->merge_fields->LNAME,
            ]);
        }else{
            $I->fail("No data found in Mailchimp");
        }
    }
}
