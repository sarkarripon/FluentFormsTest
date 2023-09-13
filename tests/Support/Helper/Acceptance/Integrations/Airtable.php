<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Support\Helper\Acceptance\Integrations\IntegrationInterface;
use Tests\Support\AcceptanceTester;

trait Airtable
{
    public function configureAirtable(AcceptanceTester $I, string $integrationName)
    {

    }

    public function mapAirtableFields(AcceptanceTester $I, array $fieldMapping, array $extraListOrService = null)
    {
        // TODO: Implement mapFields() method.
    }

    public function fetchAirtableData(AcceptanceTester $I, string $emailToFetch)
    {
        // TODO: Implement fetchRemoteData() method.
    }

    public function fetchData(string $searchTerm=null)
    {
        $baseId = 'app8UPQIUXqroMhCP';
        $tableIdOrName = 'Projects';
        $recordId = 'rect30WSupWhxtq97';
        $accessToken = 'patHfSjlEdwOqwKiK.cd186837a833f0ad61390e3198e70fcd35d63947a6a16059f52c2d3a3dbcaae3';

        $url = "https://api.airtable.com/v0/{$baseId}/{$tableIdOrName}";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$accessToken}",
        ]);
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'cURL Error: ' . curl_error($curl);
            return false;
        }
        curl_close($curl);
        $data = json_decode($response, true);
        if (isset($data['error'])) {
            echo 'Airtable Error: ' . $data['error']['message'];
            return false;
        }
        return $data;
    }

}