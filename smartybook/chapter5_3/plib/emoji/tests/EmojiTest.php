<?php

namespace SmartyBook\chapter5_3\plib\emoji\tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SmartyBook\chapter5_3\plib\emoji\Emoji;

final class EmojiTest extends TestCase
{
    #[DataProvider('emojiProvider')]
    public function test(Emoji $emoji, string $input, string $expected): void
    {
        static::assertEquals($expected, $emoji->convert($input));
    }

    public static function emojiProvider(): array
    {
        $ezweb = Emoji::singleton('i_uni16', 'e_img_num');
        $softbank = Emoji::singleton('i_uni16', 's_uni16');

        return [
            [$ezweb, '&#xE63F;', '<img localsrc="107" />'],
            [$softbank, '&#xE63F;', '&#xE049;'],
        ];
    }
}
