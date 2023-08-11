<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\Helper\Pageobjects;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FluentFormsSettingsSelectors;
use Unirest;

class Trello extends Pageobjects
{
    use IntegrationHelper;

    public function mapTrelloField(): void
    {
        $this->I->waitForElement(FluentFormsSelectors::feedName, 30);
        $this->I->fillField(FluentFormsSelectors::feedName, 'Trello');
        $this->I->clickByJS(FluentFormsSelectors::dropdown('Trello Configuration'));
        $this->I->clickOnText('fluentforms','Trello Configuration');

        $this->I->clickByJS(FluentFormsSelectors::dropdown('Select List'));
        $this->I->clickOnText('To Do','Select List');

        $this->I->clickByJS(FluentFormsSelectors::dropdown('Select Card Label'));
        $this->I->clickOnText('blue','Select Card Label');

        $this->I->clickByJS(FluentFormsSelectors::dropdown('Select Members'));
        $this->I->clickOnText('Ripon Sarkar','Select Members');

        $this->I->filledField(FluentFormsSelectors::commonFields(
            'Card Title','Select a Field or Type Custom value'),"{inputs.description}");
        $this->I->filledField(FluentFormsSelectors::commonFields(
            'Card Content','Select a Field or Type Custom value'),"{inputs.description_1}");

        $this->I->clicked(FluentFormsSelectors::saveFeed);
        $this->I->seeSuccess("Integration successfully saved");
    }
    public function configureTrello($integrationPositionNumber): void
    {
        $integrationHelper = new General($this->I);
        $integrationHelper->initiateIntegrationConfiguration($integrationPositionNumber);

        $trelloIntegrationPosition = 13;

        if ($integrationPositionNumber === $trelloIntegrationPosition) {
            $isTrelloConfigured = $this->I->checkElement(FluentFormsSettingsSelectors::APIDisconnect);

            if (!$isTrelloConfigured) {
                $this->I->fillField(
                    FluentFormsSelectors::commonFields("Trello access Key", "access token Key"),
                    getenv("TRELLO_ACCESS_KEY")
                );
                $this->I->clicked(FluentFormsSettingsSelectors::APISaveButton);
            }
            $integrationHelper->configureApiSettings("Trello");
        }

    }
    public function fetchTrelloData($titleToSearch): array
    {
        $expectedData = $this->retryFetchingData([$this, 'fetchData'], $titleToSearch, $this->I);

        if (empty($expectedData)) {
            $this->I->fail('The row with the title ' . $titleToSearch . ' was not found in the Trello.');
        }
        return $expectedData;
    }
    public function fetchData($titleToSearch): array
    {
        $headers = array(
            'Accept' => 'application/json'
        );
        $query = array(
            'query' => $titleToSearch,
            'key' => getenv("TRELLO_API_KEY"),
            'token' => getenv("TRELLO_ACCESS_TOKEN"),
        );

        $response = Unirest\Request::get(
            'https://api.trello.com/1/search', $headers, $query
        );

        $cards = $response->body->cards;

        $title= null;
        $cardContent = null;
        foreach ($cards as $card) {
            $cardContent = $card->desc;
            $title = $card->name;
        }
        return ['title'=> $title, 'cardContent' => $cardContent];
    }

}