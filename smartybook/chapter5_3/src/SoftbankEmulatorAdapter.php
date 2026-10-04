<?php

declare(strict_types=1);

namespace SmartyBook\chapter5_3\src;

/**
 * SoftBankウェブコンテンツビューア（Windowsエミュレータ）向け互換性アダプター
 *
 * 【歴史的背景】
 * J-PHONE / Vodafone / SoftBank と会社は変わりましたが、互換性のため HTTP_X_JPHONE_* ヘッダーが維持されていました。
 *
 * 2000年代後半のガラケー開発において、SoftBankの公式エミュレータ
 * （ウェブコンテンツビューア）は `HTTP_X_EMULATOR_*` 形式の独自リクエストヘッダーを出力していました。
 *
 * しかし、当時標準的に使われていたモバイル判定ライブラリ `PEAR::Net_UserAgent_Mobile` は
 * 実機のヘッダー（`HTTP_X_JPHONE_*`）しか認識できず、エミュレータ上の端末情報を取得できませんでした。
 *
 * 本クラスは、ヘッダーを複製・偽装することで `PEAR::Net_UserAgent_Mobile` に
 * 実機からのアクセスと誤認させ、開発環境での動作確認を可能にするためのレガシーパッチです。
 *
 * @deprecated 現代のWeb開発では利用されませんが、当時のケータイWeb開発技法を記録する歴史的資料として保持されています。
 * @link https://pear.php.net/package/Net_UserAgent_Mobile PEAR::Net_UserAgent_Mobile
 */
final class SoftbankEmulatorAdapter
{
    /**
     * エミュレータ固有のヘッダー（HTTP_X_EMULATOR_*）を
     * 実機互換ヘッダー（HTTP_X_JPHONE_*）へコピーして $_SERVER に再設定する
     */
    public static function emulateJPhoneHeaders(): void
    {
        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_X_EMULATOR_')) {
                $jphoneKey = str_replace('HTTP_X_EMULATOR_', 'HTTP_X_JPHONE_', $key);
                $_SERVER[$jphoneKey] = $value;
            }
        }
    }
}
