<?php

namespace Tests\Support\Helper\Acceptance;

use Codeception\Module\WebDriver;

class IntegrationHelper extends WebDriver
{
    public function something(): string
    {
        return 'something';
    }

}
