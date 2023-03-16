<?php
namespace Tests\Support\Helper\PageObjects;
use Tests\Support\AcceptanceTester;

abstract class PageObjects
{
    protected $i;
    public function __construct(AcceptanceTester $i)
    {
        $this->i = $i;
    }
}
