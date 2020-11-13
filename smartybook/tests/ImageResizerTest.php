<?php

namespace SmartyBook\Tests;

use UnitTestCase;
use SmartyBook\chapter5_3\plib\ImageResizer;

/**
 * Class ImageResizerTest
 * @package SmartyBook\Tests
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ImageResizerTest extends UnitTestCase
{
    /**
     * @test
     */
    public function test_get_scale_type()
    {
        // 最大枠より、幅・高さ、どちらも小さい
        $this->assertEqual(0, ImageResizer::get_scale_type(90, 90, 100, 100));

        // 最大枠より、幅だけが大きい
        $this->assertEqual(1, ImageResizer::get_scale_type(200, 100, 100, 100));

        // 最大枠より、高さだけが大きい
        $this->assertEqual(2, ImageResizer::get_scale_type(100, 200, 100, 100));

        // 最大枠より、幅・高さのどちらも大きいが、幅を最大枠に合わせる
        $this->assertEqual(3, ImageResizer::get_scale_type(300, 200, 100, 100));

        // 最大枠より、幅・高さのどちらも大きいが、高さを最大枠に合わせる
        $this->assertEqual(4, ImageResizer::get_scale_type(200, 300, 100, 100));
    }

    /**
     * @test
     */
    public function test_scale()
    {
        // 最大枠より、幅・高さ、どちらも小さい
        $this->assertEqual(array(90, 90), ImageResizer::scale(0, 90, 90, 100, 100));

        // 最大枠より、幅だけが大きい
        $this->assertEqual(array(100, 50), ImageResizer::scale(1, 200, 100, 100, 100));

        // 最大枠より、高さだけが大きい
        $this->assertEqual(array(50, 100), ImageResizer::scale(2, 100, 200, 100, 100));

        // 最大枠より、幅・高さのどちらも大きいが、幅を最大枠に合わせる
        $this->assertEqual(array(100, 50), ImageResizer::scale(3, 400, 200, 100, 100));

        // 最大枠より、幅・高さのどちらも大きいが、高さを最大枠に合わせる
        $this->assertEqual(array(50, 100), ImageResizer::scale(4, 200, 400, 100, 100));
    }

    /**
     * @test
     */
    public function test_image_resize()
    {
        $src = __DIR__ . "/fixtures/sample_230x153.jpg";
        $dst = "/tmp/test_max100x100.jpg";
        if (file_exists($dst)) {
            unlink($dst);
        }
        $this->assertFalse(file_exists($dst));

        ImageResizer::image_resize($src, $dst, 100, 100);

        $this->assertTrue(file_exists($dst));

        list($width, $height) = getimagesize($dst);
        $this->assertEqual(array(100, 66), array($width, $height));
    }
}
