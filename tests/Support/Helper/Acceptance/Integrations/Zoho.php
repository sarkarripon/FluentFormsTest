<?php

namespace Tests\Support\Helper\Acceptance\Integrations;
use Support\Helper\Acceptance\Integrations\IntegrationInterface;
use Tests\Support\AcceptanceTester;

trait Zoho
{
    public function configureZoho(AcceptanceTester $I, string $integrationName)
    {
        // TODO: Implement configure() method.
    }

    public function mapZohoFields(AcceptanceTester $I, array $fieldMapping, array $listOrService = null)
    {
        // TODO: Implement mapFields() method.
    }

    public function fetchZohoData(AcceptanceTester $I, string $emailToFetch)
    {
        // TODO: Implement fetchRemoteData() method.
    }

    public function fetchData(string $emailToFetch)
    {
        $accessToken = getenv("ZOHO_ACCESS_TOKEN");
        $url = "https://www.zohoapis.com/crm/v5/Contacts";

        $queryParams = [
            'fields' => 'Last_Name,Email,Converted__s,Converted_Date_Time',
            'per_page' => 5,
        ];

        $url .= '?' . http_build_query($queryParams);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Zoho-oauthtoken ' . $accessToken,
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
            return null;
        }

        curl_close($ch);

        $data = json_decode($response, true);

        return $data;
    }
}
