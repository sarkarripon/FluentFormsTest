<?php
namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\DataFetcher;
use Tests\Support\Helper\Acceptance\Integrations\Mailchimp;
use Tests\Support\Helper\Acceptance\Integrations\Platformly;
use Tests\Support\Selectors\FluentFormsSelectors;


class PreCheckCest
{

    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

   public function check_test(AcceptanceTester $I, Mailchimp $mailchimp ): void
   {
      $remoteData = $mailchimp->fetchMailchimpData('sijywemo@gmail.com');
      print_r($remoteData);

       echo $remoteData->merge_fields->FNAME;
       echo $remoteData->merge_fields->LNAME;
       echo $remoteData->merge_fields->ADDRESS->addr1;
       echo $remoteData->merge_fields->ADDRESS->addr2;
       echo $remoteData->merge_fields->ADDRESS->city;
       echo $remoteData->merge_fields->ADDRESS->state;
       echo $remoteData->merge_fields->ADDRESS->zip;
       echo $remoteData->merge_fields->ADDRESS->country;
       echo $remoteData->merge_fields->PHONE;
       echo $remoteData->merge_fields->BIRTHDAY;
       echo $remoteData->tags[0]->name;



       exit();

   }

}