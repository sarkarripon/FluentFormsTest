<?php

namespace Tests\Support\Helper\Acceptance\Selectors;

class NewPage
{
    //New page creation with form short code
    const previousPageAvailable = "(//td[@class='title column-title has-row-actions column-primary page-title'])[1]";
    const selectAllCheckMark = "(//input[@id='cb-select-all-1'])[1]";
    const selectMoveToTrash = "(//select[@id='bulk-action-selector-top'])[1]";
    const applyBtn = "(//input[@id='doaction'])[1]";
    const formShortCode = "(//code[@title='Click to copy shortcode'])[1]";
    const addNewPage = ".page-title-action";
    const jsForTitle = 'wp.data.dispatch("core/editor").editPost({title: "%s"})';
    const jsForContent = "wp.data.dispatch('core/block-editor').insertBlock(wp.blocks.createBlock('core/paragraph',{content:'%s'}))";
    const publishBtn = "(//button[normalize-space()='Publish'])[1]";
    const confirmPublish = "(//button[@class='components-button editor-post-publish-button editor-post-publish-button__button is-primary'])[1]";
    const viewPage = "a[class='components-button is-primary']";
}