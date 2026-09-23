<?php

/**
 * Pagerオブジェクトを拡張して追加のページング情報を設定します
 * @fixme chapter4_6 の PagerDtoクラスを返すようにリファクタリングすることで、引数の $pager は pagerクラス、戻り値は PagerDtoクラスを指定できるようになります
 *
 * @param object $pager Pagerオブジェクト
 * @param int $from_page 表示開始位置
 * @param int $to_page 表示終了位置
 * @return object 拡張されたPagerオブジェクト
 */
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
