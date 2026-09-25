<?php

declare(strict_types=1);

namespace Lib\PearStub;

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
    private array $itemData;

    public function __construct(array $options = [])
    {
        $this->itemData     = $options['itemData'] ?? [];
        $this->totalItems   = $options['totalItems'] ?? count($this->itemData);
        $this->perPage      = max(1, (int)($options['perPage'] ?? 5));
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
     * 前のページの番号を取得（なければ false）
     */
    public function getPreviousPageID(): int|false
    {
        return $this->isFirstPage() ? false : $this->currentPage - 1;
    }

    /**
     * 次のページの番号を取得（なければ false）
     */
    public function getNextPageID(): int|false
    {
        return $this->isLastPage() ? false : $this->currentPage + 1;
    }

    /**
     * 現在のページに対応するデータ（itemDataを指定した場合）を取得
     */
    public function getPageData(): array
    {
        if (empty($this->itemData)) {
            return [];
        }
        $offset = ($this->currentPage - 1) * $this->perPage;
        return array_slice($this->itemData, $offset, $this->perPage);
    }

    /**
     * 現在のページで表示しているアイテムの開始・終了インデックス等を取得
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
            'pages' => [],
        ];

        if ($totalPages <= 1) {
            return $links;
        }

        // HTMLリンク生成用の内部関数
        $buildUrl = function(int $page) {
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
                $links['pages'][$p] = [
                    'number' => $p,
                    'isCurrent' => true,
                    'url' => ''
                ];
            } else {
                $url = $buildUrl($p);
                $pageHtmlArr[] = '<a href="' . htmlspecialchars($url) . '">' . $p . '</a>';
                $links['pages'][$p] = [
                    'number' => $p,
                    'isCurrent' => false,
                    'url' => $url
                ];
            }
        }

        // PEAR::Pager の $links['pages'] 相当のHTML文字列を連結
        $allHtml = array_filter([
            $links['first'],
            $links['back'],
            implode(' ', $pageHtmlArr),
            $links['next'],
            $links['last']
        ]);
        $links['pages'] = implode(' ', $allHtml);

        return $links;
    }

    public function getPerPageSelectBox($start=5, $end=30, $step=5, $showAllData=false, $extraParams=array()): string
    {
        return <<<HTML
<select name="setPerPage" onchange='document.forms["perPage"].submit()'><option value="1">1件/ページ</option><option value="2">2件/ページ</option><option value="3">3件/ページ</option><option value="4">4件/ページ</option><option value="5" selected="selected">5件/ページ</option><option value="6">6件/ページ</option><option value="7">7件/ページ</option><option value="8">8件/ページ</option><option value="9">9件/ページ</option><option value="10">10件/ページ</option><option value="11">11件/ページ</option><option value="12">12件/ページ</option><option value="13">13件/ページ</option><option value="14">14件/ページ</option><option value="15">15件/ページ</option><option value="16">16件/ページ</option><option value="17">17件/ページ</option><option value="18">18件/ページ</option><option value="19">19件/ページ</option><option value="20">20件/ページ</option><option value="7">7件/ページ</option></select>
HTML;
    }

    public function getPageSelectBox($params = array(), $extraAttributes = ''): string
    {
        return <<<HTML
<select name="pageID" onchange="document.location.href='/smartybook/chapter4_6/index.php?pageID=' + this.options[this.selectedIndex].value + ''"><option value="1" selected="selected">1</option><option value="2">2</option></select>
HTML;
    }
}
