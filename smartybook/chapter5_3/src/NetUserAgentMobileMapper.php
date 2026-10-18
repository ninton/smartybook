<?php

declare(strict_types=1);

namespace SmartyBook\chapter5_3\src;

use App\PearStub\NetUserAgentMobileCommonStub;

final readonly class NetUserAgentMobileMapper
{
    /**
     * @return array{rawCarrier: string, platformType: string, imageSizeGroup: string}
     */
    public static function toDto(NetUserAgentMobileCommonStub $agent): array
    {
        $rawCarrier = strtolower($agent->getCarrierLongName());


        return [
            'rawCarrier' => $rawCarrier,
            'platformType' => self::toPlatformType($rawCarrier),
            'imageSizeGroup' => self::determineImageSizeGroup($agent->getDisplay()->getWidth()),
        ];
    }

    private static function toPlatformType(string $rawCarrier): string
    {
        return match ($rawCarrier) {
            'ezweb' => 'ezweb',
            'softbank', 'vodafone' => 'softbank',
            default => 'imode',
        };
    }

    // 画面幅から画像サイズを判断する
    private static function determineImageSizeGroup(int $width): string
    {
        if ($width < 180) {
            return '120';
        } elseif ($width < 360) {
            return '240';
        } else {
            return '480';
        }
    }
}
