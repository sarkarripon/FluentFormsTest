<?php

namespace Support\Helper\Acceptance\Integrations;

use Tests\Support\AcceptanceTester;

interface IntegrationInterface
{
    public function configure(AcceptanceTester $I, string $integrationName);
    public function mapFields(AcceptanceTester $I, array $fieldMapping, array $extraListOrService=null);
    public function fetchRemoteData(AcceptanceTester $I, string $emailToFetch);
    public function fetchData(string $emailToFetch);

}