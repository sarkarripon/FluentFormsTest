<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

interface CommonInterface
{
    public function configureIntegration(int $formId): void;
    public function mapIntegrationField(): void;
    public function fetchIntegrationData(string $cardTitle): array;


}