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
        $I->amOnPage('test_date_time_field_98/');
        $I->wait(1);
        $I->attachFile("//input[@name='image-upload']", "tiger.jpeg");
//        $I->clicked(FieldSelectors::submitButton);

        exit();

    }
}
