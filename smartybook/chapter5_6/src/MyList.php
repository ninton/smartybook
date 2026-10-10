<?php

declare(strict_types=1);

namespace SmartyBook\chapter5_6\src;

/**
 * リスト情報を表す。
 *
 * 想定するデータ形式:
 * - ListName: 空文字列不可、最大200文字
 * - NickName: 空文字列不可、最大200文字
 * - detail_arr: 空配列可、最大25件
 *   - ASIN: 空文字列不可、1〜13桁の数字（10桁または13桁のISBNを想定するが、誤った値や入力途中の値も許容）
 *      detail_arr 内で重複可
 *   - comment: 空文字列可、最大200文字
 *
 * 現状はこれらの制約をバリデーションしていないため、仕様外の文字列を受け入れて保持する。
 * 件数上限はチェックします。
 */
final readonly class MyList
{
    public const int MAX_ITEMS = 25;

    /**
     * @param list<array{ASIN: string, comment: string}> $detail_arr
     */
    public function __construct(
        public string $ListName = '',
        public string $NickName = '',
        public array $detail_arr = [],
    ) {
        if (count($this->detail_arr) > self::MAX_ITEMS) {
            throw new \InvalidArgumentException('detail_arr cannot have more than ' . self::MAX_ITEMS . ' items.');
        }
    }

    /**
     * @return string
     */
    public function getASINs(): string
    {
        // ASINの重複要素と空要素を取り除いて、カンマ区切りにする
        $map = [];

        foreach ($this->detail_arr as $detail) {
            if (! empty($detail['ASIN'])) {
                $map[$detail['ASIN']] = 1;
            }
        }

        return join(',', array_keys($map));
    }
}
