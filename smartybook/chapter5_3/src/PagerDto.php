<?php

declare(strict_types=1);

namespace SmartyBook\chapter5_3\src;

final readonly class PagerDto
{
    public function __construct(
        public int $currentPageID = 0,
        public int $numPages = 0,
        public int $offsetFrom = 0,
        public int $offsetTo = 0,
        public string $links = '',
        public string $firstPageHref = '',
        public string $lastPageHref = '',
        public string $previousPageHref = '',
        public string $nextPageHref = '',
    ) {
    }
}
