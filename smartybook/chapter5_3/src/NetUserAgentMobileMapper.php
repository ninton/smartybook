<?php

declare(strict_types=1);

namespace SmartyBook\chapter5_3\src;

use App\PearStub\NetUserAgentMobileCommonStub;

final readonly class NetUserAgentMobileMapper
{
    /**
     * @return array{carrierLongName: string, carrierName: string, imageSizeGroup: string}
     */
    public static function toDto(NetUserAgentMobileCommonStub $agent): array
    {
        $carrierLongName = strtolower($agent->getCarrierLongName());


        return [
            'carrierLongName' => $carrierLongName,
            'carrierName' => self::toCarrierName($carrierLongName),
            'imageSizeGroup' => self::determineImageSizeGroup($agent->getDisplay()->getWidth()),
        ];
    }

    private static function toCarrierName(string $carrierLongName): string
    {
        return match ($carrierLongName) {
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
