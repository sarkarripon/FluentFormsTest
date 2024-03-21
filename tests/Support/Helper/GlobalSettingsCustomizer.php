<?php

namespace Tests\Support\Helper;

use Tests\Support\AcceptanceTester;

trait GlobalSettingsCustomizer
{
    public function customizeDoubleOptIn(AcceptanceTester $I)
    {
        $I->amOnPage("wp-admin/admin.php?page=fluent_forms_settings#double_optin_settings");
    }


}