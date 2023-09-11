<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\AcceptanceTester;

trait GetGist
{

    public function configure(AcceptanceTester $I, string $integrationName)
    {
        // TODO: Implement configure() method.
    }

    public function mapFields(AcceptanceTester $I, array $fieldMapping, array $extraListOrService)
    {
        // TODO: Implement mapFields() method.
    }

    public function fetchRemoteData(AcceptanceTester $I, string $emailToFetch)
    {
        // TODO: Implement fetchRemoteData() method.
    }

    public function fetchData(string $emailToFetch)
    {
        $apiKey = getenv('GETGIST_API');
        $url = 'https://api.getgist.com/contacts?email=' . urlencode($emailToFetch);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'cURL Error: ' . curl_error($curl);
            return false;
        }
        curl_close($curl);
        return json_decode($response, true);
    }
}