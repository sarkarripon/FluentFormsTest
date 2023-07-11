<?php
namespace Tests\Support\Helper\Acceptance\Integrations;
use Tests\Support\Helper\Pageobjects;
use Tests\Support\Selectors\FluentFormsAddonsSelectors;

class General extends Pageobjects
{
    public function initiateIntegrationConfiguration(int $integrationPositionNumber): void
    {
        $this->I->amOnPage(FluentFormsAddonsSelectors::integrationsPage);

        $element = $this->I->checkElement("(//div[@class='ff_card_footer'])[{$integrationPositionNumber}]//i[@class='el-icon-setting']");

        if (!$element) {
            $this->I->clickWithLeftButton("(//span[@class='el-switch__core'])[{$integrationPositionNumber}]");
        }

        $this->I->clickWithLeftButton("(//DIV[@class='ff_card_footer_group'])[{$integrationPositionNumber}]//I[@class='el-icon-setting']");

    }

}
