<?php
namespace Tests\Acceptance;

use Codeception\Attribute\Group;
use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\Googlesheet;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\Zapier;
use Tests\Support\Selectors\FieldSelectors;

class IntegrationZapierCest
{
    use IntegrationHelper, Zapier, Googlesheet;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile(); $I->loginWordpress();
    }
    #[Group('Integration')]
    public function test_zapier_push_data(AcceptanceTester $I): void
    {
        $pageName = __FUNCTION__.'_'.rand(1,100);
        
        $this->prepareForm($I,$pageName, ['generalFields' => ['email', 'nameFields']]);
        $this->configureZapier($I, 7);
        $this->preparePage($I,$pageName);

        $fillAbleDataArr = FieldSelectors::getFieldDataArray(['email', 'first_name', 'last_name']);
        foreach ($fillAbleDataArr as $selector => $value) {
            $I->fillByJS($selector, $value);
        }
        $I->clicked(FieldSelectors::submitButton);
        $remoteData = $this->fetchGoogleSheetData($I, $fillAbleDataArr["//input[contains(@id,'email')]"]);

        if (empty($remoteData)) {
            $I->amOnPage('/' . $pageName);
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
