<?php
namespace Tests\Acceptance;

use Codeception\Attribute\Group;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\ShortCodes;
use Tests\Support\Helper\Acceptance\Integrations\Activecampaign;
use Tests\Support\Selectors\FieldSelectors;

class IntegrationActivecampaignCest
{
    use IntegrationHelper,Activecampaign,ShortCodes;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    #[Group('Integration')]
    public function test_activecampaign_push_data(AcceptanceTester $I): void
    {
        $this->prepareForm($I,__FUNCTION__, ['generalFields' => ['email', 'nameFields', 'phone']]);
        $this->configureActivecampaign($I,11);
        $otherFieldArray = $this->getShortCodeArray(['First Name', 'Last Name', 'Phone Number']);
        $this->mapActivecampaignField($I,$otherFieldArray);
        $this->preparePage($I,__FUNCTION__);

        $fillAbleDataArr = FieldSelectors::getFieldDataArray(['email', 'first_name', 'last_name', 'phone']);
        foreach ($fillAbleDataArr as $selector => $value) {
            $I->fillByJS($selector, $value);
        }
        $I->clicked(FieldSelectors::submitButton);

        $remoteData = $this->fetchActivecampaignData($I,$fillAbleDataArr["//input[contains(@id,'email')]"]);
//        print_r($remoteData['contacts']);

        // retry to submit form again if data not found
        if (empty($remoteData['contacts'])){
            $I->amOnPage('/' . __FUNCTION__);
            $fillAbleDataArr = FieldSelectors::getFieldDataArray(['email', 'first_name', 'last_name', 'phone']);

            foreach ($fillAbleDataArr as $selector => $value) {
                $I->fillByJS($selector, $value);
            }
            $I->clicked(FieldSelectors::submitButton);
            $remoteData = $this->fetchActivecampaignData($I,$fillAbleDataArr["//input[contains(@id,'email')]"]);
        }
        if (!empty($remoteData['contacts'])) {
            $contact = $remoteData['contacts'][0];
            $email = $contact['email'];
            $firstName = $contact['firstName'];
            $lastName = $contact['lastName'];
            $phone = $contact['phone'];

            $I->assertString([
                $fillAbleDataArr["//input[contains(@id,'email')]"] => $email,
                $fillAbleDataArr["//input[contains(@id,'_first_name_')]"] => $firstName,
                $fillAbleDataArr["//input[contains(@id,'_last_name_')]"] => $lastName,
                $fillAbleDataArr["//input[contains(@id,'phone')]"] => $phone,
            ]);
        }
    }
}
