<?php

/**
 * @param array{siteName: string} $siteName
 * @return string
 */
function smarty_insert_noticeText2($siteName): string
{
    return '下記バナーを自由にお使いください<br /><img src="./images/banner.gif" /><br />' . $siteName['siteName'];
}
