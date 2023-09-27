<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\PostCpt;

class IntegrationPostCptCest
{
    use IntegrationHelper, PostCpt, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_post_creation_using_cpt(AcceptanceTester $I)
    {
        // Generate a unique page name
        $pageName = __FUNCTION__ . '_' . rand(1, 100);

        // Turn on the integration for Post/CPT Creation
        $this->turnOnIntegration($I, "Post/CPT Creation");

        // Define custom field names
        $customName = [
            'postTitle'    => 'Post Title',
            'postContent'  => 'Post Content',
            'postExcerpt'  => 'Post Excerpt',
        ];

        // Prepare the form
        $this->prepareForm(
            $I,
            $pageName,
            [
                'postFields' => ['postTitle', 'postContent', 'postExcerpt'],
            ],
            'yes',
            $customName,
            true,
            true
        );
        $this->configurePostCpt($I);
        $fillAbleDataArr = $this->buildArrayWithKey($customName);
        $this->mapPostCptFields($I, $fillAbleDataArr);

        $this->preparePage($I, $pageName);


    }
}
