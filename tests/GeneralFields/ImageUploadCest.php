<?php


namespace Tests\GeneralFields;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FieldSelectors;

class ImageUploadCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_image_upload_field(AcceptanceTester $I)
    {
        $imageName = \Faker\Factory::create()->firstName();
        $generatedImage = $I->downloadImage("tests/Support/Data",
            500,500,null,true,false,$imageName,false,'jpeg');

        $I->amOnPage('test_date_time_field_98/');
        $I->attachFile("//input[@name='image-upload']", $generatedImage);
        $I->clicked(FieldSelectors::submitButton);

        exit();

    }
}
