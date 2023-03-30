<?php
namespace Tests\Support\Helper\Acceptance\Selectors;
class Container
{
    const containr = "(//h5[normalize-space()='Container'])[1]";
    const oneColumn = "(//div[contains(text(),'One Column Container')])[1]";
    const twoColumns = "(//div[contains(text(),'Two Column Container')])[1]";
    const threeColumns = "(//div[contains(text(),'Three Column Container')])[1]";
    const fourColumns = "(//div[contains(text(),'Four Column Container')])[1]";
    const fiveColumns = "(//div[contains(text(),'Five Column Container')])[1]";
    const sixColumns = "(//div[contains(text(),'Six Column Container')])[1]";
}

