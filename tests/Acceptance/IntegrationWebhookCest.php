<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class IntegrationWebhookCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function test_webhook_push_data(AcceptanceTester $I)
    {
        $I->amOnUrl("https://webhook.site/#!/13284a9f-30b5-457f-9952-c158c10a194d/5dcc21df-09ea-4cb1-a425-dd7b20552bbc/1");

        $exception = [];
        $texts =array('lyle','Gikysyfiw@mailinator.com');
        for ($i = 0; $i < 3; $i++) {
            foreach ($texts as $text){
                try {
                    $I->clicked("(//*[@class='select ng-binding'])[1]");
                    $I->seeText(array($text));
                    break;
                }catch (\Exception $e){
                    $exception[] = $e->getMessage();
                    $I->wait(15,"");
                    $I->reloadPage();
                }
            }
        }
        if (count($exception) > 0) {
            $errorMessage = implode(PHP_EOL, $exception);
            $I->fail('Some texts are missing: ' . $errorMessage . PHP_EOL);
        }
    }
}
