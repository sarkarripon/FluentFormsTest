<?php

namespace Tests\Support\Helper\Acceptance\Selectors;

class NewForm
{
    // new form creation buttons
    const createFirstForm = ".fluent_form_intro";
    const blankForm = "(//div[@class='ff-el-banner-text-inside ff-el-banner-text-inside-hoverable'])[1]";
    const saveForm = "(//button[normalize-space()='Save Form'])[1]";
}