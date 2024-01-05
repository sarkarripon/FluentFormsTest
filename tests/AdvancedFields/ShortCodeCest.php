<?php


namespace Tests\AdvancedFields;

use Codeception\Attribute\Group;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\AdvancedFieldCustomizer;
use Tests\Support\Helper\Integrations\IntegrationHelper;

class ShortCodeCest
{
    use IntegrationHelper, AdvancedFieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    #[Group('advancedFields','all')]
    public function test_shortcode(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = \Faker\Factory::create();

        $shortcode = "{user.user_login}";
        $elementClass = $faker->userName();

        $this->prepareForm($I, $pageName, [
            'advancedFields' => ['shortCode'],
        ]);

        $this->customizeShortCode($I,
            [
                'shortcode' => $shortcode,
            ],
            [
                'elementClass' => $elementClass,
            ]);

        $this->preparePage($I, $pageName);
//        $I->clicked(FieldSelectors::submitButton);
        $I->seeText([
            getenv("WORDPRESS_USERNAME")
        ], $I->cmnt('Check username in the page generated by shortcode'));

        $I->canSeeElement("//div[contains(@class,'$elementClass')]", [], $I->cmnt('Check short code element class'));

        echo $I->cmnt("All test cases went through. ", 'yellow','',array('blink'));

    }
}
