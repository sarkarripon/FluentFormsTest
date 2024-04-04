<?php

namespace Tests\Support\Selectors;

class GlobalSettingsSelectors
{
    // License Page
    const licensePage = "wp-admin/admin.php?page=fluent_forms_settings&component=license_page";
    const licenseKeyInputField = "//input[@name='_ff_fluentform_pro_license_key']";
    const licenseActivateBtn = "//input[@name='_ff_fluentform_pro_license_activate']";
    const licenseDeactivateBtn = "//input[@name='_ff_fluentform_pro_license_deactivate']";

    // Double opt-in
    const doubleOptInPage = "wp-admin/admin.php?page=fluent_forms_settings#double_optin_settings";
    const adminApprovalPage = "wp-admin/admin.php?page=fluent_forms_settings#admin_approval";
    const emailLogPage = "wp-admin/admin.php?page=email-logs.php";




}