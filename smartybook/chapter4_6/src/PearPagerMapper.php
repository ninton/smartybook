<?php

namespace SmartyBook\chapter4_6\src;

use App\PearStub\PagerStub as Pager;

/**
 * PagerStubオブジェクトを PagerDto にマッピングするクラス
 *
 * 設計のポイント
 * 変換クラスの名前を PagerDtoFactory ではなく PearPagerMapper としました。
 * 単に「DTOを作るクラス」と抽象化するのではなく、「PEAR Pagerの仕様に依存した変換処理であること」をクラス名に刻むためです。
 * これにより、将来PEAR Pager自体を別のモダンなページネータに刷新する際、「このクラスはPEAR廃止と共に捨てて良い」ことが
 * クラス名だけで即座に判断でき、コードの掃除（デコミッショニング）が容易になります。
 */
final class PearPagerMapper
{
    public static function toDto(Pager $pager, int $from, int $to): PagerDto
    {
        $pagerDto = new PagerDto();
        $pagerDto->ExOffsetFrom   = $from;
        $pagerDto->ExOffsetTo     = $to;
        $links = $pager->getLinks();
        $pagerDto->ExLinks = $links['pages'];
        $pagerDto->ExFirstPageLink    = '';
        $pagerDto->ExLastPageLink     = '';
        $pagerDto->ExPreviousPageLink = '';
        $pagerDto->ExNextPageLink     = '';

        if (preg_match('/href="(.*?)"/', $links['first'], $matches)) {
            $pagerDto->ExFirstPageLink    = $matches[1];
        }
        if (preg_match('/href="(.*?)"/', $links['last'], $matches)) {
            $pagerDto->ExLastPageLink    = $matches[1];
        }
        if (preg_match('/href="(.*?)"/', $links['back'], $matches)) {
            $pagerDto->ExPreviousPageLink    = $matches[1];
        }
        if (preg_match('/href="(.*?)"/', $links['next'], $matches)) {
            $pagerDto->ExNextPageLink    = $matches[1];
        }
        return $pagerDto;
    }
}
