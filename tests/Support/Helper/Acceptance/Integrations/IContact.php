<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\AcceptanceTester;

trait IContact
{

    public function configureIContact(AcceptanceTester $I, string $integrationName)
    {
        // TODO: Implement configureIntegration() method.
    }

    public function mapFields(AcceptanceTester $I, array $fieldMapping, array $extraListOrService)
    {
        // TODO: Implement mapFields() method.
    }

    public function fetchIContactData(AcceptanceTester $I, string $email)
    {

    }

    public function fetchData(string $emailToFetch)
    {
        $accountId = getenv('ICONTACT_ACCOUNT_ID');
        $apiAppId = getenv('ICONTACT_APPLICATION_KEY');
        $folderID = getenv('ICONTACT_CLIENT_FOLDER_ID');
        $apiUsername = getenv('ICONTACT_EMAIL');
        $apiPassword = getenv('ICONTACT_API_PASSWORD');

        $apiEndpoint = "https://app.icontact.com/icp/a/{$accountId}/c/{$folderID}/contacts/";
//        $apiEndpoint = "https://app.icontact.com/icp/a/{$accountId}/c/{$folderID}/contacts/3745691";
//        dd($apiEndpoint);

        $curl = curl_init($apiEndpoint);

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Expect: ',
            'Accept: application/json',
            'Content-type: application/json',
            "Api-Version: 2.2",
            "Api-AppId: {$apiAppId}",
            "Api-Username: {$apiUsername}",
            "Api-Password: {$apiPassword}"
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
//        dd($response);
        if (curl_errno($curl)) {
            echo 'cURL Error: ' . curl_error($curl);
        }
        curl_close($curl);
        return json_decode($response, true);
    }

}