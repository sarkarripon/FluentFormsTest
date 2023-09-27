<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FluentFormsSelectors;

trait PostCpt
{
    use IntegrationHelper;
    public function configurePostCpt(AcceptanceTester $I)
    {
        $this->takeMeToConfigurationPage($I);
        $I->clickOnText("Post Feeds","Settings");
        $I->clicked("//span[normalize-space()='Add Post Feed']");

    }

    public function mapPostCptFields(AcceptanceTester $I, array $fieldMapping, array $listOrService = null)
    {
//        $this->mapEmailInCommon($I,"Post Cpt Integration",$listOrService, false);
        $I->fillByJS(FluentFormsSelectors::fillAbleArea("Feed Name"), "Post Cpt Integration");
        $this->assignShortCode($I,$fieldMapping,'Post Fields Mapping');

        $I->clickWithLeftButton(FluentFormsSelectors::saveButton("Save Feed"));
        $I->seeSuccess('Integration successfully saved');
        $I->wait(1);
    }

    public function fetchRemoteData(AcceptanceTester $I, string $emailToFetch)
    {
        // TODO: Implement fetchRemoteData() method.
    }

    public function fetchData(string $emailToFetch)
    {
        // TODO: Implement fetchData() method.
    }
}