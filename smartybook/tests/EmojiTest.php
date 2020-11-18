<?php

// phpcs:disable PSR1.Files.SideEffects

namespace SmartyBook\Tests;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/simpletest/simpletest/autorun.php';

use UnitTestCase;
use SmartyBook\chapter5_3\plib\emoji\Emoji;

class EmojiTest extends UnitTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function test()
    {
        $emoji = Emoji::singleton('i_uni16', 'e_img_num');
        $this->assertEqual('<img localsrc="107" />', $emoji->convert('&#xE63F;'));

        $emoji = Emoji::singleton('i_uni16', 's_uni16');
        $this->assertEqual('&#xE049;', $emoji->convert('&#xE63F;'));
    }
}
