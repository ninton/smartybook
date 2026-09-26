<?php

$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__ . '/bootstrap',
        __DIR__ . '/lib/PearStub',
        __DIR__ . '/smartybook',
        __DIR__ . '/tests',
    ])
    ->exclude(['templates_c', 'vendor']);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'single_quote' => true,
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'arguments', 'parameters'],
        ],

        // ----------------------------------------------------
        // インポート（use）の自動整列・グループ化ルールの強化
        // ----------------------------------------------------
        // 1. importsのソート順（クラス/関数/定数の順でソートし、アルファベット順にする）
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'function', 'const'],
        ],

        // 2. 不要な use 宣言・グローバル空間の先頭バックスラッシュ（\Smarty など）の整理
        'fully_qualified_strict_types' => true,

        // ----------------------------------------------------
        // ファイルヘッダー・PHPタグ直後の順序整理ルール
        // ----------------------------------------------------
        // 3. <?php の直後に空行を置かない
        'blank_line_after_opening_tag' => true,

        // 4. declare(strict_types=1); の直後に空行を入れる（将来導入時にも対応）
        'blank_line_after_namespace' => true,

        // 5. namespace や use 宣言ブロックの後に必ず1行空行を入れる
        'single_line_after_imports' => true,

        // ----------------------------------------------------
        // PHPDoc（アノテーション）の見た目整理
        // ----------------------------------------------------
        // 6. PHPDoc内のアノテーション（@var や @param）のインデント・型名の整列
        'phpdoc_align' => [
            'align' => 'left', // 意図しないスペース調整を防ぐため left（左揃え）を推奨
        ],
        // 7. PHPDoc の不要な空行を整理
        'phpdoc_trim' => true,
        // 8. @var アノテーションの型指定順（例: string|null）を統一
        'phpdoc_scalar' => true,

        // ----------------------------------------------------
        // require / include の制御
        // ----------------------------------------------------
        // 9. require_once ('file.php'); のカッコを外して require_once 'file.php'; に統一
        'include' => true,

        // ... その他のルール
        // dirname(__FILE__) を __DIR__ に変換
        'dir_constant' => true,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(false);
