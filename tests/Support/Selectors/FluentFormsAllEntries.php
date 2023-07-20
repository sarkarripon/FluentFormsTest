<?php
namespace Tests\Support\Selectors;
class FluentFormsAllEntries
{
    const entriesPage = "wp-admin/admin.php?page=fluent_forms_all_entries";
    const viewEntry = "(//span[contains(text(),'View')])[1]";
    const apiCalls = "(//span[normalize-space()='API Calls'])[1]";
    const logStatus = "//span[contains(@class,'ff_tag log_')]";

}
