<?php
namespace Tests\Support\Helper\Acceptance\Selectors;
abstract class AccepTestSelec
{
    const fluentForm = 'fluentform.zip';
    const fluentFormPdf = 'fluentforms-pdf.zip';
    const fluentFormPro = 'fluentformpro.zip';
    const uploadField = '.upload';
    const inputField = 'input[type="file"]';

    const submitButton = '#install-plugin-submit';
    const activateButton = '.button.button-primary';
    const licenseKey = "tests/Support/Data/licensekey.txt";
    const activeNowBtn = "div[class='error error_notice_ff_fluentform_pro_license'] p";
    const licenseInputField = "input[name='_ff_fluentform_pro_license_key']";
    const activateLicenseBtn = "input[value='Activate License']";
    const licenseBtn = "form[method='post']";
    const msg = "div[id='message'] p";

}
