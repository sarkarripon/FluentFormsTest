<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\AcceptanceTester;

trait MooSend
{

    public function configureMooSend(AcceptanceTester $I, string $integrationName)
    {

    }
    public function mapMooSendFields(AcceptanceTester $I, array $fieldMapping, array $extraListOrService)
    {

    }
    public function fetchMooSendData(AcceptanceTester $I, string $emailToFetch)
    {

    }
    public function fetchData(string $emailToFetch)
    {
        $hostname = 'api.moosend.com';
        $mailingListId = getenv('MOOSEND_LIST_ID');
        $format = 'json';
        $apiKey = getenv('MOOSEND_API_KEY');
        $apiEndpoint = "https://{$hostname}/v3/subscribers/{$mailingListId}/view.{$format}?apikey={$apiKey}&Email={$emailToFetch}";

//        dd($apiEndpoint);
        $curl = curl_init($apiEndpoint);
//        dd($curl);
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