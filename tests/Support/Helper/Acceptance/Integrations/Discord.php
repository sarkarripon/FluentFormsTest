<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\AcceptanceTester;

trait Discord
{
    public function configureDiscord(AcceptanceTester $I, string $integrationName)
    {
        // TODO: Implement configure() method.
    }

    public function mapDiscordFields(AcceptanceTester $I, array $fieldMapping, array $listOrService = null)
    {
        // TODO: Implement mapFields() method.
    }

    public function fetchDiscordData(AcceptanceTester $I, string $emailToFetch)
    {
        // TODO: Implement fetchRemoteData() method.
    }

    public function fetchData(string $emailToFetch)
    {

        $channelId = "861274037309538318";
        $accessToken = "Xe5fdsdYI5PiNnybPjnlxnDT1dr17t";
//        $apiUrl = 'https://discord.com/api/v10/users/@me';
        $apiUrl = "https://discord.com/api/v10/channels/{$channelId}/messages";
        // Set up cURL to make the GET request
        $ch = curl_init($apiUrl);

        // Set cURL options
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken, // Include the access token in the header
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request and get the response
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
            return null;
        }

        // Close the cURL session
        curl_close($ch);

        // Decode the JSON response
        $userData = json_decode($response, true);
        return $userData;
//        $channelId = '1155730130505834557';
//        $botToken = 'MTE1NTc1MTQ2ODc3MTU5NDMyMg.G3OWtc.uMq3cx-SBz15QDqI2M9pj82Mf39yfl3XQjNkPc';
//        $apiUrl = "https://discord.com/api/v10/channels/{$channelId}/messages";
//
//        // Set up cURL to make the GET request
//        $ch = curl_init($apiUrl);
//
//        // Set cURL options
//        curl_setopt($ch, CURLOPT_HTTPHEADER, [
//            'Authorization: Bot ' . $botToken, // Include the bot token in the header
//        ]);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//        // Execute the request and get the response
//        $response = curl_exec($ch);
//
//        // Check for errors
//        if (curl_errno($ch)) {
//            echo 'cURL Error: ' . curl_error($ch);
//            return null;
//        }
//
//        // Close the cURL session
//        curl_close($ch);
//
//        // Decode the JSON response
//        $data = json_decode($response, true);
//        return $data;

    }
}