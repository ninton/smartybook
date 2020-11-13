<?php

// Pagerクラスを拡張する

function pager_ex($pager, $from_page, $to_page)
{
    $links = $pager->getLinks();

    $pager->ExOffsetFrom   = $from_page;
    $pager->ExOffsetTo     = $to_page;
    $pager->ExLinks = $links['pages'];
    $pager->ExFirstPageLink    = '';
    $pager->ExLastPageLink     = '';
    $pager->ExPreviousPageLink = '';
    $pager->ExNextPageLink     = '';

    if (preg_match('/href="(.*?)"/', $links['first'], $matches)) {
        $pager->ExFirstPageLink    = $matches[1];
    }
    if (preg_match('/href="(.*?)"/', $links['last'], $matches)) {
        $pager->ExLastPageLink    = $matches[1];
    }
    if (preg_match('/href="(.*?)"/', $links['back'], $matches)) {
        $pager->ExPreviousPageLink    = $matches[1];
    }
    if (preg_match('/href="(.*?)"/', $links['next'], $matches)) {
        $pager->ExNextPageLink    = $matches[1];
    }

    return $pager;
}
