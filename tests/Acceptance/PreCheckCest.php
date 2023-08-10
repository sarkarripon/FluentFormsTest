<?php
namespace Tests\Acceptance;

use Google\Exception;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\ShortCodes;
use Tests\Support\Helper\Acceptance\Integrations\General;
use Tests\Support\Helper\Acceptance\Integrations\Googlesheet;
use Tests\Support\Helper\Acceptance\Integrations\Trello;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;
use Unirest;


class PreCheckCest
{

    public function _before(AcceptanceTester $I): void
    {
        $I->env();
        $I->wpLogin();
    }


    public function check_test(AcceptanceTester $I, Trello $trello)
    {


        $trello->fetchTrelloData('this is title');

    }


}