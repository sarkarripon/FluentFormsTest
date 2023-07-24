<?php
namespace Tests\Support\Helper\Acceptance\Integrations;

use MailchimpMarketing\ApiClient;

class Mailchimp
{
    public static function fetchMailchimpData(): void
    {
        $client = new ApiClient();
        $client->setConfig([
            'apiKey' => 'eadd373e53ebf26180ea284112909140-us21',
            'server' => 'us21',
        ]);

        $response = $client->lists->getListMember("9fb11faf47", "2f7b11e9b8b489dfdc015a3e87659e0c");
        print_r($response);
    }
}
