<?php
namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\Platformly;
use Dotenv;



class PreCheckCest
{

    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

   public function check_test(AcceptanceTester $I, Platformly $platformly)
   {

       $I->amOnPage('/wp-admin/admin.php?page=fluent_forms_settings&tab=general');
       var_dump(getenv('PLATFORMLY_API_KEY'));

       exit();

   }

}