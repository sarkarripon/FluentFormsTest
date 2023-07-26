<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\Mailchimp;

class IntegrationMailchimpCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

    // tests
    public function tryToTest(AcceptanceTester $I, Mailchimp $mailchimp): void
    {

        $mailchimp->configureMailchimp(8,getenv('MAILCHIMP_API_KEY'));
        $otherFieldArray = [
            'Address' => '{inputs.address_1}',
            'Birthday' => '{inputs.birthday}',
            'First Name' => '{inputs.names.first_name}',
            'Last Name' => '{inputs.names.last_name}',
            'Phone Number' => '{inputs.phone}',
        ];
        $mailchimp->mapMailchimpFields('yes',$otherFieldArray);

    }
}
