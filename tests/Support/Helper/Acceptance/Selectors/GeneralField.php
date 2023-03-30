<?php

namespace Tests\Support\Helper\Acceptance\Selectors;

class GeneralField
{
    //general fields
    const gnrlField = "(//h5[normalize-space()='General Fields'])[1]";
    const nameField = "//div[@class='vddl-draggable btn-element'][normalize-space()='Name Fields']";
    const emailField = "div[class='option-fields-section option-fields-section_active'] div[class='option-fields-section--content'] div:nth-child(1) div:nth-child(2) div:nth-child(1)";
    const simpleText = "div[class='option-fields-section option-fields-section_active'] div[class='option-fields-section--content'] div:nth-child(1) div:nth-child(3) div:nth-child(1)";
    const maskInput = "body > div:nth-child(3) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(1) > div:nth-child(1) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(1)";
    const textArea = "body > div:nth-child(3) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(1) > div:nth-child(1) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1)";
    const addressField = "body > div:nth-child(3) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(1) > div:nth-child(1) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(3) > div:nth-child(1)";
    const countryList = "div[class='option-fields-section option-fields-section_active'] div:nth-child(3) div:nth-child(1) div:nth-child(1)";
    const numaricField = "div[class='option-fields-section option-fields-section_active'] div:nth-child(3) div:nth-child(2) div:nth-child(1)";
    const dropdown = "div[class='option-fields-section option-fields-section_active'] div:nth-child(3) div:nth-child(3) div:nth-child(1)";
    const radioBtn = "div[class='option-fields-section option-fields-section_active'] div:nth-child(4) div:nth-child(1) div:nth-child(1)";
    const checkbox = "div[class='option-fields-section option-fields-section_active'] div:nth-child(4) div:nth-child(2) div:nth-child(1)";
    const multipleChoice = "div[class='option-fields-section option-fields-section_active'] div:nth-child(4) div:nth-child(3) div:nth-child(1)";
    const websiteUrl = "div[class='option-fields-section option-fields-section_active'] div:nth-child(5) div:nth-child(1) div:nth-child(1)";
    const timeDate = "div[class='option-fields-section option-fields-section_active'] div:nth-child(5) div:nth-child(2) div:nth-child(1)";
    const imageUpload = "div[class='option-fields-section option-fields-section_active'] div:nth-child(5) div:nth-child(3) div:nth-child(1)";
    const fileUpload = "div[class='option-fields-section option-fields-section_active'] div:nth-child(6) div:nth-child(1) div:nth-child(1)";
    const customHtml = "div[class='option-fields-section option-fields-section_active'] div:nth-child(6) div:nth-child(2) div:nth-child(1)";
    const phoneField = "div[class='option-fields-section option-fields-section_active'] div:nth-child(6) div:nth-child(3) div:nth-child(1)";
}