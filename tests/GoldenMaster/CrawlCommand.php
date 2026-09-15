<?php

declare(strict_types=1);

namespace Tests\GoldenMaster;

final class CrawlCommand
{
    public string $title;
    public string $method;
    public string $url;
    public string $data;

    public function __construct(
        string $title,
        string $method,
        string $url,
        string $data
    ) {
        $this->title = $title;
        $this->method = $method;
        $this->url = $url;
        $this->data = $data;
    }
}
