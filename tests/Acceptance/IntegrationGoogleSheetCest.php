<?php


namespace Tests\Acceptance;

use Google\Exception;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\ShortCodes;
use Tests\Support\Helper\Acceptance\Integrations\General;
use Tests\Support\Helper\Acceptance\Integrations\Googlesheet;
use Tests\Support\Selectors\FieldSelectors;

class IntegrationGoogleSheetCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->env();
        $I->wpLogin();
    }

    /**
     * @throws Exception
     */
    public function test_google_sheet_push_data(AcceptanceTester $I, Googlesheet $sheet, General $general, ShortCodes $shortCodes): void
    {
        $general->prepareForm(__FUNCTION__, ['generalFields' => ['email', 'nameFields']]);
        $sheet->configureGoogleSheet(25);

        $otherFieldArray = $shortCodes->getShortCodeArray(['Email', 'First Name', 'Last Name']);
        $sheet->mapGoogleSheetField($otherFieldArray);
        $general->preparePage(__FUNCTION__);

//        $I->amOnPage('/' . __FUNCTION__);
        $fillAbleDataArr = FieldSelectors::getFieldDataArray(['email', 'first_name', 'last_name',]);
        foreach ($fillAbleDataArr as $selector => $value) {
            if ($selector == FieldSelectors::country) {
                $I->selectOption($selector, $value);
            }else {
                $I->fillByJS($selector, $value);
            }
        }
        $I->clicked(FieldSelectors::submitButton);

        $remoteData = $sheet->fetchGoogleSheetData($fillAbleDataArr["//input[contains(@id,'email')]"]);

        $checkAbleArr = [
            $fillAbleDataArr["//input[contains(@id,'email')]"] => $remoteData[0],
            $fillAbleDataArr["//input[contains(@id,'_first_name_')]"] => $remoteData[1],
            $fillAbleDataArr["//input[contains(@id,'_last_name_')]"] => $remoteData[2],
        ];
        $I->assertString($checkAbleArr);



    }
}
