<?php

namespace Tests\Support\Helper\Acceptance;

use MailchimpMarketing\ApiClient;
use Tests\Support\Helper\Pageobjects;

class DataFetcher extends Pageobjects
{
    public function fetchAPIData(string $integration, $email): void
    {
        $response = "";
        if($integration == "mailchimp") {
            $response = $this->fetchMailchimpData($email);
        }elseif ($integration == "platformly") {
            $response = $this->fetchPlatformlyData($email);
        }


    }

    public static function fetchMailchimpData($email)
    {
        $client = new ApiClient();
        $client->setConfig([
            'apiKey' => getenv('MAILCHIMP_API_KEY'),
            'server' => getenv('MAILCHIMP_SERVER_PREFIX')
        ]);

        return $client->lists->getListMember(getenv('MAILCHIMP_AUDIENCE_ID'), hash('md5', $email));
    }

//    public function fetchPlatformlyData($email): string
//    {
//        $curl = curl_init();
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => 'https://api.platform.ly',
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => '',
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => 'POST',
//            CURLOPT_POSTFIELDS => 'api_key='.getenv('PLATFORMLY_API_KEY').'&action=fetch_contact&value={"email":"' . $email . '"}',
//            CURLOPT_HTTPHEADER => array(
//                'Content-Type: application/x-www-form-urlencoded'
//            ),
//        ));
//        $response = curl_exec($curl);
//        curl_close($curl);
////        return $response;
//
//        $remoteData = json_decode($response);
//        if (property_exists($remoteData, 'status')) {
//            for ($i = 0; $i < 5; $i++) {
//                $remoteData = json_decode($response);
//                if (property_exists($remoteData, 'status')) {
//                    $this->I->wait(20);
//                } else {
//                    break;
//                }
//            }
//        }
//        if (property_exists($remoteData, 'status')) {
//            $this->I->fail($remoteData->message);
//        }
//        return $remoteData;
//
//    }



}