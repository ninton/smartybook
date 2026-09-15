<?php

namespace SmartyBook\chapter5_3\plib\emoji\tests;

use SmartyBook\chapter5_3\plib\emoji\Emoji;
use PHPUnit\Framework\TestCase;

final class EmojiTest extends TestCase
{
    public function test(): void
    {
        $emoji = Emoji::singleton('i_uni16', 'e_img_num');
        static::assertEquals('<img localsrc="107" />', $emoji->convert('&#xE63F;'));

        $emoji = Emoji::singleton('i_uni16', 's_uni16');
        static::assertEquals('&#xE049;', $emoji->convert('&#xE63F;'));
    }
}
