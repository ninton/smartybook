<?php

declare(strict_types=1);

namespace SmartyBook\chapter4_6\src;

final readonly class PagerDto
{
    public function __construct(
        public int $ExOffsetFrom = 0,
        public int $ExOffsetTo = 0,
        public string $ExLinks = '',
        public string $ExFirstPageLink = '',
        public string $ExLastPageLink = '',
        public string $ExPreviousPageLink = '',
        public string $ExNextPageLink = '',
    ) {
    }
}
