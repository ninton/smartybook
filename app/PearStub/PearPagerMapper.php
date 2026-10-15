<?php

declare(strict_types=1);

namespace App\PearStub;

use App\Pager\PagerDto;
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
    public static function toDto(Pager $pager): PagerDto
    {
        list($offsetFrom, $offsetTo) = $pager->getOffsetByPageId();
        $links = $pager->getLinks();

        return new PagerDto(
            currentPageID: $pager->getCurrentPageID(),
            numPages: $pager->numPages(),
            offsetFrom:       $offsetFrom,
            offsetTo:         $offsetTo,
            links:            $links['pages'] ?? '',
            firstPageHref:    self::extractHref($links['first'] ?? ''),
            lastPageHref:     self::extractHref($links['last'] ?? ''),
            previousPageHref: self::extractHref($links['back'] ?? ''),
            nextPageHref:     self::extractHref($links['next'] ?? ''),
        );
    }

    private static function extractHref(string $html): string
    {
        if (preg_match('/href="(.*?)"/', $html, $matches)) {
            return $matches[1];
        }
        return '';
    }
}
