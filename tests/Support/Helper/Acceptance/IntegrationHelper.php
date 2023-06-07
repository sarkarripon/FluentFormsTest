<?php

declare(strict_types=1);

namespace Tests\Support\Helper\Acceptance;
use Codeception\Module\WebDriver;

// here you can define custom actions
// all public methods declared in helper class will be available in $I
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationHelper extends WebDriver
{
    public function something(): string
    {
        return 'something';
    }

}
