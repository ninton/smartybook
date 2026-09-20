<?php

namespace SmartyBook\chapter5_3\plib\tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SmartyBook\chapter5_3\plib\ImageResizer;

final class ImageResizerTest extends TestCase
{
    #[DataProvider('provide_get_scale_type_cases')]
    public function test_get_scale_type(int $width, int $height, int $max_width, int $max_height, int $expected): void
    {
        static::assertEquals($expected, ImageResizer::get_scale_type($width, $height, $max_width, $max_height));
    }

    /**
     * @return array<string, array<string, int>>
     */
    public static function provide_get_scale_type_cases(): array
    {
        return [
            '最大枠より、幅・高さ、どちらも小さい' => [
                'width' => 90,
                'height' => 90,
                'max_width' => 100,
                'max_height' => 100,
                'expected' => 0,
            ],
            '最大枠より、幅だけが大きい' => [
                'width' => 200,
                'height' => 100,
                'max_width' => 100,
                'max_height' => 100,
                'expected' => 1,
            ],
            '最大枠より、高さだけが大きい' => [
                'width' => 100,
                'height' => 200,
                'max_width' => 100,
                'max_height' => 100,
                'expected' => 2,
            ],
            '最大枠より、幅・高さのどちらも大きいが、幅を最大枠に合わせる' => [
                'width' => 300,
                'height' => 200,
                'max_width' => 100,
                'max_height' => 100,
                'expected' => 3,
            ],
            '最大枠より、幅・高さのどちらも大きいが、高さを最大枠に合わせる' => [
                'width' => 200,
                'height' => 300,
                'max_width' => 100,
                'max_height' => 100,
                'expected' => 4,
            ],
        ];
    }

    #[DataProvider('provide_scale_cases')]
    public function test_scale(int $scale_type, int $width, int $height, int $max_width, int $max_height, array $expected): void
    {
        static::assertEquals($expected, ImageResizer::scale($scale_type, $width, $height, $max_width, $max_height));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function provide_scale_cases(): array
    {
        return [
            '最大枠より、幅・高さ、どちらも小さい' => [
                'scale_type' => 0,
                'width' => 90,
                'height' => 90,
                'max_width' => 100,
                'max_height' => 100,
                'expected' => [90, 90],
            ],
            '最大枠より、幅だけが大きい' => [
                'scale_type' => 1,
                'width' => 200,
                'height' => 100,
                'max_width' => 100,
                'max_height' => 100,
                'expected' => [100, 50],
            ],
            '最大枠より、高さだけが大きい' => [
                'scale_type' => 2,
                'width' => 100,
                'height' => 200,
                'max_width' => 100,
                'max_height' => 100,
                'expected' => [50, 100],
            ],
            '最大枠より、幅・高さのどちらも大きいが、幅を最大枠に合わせる' => [
                'scale_type' => 3,
                'width' => 400,
                'height' => 200,
                'max_width' => 100,
                'max_height' => 100,
                'expected' => [100, 50],
            ],
            '最大枠より、幅・高さのどちらも大きいが、高さを最大枠に合わせる' => [
                'scale_type' => 4,
                'width' => 200,
                'height' => 400,
                'max_width' => 100,
                'max_height' => 100,
                'expected' => [50, 100],
            ],
        ];
    }

    public function test_image_resize(): void
    {
        $src = __DIR__ . '/fixtures/sample_230x153.jpg';
        $dst = '/tmp/test_max100x100.jpg';
        if (file_exists($dst)) {
            unlink($dst);
        }
        static::assertFalse(file_exists($dst));

        ImageResizer::image_resize($src, $dst, 100, 100);

        static::assertTrue(file_exists($dst));

        list($width, $height) = getimagesize($dst);
        static::assertEquals([100, 66], [$width, $height]);
    }
}
