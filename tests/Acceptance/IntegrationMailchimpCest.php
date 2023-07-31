<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\General;
use Tests\Support\Helper\Acceptance\Integrations\Mailchimp;

class IntegrationMailchimpCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }
    public function test_mailchimp_push_data(AcceptanceTester $I, Mailchimp $mailchimp, General $general): void
    {
        $general->prepareForm('test_mailchimp_push_data', ['generalFields' => ['email', 'nameFields', 'phone','addressFields','timeDate']]);
        $mailchimp->configureMailchimp(8);

        $otherFieldArray = [
            'Address' => '{inputs.address_1}',
            'Birthday' => '{inputs.datetime}',
            'First Name' => '{inputs.names.first_name}',
            'Last Name' => '{inputs.names.last_name}',
            'Phone Number' => '{inputs.phone}',
        ];
        $mailchimp->mapMailchimpFields('yes',$otherFieldArray);

    }
}
