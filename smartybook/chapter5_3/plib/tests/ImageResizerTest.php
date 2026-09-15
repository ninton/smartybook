<?php

namespace SmartyBook\chapter5_3\plib\tests;

use PHPUnit\Framework\TestCase;
use SmartyBook\chapter5_3\plib\ImageResizer;

final class ImageResizerTest extends TestCase
{
    public function test_get_scale_type(): void
    {
        // 最大枠より、幅・高さ、どちらも小さい
        static::assertEquals(0, ImageResizer::get_scale_type(90, 90, 100, 100));

        // 最大枠より、幅だけが大きい
        static::assertEquals(1, ImageResizer::get_scale_type(200, 100, 100, 100));

        // 最大枠より、高さだけが大きい
        static::assertEquals(2, ImageResizer::get_scale_type(100, 200, 100, 100));

        // 最大枠より、幅・高さのどちらも大きいが、幅を最大枠に合わせる
        static::assertEquals(3, ImageResizer::get_scale_type(300, 200, 100, 100));

        // 最大枠より、幅・高さのどちらも大きいが、高さを最大枠に合わせる
        static::assertEquals(4, ImageResizer::get_scale_type(200, 300, 100, 100));
    }

    public function test_scale(): void
    {
        // 最大枠より、幅・高さ、どちらも小さい
        static::assertEquals(array(90, 90), ImageResizer::scale(0, 90, 90, 100, 100));

        // 最大枠より、幅だけが大きい
        static::assertEquals(array(100, 50), ImageResizer::scale(1, 200, 100, 100, 100));

        // 最大枠より、高さだけが大きい
        static::assertEquals(array(50, 100), ImageResizer::scale(2, 100, 200, 100, 100));

        // 最大枠より、幅・高さのどちらも大きいが、幅を最大枠に合わせる
        static::assertEquals(array(100, 50), ImageResizer::scale(3, 400, 200, 100, 100));

        // 最大枠より、幅・高さのどちらも大きいが、高さを最大枠に合わせる
        static::assertEquals(array(50, 100), ImageResizer::scale(4, 200, 400, 100, 100));
    }
    
    public function test_image_resize(): void
    {
        $src = __DIR__ . "/fixtures/sample_230x153.jpg";
        $dst = "/tmp/test_max100x100.jpg";
        if (file_exists($dst)) {
            unlink($dst);
        }
        static::assertFalse(file_exists($dst));

        ImageResizer::image_resize($src, $dst, 100, 100);

        static::assertTrue(file_exists($dst));

        list($width, $height) = getimagesize($dst);
        static::assertEquals(array(100, 66), array($width, $height));
    }
}
