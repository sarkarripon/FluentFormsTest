<?php
namespace Tests\Support\Helper\Acceptance\PageObjects;
use Tests\Support\AcceptanceTester;

abstract class MainObj
{
    protected AcceptanceTester $we;
    public function __construct(AcceptanceTester $we)
    {
        $this->we = $we;
    }
}
