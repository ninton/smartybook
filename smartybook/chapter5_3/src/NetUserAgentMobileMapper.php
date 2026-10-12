<?php

declare(strict_types=1);

namespace SmartyBook\chapter5_3\src;

use App\PearStub\NetUserAgentMobileCommonStub;

final readonly class NetUserAgentMobileMapper
{
    /**
     * @return array{rawCarrier: string, carrierName: string, imageSizeGroup: string}
     */
    public static function toDto(NetUserAgentMobileCommonStub $agent): array
    {
        $rawCarrier = strtolower($agent->getCarrierLongName());


        return [
            'rawCarrier' => $rawCarrier,
            'carrierName' => self::toCarrierName($rawCarrier),
            'imageSizeGroup' => self::determineImageSizeGroup($agent->getDisplay()->getWidth()),
        ];
    }

    private static function toCarrierName(string $rawCarrier): string
    {
        return match ($rawCarrier) {
            'docomo' => 'imode',
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
