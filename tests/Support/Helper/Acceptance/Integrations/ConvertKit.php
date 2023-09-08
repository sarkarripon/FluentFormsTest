<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\AcceptanceTester;

trait ConvertKit
{


    public function configureIntegration(AcceptanceTester $I, string $integrationName)
    {
        // TODO: Implement configureIntegration() method.
    }

    public function mapFields(AcceptanceTester $I, array $fieldMapping, array $extraListOrService)
    {
        // TODO: Implement mapFields() method.
    }

    public function fetchConvertKitData(AcceptanceTester $I, string $emailToFetch)
    {


    }

    public function fetchData(string $emailToFetch)
    {
        $apiSecretKey = getenv("CONVERTKIT_SECRET");
        $url = "https://api.convertkit.com/v3/subscribers/2317282570?api_secret={$apiSecretKey}";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'cURL Error: ' . curl_error($curl);
        }
        curl_close($curl);
        $data = json_decode($response, true);
        return $data['subscriber'] ?? null;
    }
}