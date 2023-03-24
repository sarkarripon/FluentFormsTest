<?php
namespace Tests\Support\Helper\Acceptance\Selectors;
abstract class AccepTestSelec
{
    const pluginPage = '/wp-admin/plugins.php';
    const fluentForm = 'fluentform.zip';
    const fluentFormPdf = 'fluentforms-pdf.zip';
    const fluentFormPro = 'fluentformpro.zip';
    const pluginInstallPage = 'wp-admin/plugin-install.php';
    const uploadField = '.upload';
    const inputField = 'input[type="file"]';

    const submitButton = '#install-plugin-submit';
    const activateButton = '.button.button-primary';
    const licenseKey = "tests/Support/Data/licensekey.txt";
    const activeNowBtn = "div[class='error error_notice_ff_fluentform_pro_license'] p";
    const licenseInputField = "input[name='_ff_fluentform_pro_license_key']";
    const activateLicenseBtn = "input[value='Activate License']";
    const licenseBtn = "form[method='post']";
    const fFormProRemoveBtn = "tr[data-slug='fluent-forms-pro-add-on-pack'] td[class='plugin-title column-primary']";
    const fFormPdfRemoveBtn = "tr[data-slug='fluentforms-pdf'] td[class='plugin-title column-primary']";
    const fFormRemoveBtn = "tr[data-slug='fluentform'] td[class='plugin-title column-primary']";
    const msg = "div[id='message'] p";

}
