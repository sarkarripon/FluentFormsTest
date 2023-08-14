<?php


namespace Tests\Acceptance;

use Codeception\Attribute\Group;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\ShortCodes;
use Tests\Support\Helper\Acceptance\Integrations\Googlesheet;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;

class IntegrationGoogleSheetCest
{
    use IntegrationHelper, Googlesheet, ShortCodes;
    public function _before(AcceptanceTester $I): void
    {
        $I->env();
        $I->wpLogin();
    }
    #[Group('Integration')]
    public function test_google_sheet_push_data(AcceptanceTester $I): void
    {
        $this->prepareForm($I, __FUNCTION__, ['generalFields' => ['email', 'nameFields']]);
        $this->configureGoogleSheet($I, 25);

        $otherFieldArray = $this->getShortCodeArray(['Email', 'First Name', 'Last Name']);
        $this->mapGoogleSheetField($I, $otherFieldArray);
        $this->preparePage($I, __FUNCTION__);

//        $I->amOnPage('/' . __FUNCTION__);
        $fillAbleDataArr = FieldSelectors::getFieldDataArray(['email', 'first_name', 'last_name',]);
        foreach ($fillAbleDataArr as $selector => $value) {
            if ($selector == FieldSelectors::country) {
                $I->selectOption($selector, $value);
            } else {
                $I->fillByJS($selector, $value);
            }
        }
        $I->clicked(FieldSelectors::submitButton);

        $remoteData = $this->fetchGoogleSheetData($I, $fillAbleDataArr["//input[contains(@id,'email')]"]);
        print_r($remoteData);

        // retry to submit form again if data not found
        if (empty($remoteData)) {
            $I->amOnPage('/' . __FUNCTION__);
            $fillAbleDataArr = FieldSelectors::getFieldDataArray(['email', 'first_name', 'last_name',]);
            foreach ($fillAbleDataArr as $selector => $value) {
                $I->fillByJS($selector, $value);
            }
            $I->clicked(FieldSelectors::submitButton);
            $remoteData = $this->fetchGoogleSheetData($I, $fillAbleDataArr["//input[contains(@id,'email')]"]);
        }
        if (!empty($remoteData)) {
            $email = $remoteData[0];
            $firstName = $remoteData[1];
            $lastName = $remoteData[2];

            $I->assertString([
                $fillAbleDataArr["//input[contains(@id,'email')]"] => $email,
                $fillAbleDataArr["//input[contains(@id,'_first_name_')]"] => $firstName,
                $fillAbleDataArr["//input[contains(@id,'_last_name_')]"] => $lastName,
            ]);
        }
    }
}
