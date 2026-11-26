<?php

declare(strict_types=1);

namespace Tests\GoldenMaster;

final class CrawlCommand
{
    public string $title;
    public string $httpMethod;
    public string $url;
    public string $data;

    public function __construct(
        string $title,
        string $httpMethod,
        string $url,
        string $data,
    ) {
        $this->title = $title;
        $this->httpMethod = $httpMethod;
        $this->url = $url;
        $this->data = $data;
    }
}
