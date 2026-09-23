<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/smartybook',
        __DIR__ . '/tests',
    ])
    ->withSkip([
        __DIR__ . '/smartybook/*/templates_c/*',
        __DIR__ . '/lib',
        __DIR__ . '/vendor',
    ])
    // phpstan.dist.neon の型情報（PHPDoc から推論した型）を Rector の推論にも使う
    ->withPHPStanConfigs([
        __DIR__ . '/phpstan.dist.neon',
    ])

    ->withPhpVersion(\Rector\ValueObject\PhpVersion::PHP_85)
    // 0=最も安全な変換のみ。数値を上げるほど積極的な（リスクのある）変換が加わる
    ->withTypeCoverageLevel(20)
    ;
