<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\AcceptanceTester;

trait ConstantContact
{

    public function configureConstantContact(AcceptanceTester $I, string $integrationName)
    {
        // TODO: Implement configure() method.
    }

    public function mapConstantContactFields(AcceptanceTester $I, array $fieldMapping, array $listOrService = null)
    {
        // TODO: Implement mapFields() method.
    }

    public function fetchConstantContactData(AcceptanceTester $I, string $emailToFetch)
    {
        // TODO: Implement fetchRemoteData() method.
    }

    public function fetchData(string $searchTerm)
    {
        $accessToken = getenv('CONSTANT_CONTACT_ACCESS_KEY');

        $apiUrl = "https://api.cc.email/v3/contacts?email={$searchTerm}";
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}