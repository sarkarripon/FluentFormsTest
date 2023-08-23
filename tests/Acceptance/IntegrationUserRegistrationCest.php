<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\ShortCodes;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\UserRegistration;
use Tests\Support\Selectors\FieldSelectors;

class IntegrationUserRegistrationCest
{
    use IntegrationHelper;
    use UserRegistration;
    use ShortCodes;
    public function _before(AcceptanceTester $I): void
    {
       $I->loadDotEnvFile();
       $I->loginWordpress();
    }

    public function test_user_registration(AcceptanceTester $I): void
    {
        $otherFieldArray = $this->getShortCodeArray(['First Name', 'Last Name','Password']);
        $extraListOrService =['Services'=>'User Registration', 'Email Address'=>'Email'];

        $this->prepareForm($I, __FUNCTION__, [
            'generalFields' => ['email', 'nameFields', 'simpleText'],
            'advancedFields' => ['passwordField']
        ]);
        $this->configureUserRegistration($I, 1);
        $this->mapUserRegistrationField($I,$otherFieldArray,$extraListOrService);
        $this->preparePage($I, __FUNCTION__);
        $I->restartSession();
        $I->amOnPage('/' . __FUNCTION__);
        $fillAbleDataArr = FieldSelectors::getFieldDataArray(['email','first_name', 'last_name','password']);
        foreach ($fillAbleDataArr as $selector => $value) {
            $I->filledField($selector, $value);
        }
        $I->clicked(FieldSelectors::submitButton);
        $I->wait(2);

        $I->loginWordpress($fillAbleDataArr["//input[contains(@id,'email')]"],$fillAbleDataArr["//input[contains(@id,'password')]"]);
        $I->seeText([
            $fillAbleDataArr["//input[contains(@id,'_first_name_')]"],
        ]);
    }
}
