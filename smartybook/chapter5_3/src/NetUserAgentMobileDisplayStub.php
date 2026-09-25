<?php

declare(strict_types=1);

namespace SmartyBook\chapter5_3\src;

/**
 * 各キャリアのガラケーはサービス停止している
 * lib/の PEAR の Net_UserAgent_Mobile はもはやメンテナンスする意義が薄い
 * そのため、表示情報も固定値を返すスタブとして実装している
 */
final class NetUserAgentMobileDisplayStub
{
    public function getWidth(): int
    {
        return 120;
    }
}
