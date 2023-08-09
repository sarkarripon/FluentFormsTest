<?php
namespace Tests\Acceptance;

use Google\Exception;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\ShortCodes;
use Tests\Support\Helper\Acceptance\Integrations\General;
use Tests\Support\Helper\Acceptance\Integrations\Googlesheet;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;
use Unirest;


class PreCheckCest
{

    public function _before(AcceptanceTester $I): void
    {
        $I->env();
//        $I->wpLogin();
    }


    public function check_test(AcceptanceTester $I): void
   {

// This code sample uses the 'Unirest' library:
// http://unirest.io/php.html
        $query = array(
            'key' => getenv("TRELLO_API_KEY"),
            'token' => getenv("TRELLO_ACCESS_TOKEN"),
        );

        $response = Unirest\Request::get(
            'https://api.trello.com/1/actions/64d37dd0018b7492f4742b3d',
            $query
        );

        var_dump($response);


   }

}