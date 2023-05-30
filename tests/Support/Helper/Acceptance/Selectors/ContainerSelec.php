<?php
namespace Tests\Support\Helper\Acceptance\Selectors;
class ContainerSelec
{
    public static function selectContainer($containerNumber): string
    {
        return "(//i[contains(text(),'+')])[$containerNumber]";
    }
    const containr = "(//h5[normalize-space()='ContainerSelec'])[1]";
    const oneColumn = "(//div[contains(text(),'One Column ContainerSelec')])[1]";
    const twoColumns = "(//div[contains(text(),'Two Column ContainerSelec')])[1]";
    const threeColumns = "(//div[contains(text(),'Three Column ContainerSelec')])[1]";
    const fourColumns = "(//div[contains(text(),'Four Column ContainerSelec')])[1]";
    const fiveColumns = "(//div[contains(text(),'Five Column ContainerSelec')])[1]";
    const sixColumns = "(//div[contains(text(),'Six Column ContainerSelec')])[1]";
}

