<?php

namespace Tests\Support\Selectors;

class FieldSelectors
{
    const first_name = "//input[contains(@id,'names_first_name_')]";
    const last_name = "//input[contains(@id,'names_last_name_')]";
    const email = "//input[contains(@id,'email')]";
    const address_line_1 = "//input[contains(@id,'address_line_1_')]";
    const address_line_2 = "//input[contains(@id,'address_line_2_')]";
    const city = "//input[contains(@id,'city_')]";
    const state = "//input[contains(@id,'state_')]";
    const zip = "//input[contains(@id,'zip_')]";
    const country = "//select[contains(@id,'country_')]";
    const phone = "//input[contains(@id,'phone')]";
    const submitButton = "//button[normalize-space()='Submit Form']";
}