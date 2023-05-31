<?php

namespace Tests\Support\Helper\Acceptance\Selectors;

class DeleteFormSelec
{
    //existing form delete buttons
    const mouseHoverMenu = "(//div[contains(@class,'cell')])[8]";
    const deleteBtn = "(//a[contains(text(),'Delete')])[1]";
//    const confirmBtn = "[class='el-popover el-popper']:last-child button:last-child";
const  confirmBtn = "(//span[contains(text(),'confirm')])[1]";
}