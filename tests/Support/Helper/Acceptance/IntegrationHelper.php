<?php
namespace Tests\Support\Helper\Acceptance;

use Codeception\Module\WebDriver;
use Tests\Support\Selectors\FluentFormsSelectors;

trait IntegrationHelper
{
    // All about platformly
    public function fetchDataFromPlatformly($api, $email): string
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.platform.ly',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'api_key='.$api.'&action=fetch_contact&value={"email":"' . $email . '"}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;

    }





}

