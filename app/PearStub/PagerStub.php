<?php

declare(strict_types=1);

namespace App\PearStub;

/**
 * PEAR::Pager 互換用 軽量ページネーションクラス
 * PHP 8.x 対応
 */
class PagerStub
{
    private int $totalItems;
    private int $perPage;
    private int $currentPage;
    private int $delta;
    private string $urlVar;
    private string $path;
    private string $fileName;
    /** @var list<mixed> */
    private array $itemData;

    /**
     * @param array<string, mixed> $options ページネーションのオプション
     */
    public function __construct(array $options = [])
    {
        $this->itemData     = $options['itemData'] ?? [];
        $this->totalItems   = $options['totalItems'] ?? count($this->itemData);
        $this->perPage      = max(1, (int)($options['perPage'] ?? ($_REQUEST['setPerPage'] ?? 5)));
        $this->delta        = max(1, (int)($options['delta'] ?? 2));
        $this->urlVar       = $options['urlVar'] ?? 'pageID';

        // URL構築用パラメータ
        $this->path         = $options['path'] ?? '';
        $this->fileName     = $options['fileName'] ?? '%d';

        // 現在ページの取得（GETパラメータより）
        $currentPage = isset($_GET[$this->urlVar]) ? (int)$_GET[$this->urlVar] : ($options['currentPage'] ?? 1);
        $this->currentPage  = max(1, min($currentPage, $this->numPages()));
    }

    /**
     * PEAR::Pager::factory 互換ファクトリメソッド
     * @param array<string, int|string> $options ページネーションのオプション
     * @return PagerStub 新しいPagerStubインスタンス
     */
    public static function factory(array $options = []): PagerStub
    {
        return new self($options);
    }

    /**
     * 総アイテム数を取得
     */
    public function numItems(): int
    {
        return $this->totalItems;
    }

    /**
     * 全ページ数を取得
     */
    public function numPages(): int
    {
        return (int)ceil($this->totalItems / $this->perPage);
    }

    /**
     * 現在のページ番号を取得
     */
    public function getCurrentPageID(): int
    {
        return $this->currentPage;
    }

    /**
     * 最初のページか判定
     */
    public function isFirstPage(): bool
    {
        return $this->currentPage === 1;
    }

    /**
     * 最後のページか判定
     */
    public function isLastPage(): bool
    {
        return $this->currentPage === $this->numPages() || $this->numPages() === 0;
    }

    /**
     * 現在のページで表示しているアイテムの開始・終了インデックス等を取得
     * @return array{0: int, 1: int} 現在のページで表示しているアイテムの開始・終了インデックス
     */
    public function getOffsetByPageId(): array
    {
        if ($this->totalItems === 0) {
            return [0, 0];
        }
        $from = ($this->currentPage - 1) * $this->perPage + 1;
        $to   = min($this->currentPage * $this->perPage, $this->totalItems);
        return [$from, $to];
    }

    /**
     * ページナビゲーション用リンクHTML / 構造化データを取得
     * @return array{
     *     all: string,
     *     first: string,
     *     back: string,
     *     next: string,
     *     last: string,
     *     pages: string,
     * } ページナビゲーション用リンクの配列
     */
    public function getLinks(): array
    {
        $totalPages = $this->numPages();
        $links = [
            'all'   => '',
            'first' => '',
            'back'  => '',
            'next'  => '',
            'last'  => '',
            'pages' => '',
        ];

        if ($totalPages <= 1) {
            return $links;
        }

        // HTMLリンク生成用の内部関数
        $buildUrl = function (int $page) {
            $params = $_GET;
            $params[$this->urlVar] = $page;
            $queryString = http_build_query($params);

            if ($this->path !== '') {
                $file = str_replace('%d', (string)$page, $this->fileName);
                return rtrim($this->path, '/') . '/' . $file . ($queryString ? '?' . $queryString : '');
            }
            return '?' . $queryString;
        };

        // Prev / Next リンク
        if (!$this->isFirstPage()) {
            $links['first'] = '<a href="' . htmlspecialchars($buildUrl(1)) . '">&lt;&lt; 最初</a>';
            $links['back']  = '<a href="' . htmlspecialchars($buildUrl($this->currentPage - 1)) . '">&lt; 前へ</a>';
        }

        if (!$this->isLastPage()) {
            $links['next']  = '<a href="' . htmlspecialchars($buildUrl($this->currentPage + 1)) . '">次へ &gt;</a>';
            $links['last']  = '<a href="' . htmlspecialchars($buildUrl($totalPages)) . '">最後 &gt;&gt;</a>';
        }

        // ページ番号リンク（Sliding スタイル風）
        $start = max(1, $this->currentPage - $this->delta);
        $end   = min($totalPages, $this->currentPage + $this->delta);

        $pageHtmlArr = [];
        for ($p = $start; $p <= $end; $p++) {
            if ($p === $this->currentPage) {
                $pageHtmlArr[] = $p;
            } else {
                $url = $buildUrl($p);
                $pageHtmlArr[] = '<a href="' . htmlspecialchars($url) . '">' . $p . '</a>';
            }
        }

        $links['pages'] = implode(' ', $pageHtmlArr);

        return $links;
    }
}
