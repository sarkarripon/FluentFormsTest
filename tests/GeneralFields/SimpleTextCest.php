<?php


namespace Tests\GeneralFields;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\FieldCustomizer;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class SimpleTextCest
{
    use IntegrationHelper, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_simple_text_field(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = \Faker\Factory::create();

        $elementLabel = $faker->words(2, true);
        $adminFieldLabel = $faker->words(2, true);
        $placeholder = $faker->words(3, true);
        $requiredMessage = $faker->words(2, true);

        $defaultValue = $faker->words(2, true);
        $containerClass = $faker->firstName();
        $elementClass = $faker->userName();
        $helpMessage = $faker->words(4, true);
        $prefixLabel = $faker->words(2, true);
        $suffixLabel = $faker->words(3, true);
        $nameAttribute = $faker->firstName();
        $maxLength = $faker->numberBetween(10, 100);
        $uniqueValidationMessage = $faker->words(4, true);


        $customName = [
            'simpleText' => $elementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'generalFields' => ['simpleText'],
        ], true, $customName);

        $this->customizeSimpleText($I, $elementLabel,
            [
//            'adminFieldLabel' => $adminFieldLabel,
                'placeholder' => $placeholder,
                'requiredMessage' => $requiredMessage,
            ],
            [
//            'defaultValue' => $defaultValue,
                'containerClass' => $containerClass,
                'elementClass' => $elementClass,
                'helpMessage' => $helpMessage,
                'prefixLabel' => $prefixLabel,
                'suffixLabel' => $suffixLabel,
                'nameAttribute' => $nameAttribute,
                'maxLength' => $maxLength,
                'uniqueValidationMessage' => $uniqueValidationMessage,
            ]);

        $this->preparePage($I, $pageName);
        $I->clicked(FieldSelectors::submitButton);
        $I->seeText([
            $elementLabel,
            $prefixLabel,
            $suffixLabel,
            $requiredMessage,

        ], $I->cmnt('Check element label, prefix label, suffix label and required message'));

        $I->seeElement("//input", ['placeholder' => $placeholder], $I->cmnt('Check simpletext placeholder'));
        $I->seeElement("//input", ['name' => $nameAttribute], $I->cmnt('Check simpletext name attribute'));
        $I->seeElement("//input", ['data-name' => $nameAttribute], $I->cmnt('Check simpletext name attribute'));
        $I->seeElement("//div[contains(@class,'$containerClass')]", [], $I->cmnt('Check simpletext container class'));
        $I->seeElement("//input[contains(@class,'$elementClass')]", [], $I->cmnt('Check simpletext element class'));
        $I->seeElement("//div", ['data-content' => $helpMessage], $I->cmnt('Check simpletext help message'));
        $I->seeElement("//input", ['maxlength' => $maxLength], $I->cmnt('Check simpletext input max length'));


        $fillableDataArr = [
            $elementLabel => ['regexify'=> "^[A-Za-z0-9]{".$maxLength."}"],
        ];
        $fakeData = $this->generatedData($fillableDataArr);

        $sameText = '';
        $textField = '';
        foreach ($fakeData as $selector => $value) {
            $sameText = $value;
            $textField = $selector;
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);
        $I->clicked(FieldSelectors::submitButton);
        $I->wait(1);
        $I->amOnPage('/' . $pageName);

        $I->filledField(FluentFormsSelectors::fillAbleArea($textField), $sameText);

        $I->clicked(FieldSelectors::submitButton);

        $I->seeText([
            $uniqueValidationMessage,
        ], $I->cmnt('Check unique validation message'));

        echo $I->cmnt("All test cases went through. ",'yellow','',array('blink') );
    }
    public function test_simpletext_field_with_default_value(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = \Faker\Factory::create();

        $elementLabel = $faker->words(2, true);
        $adminFieldLabel = $faker->words(2, true);
        $defaultValue = $faker->words(2, true);

        $customName = [
            'simpleText' => $elementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'generalFields' => ['simpleText'],
        ], true, $customName);

        $this->customizeSimpleText($I, $elementLabel,
            [
            'adminFieldLabel' => $adminFieldLabel,
            ],
            [
            'defaultValue' => $defaultValue,
            ]);

        $this->preparePage($I, $pageName);
        $I->seeElement("//input", ['value' => $defaultValue], $I->cmnt('Check simpletext default value'));
        $I->clicked(FieldSelectors::submitButton);
        $I->checkAdminArea([$adminFieldLabel], $I->cmnt('Check simpletext adminfield label'));
        echo $I->cmnt("All test cases went through. ", 'yellow','',array('blink'));
    }


}