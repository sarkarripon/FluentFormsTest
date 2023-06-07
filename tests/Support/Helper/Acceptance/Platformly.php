<?php
namespace Tests\Support\Helper\Acceptance;

use Codeception\Module\WebDriver;
use Tests\Support\Selectors\FluentFormsSelectors;


class Platformly extends WebDriver
{

    public function configurePlatformlyApiSettings($searchKey): void
    {
        $this->amOnPage(FluentFormsSelectors::fFormPage);
        $this->wait(2);
        $this->moveMouseOver(FluentFormsSelectors::mouseHoverMenu);
        $this->click(FluentFormsSelectors::formSettings);
        $this->click(FluentFormsSelectors::allIntegrations);
        $this->click(FluentFormsSelectors::addNewIntegration);
        $this->moveMouseOver(FluentFormsSelectors::searchIntegration);
        $this->fillField(FluentFormsSelectors::searchIntegration,$searchKey);
        $this->click(FluentFormsSelectors::searchResult);

    }

    public function platformlyData($email): string
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
            CURLOPT_POSTFIELDS => 'api_key=4XIamp9fiLokeugrcmxSLMQjoRyXyStw&action=fetch_contact&value={"email":"'.$email.'"}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));
        return curl_exec($curl);

        curl_close($curl);


    }



}