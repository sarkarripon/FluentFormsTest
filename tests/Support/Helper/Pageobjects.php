<?php
namespace Tests\Support\Helper;

use Tests\Support\AcceptanceTester;

abstract class Pageobjects
{
    /**
     * Actor
     * @var AcceptanceTester
     */
    protected AcceptanceTester $I;

    /**
     * Pageobjects constructor.
     * @param AcceptanceTester $I Actor
     *
     */
    public function __construct(AcceptanceTester $I)
    {
        $this->I = $I;
    }


}