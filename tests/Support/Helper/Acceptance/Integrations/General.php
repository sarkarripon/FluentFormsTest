<?php
namespace Tests\Support\Helper\Acceptance\Integrations;
use Tests\Support\Helper\Pageobjects;
use Tests\Support\Selectors\FluentFormsAddonsSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class General extends Pageobjects
{

    public function prepareForm($formName,$requiredField): void
    {
        $this->I->deleteExistingForms();
        $this->I->initiateNewForm();

        $this->I->createFormField($requiredField);
        $this->I->click(FluentFormsSelectors::saveForm);
        $this->I->wait(1);
        $this->I->seeSuccess('Form created successfully.');
        $this->I->renameForm($formName);
        $this->I->seeSuccess('Form renamed successfully.');
    }

    public function preparePage(): void
    {
        global $pageUrl;
        $this->I->deleteExistingPages();
        $this->I->createNewPage('Test Page');
        $this->I->wantTo('Fill the form with sample data');
        $this->I->amOnUrl($pageUrl);
        return;
    }
    public function initiateIntegrationConfiguration(int $integrationPositionNumber): void
    {
        $this->I->amOnPage(FluentFormsAddonsSelectors::integrationsPage);

        $element = $this->I->checkElement("(//div[@class='ff_card_footer'])[{$integrationPositionNumber}]//i[@class='el-icon-setting']");

        if (!$element) {
            $this->I->clickWithLeftButton("(//span[@class='el-switch__core'])[{$integrationPositionNumber}]");
        }

        $this->I->clickWithLeftButton("(//DIV[@class='ff_card_footer_group'])[{$integrationPositionNumber}]//I[@class='el-icon-setting']");

    }

    public function configureApiSettings($searchKey): void
    {
        $this->I->amOnPage(FluentFormsSelectors::fFormPage);
        $this->I->waitForElement(FluentFormsSelectors::mouseHoverMenu,10);
        $this->I->moveMouseOver(FluentFormsSelectors::mouseHoverMenu);
        $this->I->clicked(FluentFormsSelectors::formSettings);
        $this->I->clicked(FluentFormsSelectors::allIntegrations);
        $this->I->clicked(FluentFormsSelectors::addNewIntegration);
        $this->I->fillField(FluentFormsSelectors::searchIntegration,$searchKey);
        $this->I->clicked(FluentFormsSelectors::searchResult);
    }

    public function mapEmailInCommon($feedName): void
    {
        $this->I->waitForElement(FluentFormsSelectors::integrationFeed,20);
        $this->I->fillField(FluentFormsSelectors::feedName,$feedName);

        $this->I->clicked(FluentFormsSelectors::SegmentDropDown);
        $this->I->clicked(FluentFormsSelectors::Segment);

        $this->I->clickByJS(FluentFormsSelectors::mapEmailDropdown);
        $this->I->clickByJS(FluentFormsSelectors::mapEmail);
    }

    /**
     * Arr ex; 'Name'=>'{inputs.names}'
     *
     */
    public function mapCommonFields($fields): void
    {
        foreach ($fields as $field => $value) {
            $this->I->fillField(FluentFormsSelectors::commonFields($field), $value);
        }
    }




    public function mapDynamicTag($isDropDown, array $dynamicTagArray=null): void
    {

//        $this->I->clicked(FluentFormsSelectors::enableOption('Enable Dynamic Tag Input'));

//        $dynamicTagArray = [
//            'European' => ['names[First Name]', 'contains', 'John'],
//        ];

        global $dynamicTagField;
        $dynamicTagField = 1;
        $dynamicTagValue = 1;
        foreach ($dynamicTagArray as $tag => $value)
        {
            if ($isDropDown == "yes" and !empty($isDropDown))
            {
                $this->I->clicked(FluentFormsSelectors::setTag($dynamicTagField));
                $this->I->clickOnText($tag);
            }else{
                $this->I->fillField(FluentFormsSelectors::dynamicTagField($dynamicTagField),$tag);
            }
            $this->I->click(FluentFormsSelectors::ifClause($dynamicTagValue));
            $this->I->clickOnText($value[0]);

            $this->I->click(FluentFormsSelectors::ifClause($dynamicTagValue+1));
            $this->I->clickOnText($value[1]);

            $this->I->fillField(FluentFormsSelectors::dynamicTagValue($dynamicTagField),$value[2]);
            $this->I->click(FluentFormsSelectors::addDynamicTagField($dynamicTagField));
            $dynamicTagField++;
            $dynamicTagValue+=2;

        }
        $this->I->click(FluentFormsSelectors::removeDynamicTagField($dynamicTagField));

    }

}
