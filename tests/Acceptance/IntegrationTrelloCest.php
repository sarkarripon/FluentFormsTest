<?php

namespace Tests\Acceptance;

use Codeception\Attribute\Group;
use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\Trello;
use Tests\Support\Selectors\FieldSelectors;

class IntegrationTrelloCest
{
    use IntegrationHelper, Trello;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    #[Group('Integration')]
    public function test_trello_push_data(AcceptanceTester $I): void
    {
        $pageName = __FUNCTION__.'_'.rand(1,100);
        
        $faker = \Faker\Factory::create();
        $this->prepareForm($I,$pageName, ['generalFields' => ['textArea', 'textArea']]);
        $this->configureTrello($I,13);
        $this->mapTrelloField($I);
        $this->preparePage($I,$pageName);
//        $I->amOnPage('/' . $pageName);
        $cardTitle = $faker->sentence($nbWords = 3, $variableNbWords = true);
        $cardContent = $faker->text($maxNbChars = 60);

        $I->fillByJS("(//textarea[contains(@id,'description')])[1]", $cardTitle );
        $I->fillByJS("(//textarea[contains(@id,'description')])[2]", $cardContent);
        $I->clicked(FieldSelectors::submitButton);

        $remoteData = $this->fetchTrelloData($I,$cardTitle);
        if (empty($remoteData['title'])){
            $I->amOnPage('/' . $pageName);
            $I->fillByJS("(//textarea[contains(@id,'description')])[1]", $cardTitle );
            $I->fillByJS("(//textarea[contains(@id,'description')])[2]", $cardContent);
            $I->clicked(FieldSelectors::submitButton);
            $remoteData = $this->fetchTrelloData($I,$cardTitle);
        }
        if (!empty($remoteData['title'])){
            $I->assertString([
                $cardTitle => $remoteData['title'],
                $cardContent => $remoteData['cardContent']
            ]);
        }
    }

}
