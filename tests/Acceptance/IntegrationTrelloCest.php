<?php


namespace Tests\Acceptance;

use Codeception\Example;
use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\General;
use Tests\Support\Helper\Acceptance\Integrations\Trello;
use Tests\Support\Selectors\FieldSelectors;

class IntegrationTrelloCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->env();
        $I->wpLogin();
    }

    public function test_trello_push_data(AcceptanceTester $I, Trello $trello, General $general): void
    {
        $faker = \Faker\Factory::create();
        $general->prepareForm(__FUNCTION__, ['generalFields' => ['textArea', 'textArea']]);
        $trello->configureTrello(13);
        $trello->mapTrelloField();
        $general->preparePage(__FUNCTION__);
//        $I->amOnPage('/' . __FUNCTION__);

        $cardTitle = $faker->sentence($nbWords = 3, $variableNbWords = true);
        $cardContent = $faker->text($maxNbChars = 60);

        $I->fillByJS("(//textarea[contains(@id,'description')])[1]", $cardTitle );
        $I->fillByJS("(//textarea[contains(@id,'description')])[2]", $cardContent);
        $I->click(FieldSelectors::submitButton);

        $remoteData = $trello->fetchTrelloData($cardTitle);

        $I->assertString([
            $cardTitle => $remoteData['title'],
            $cardContent => $remoteData['cardContent']
        ]);

    }

}
