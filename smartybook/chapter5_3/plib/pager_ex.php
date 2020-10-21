<?php
// Pagerクラスを拡張する
// 使い方、必要な箇所で require/include する
$links = $pager->getLinks();

$pager->ExOffsetFrom   = $from;
$pager->ExOffsetTo     = $to;

$pager->ExLinks = $links['pages'];
$pager->ExFirstPageLink    = '';
$pager->ExLastPageLink     = '';
$pager->ExPreviousPageLink = '';
$pager->ExNextPageLink     = '';

if ( preg_match('/href="(.*?)"/', $links['first'], $matches) ) {
	$pager->ExFirstPageLink    = $matches[1];
}
if ( preg_match('/href="(.*?)"/', $links['last'], $matches) ) {
	$pager->ExLastPageLink    = $matches[1];
}
if ( preg_match('/href="(.*?)"/', $links['back'], $matches) ) {
	$pager->ExPreviousPageLink    = $matches[1];
}
if ( preg_match('/href="(.*?)"/', $links['next'], $matches) ) {
	$pager->ExNextPageLink    = $matches[1];
}

?>