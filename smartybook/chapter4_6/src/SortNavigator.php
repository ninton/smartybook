<?php

namespace SmartyBook\chapter4_6\src;

/**
 *  昇順・降順ボタンを表示する
 */
class SortNavigator
{
    private string $sortKey;
    private string $order;
    /** @var array<string, string> */
    private array $vars;

    public function __construct(string $sortKey, string $order)
    {
        $this->vars['asc_current' ] = '△';
        $this->vars['asc_link'    ] = '▲';
        $this->vars['asc_title'   ] = '昇順';
        $this->vars['desc_current'] = '▽';
        $this->vars['desc_link'   ] = '▼';
        $this->vars['desc_title'  ] = '降順';
        $this->vars['separator'   ] = '';

        $this->vars['sortKeyUrlVar' ] = 'sort_key';
        $this->vars['orderUrlVar'] = 'sort_direction';

        $this->sortKey  = $sortKey;
        $this->order = $order;
    }

    public function setOption(string $key, string $value): void
    {
        if (isset($this->vars[$key])) {
            $this->vars[$key] = $value;
        }
    }

    public function show(string $sortKey): void
    {
        $asc_navi  = $this->showLink($sortKey, 'asc');
        $desc_navi = $this->showLink($sortKey, 'desc');

        $buf = $asc_navi . $this->vars['separator'] . $desc_navi;
        print $buf;
    }

    public function showLink(string $sortKey, string $order): string
    {
        if (($sortKey == $this->sortKey) && ($order == $this->order)) {
            if ($order == 'asc') {
                $text  = $this->vars['asc_current'];
            } else {
                $text  = $this->vars['desc_current'];
            }
            $buf = $text;
        } else {
            if ($order == 'asc') {
                $text  = $this->vars['asc_link' ];
                $title = $this->vars['asc_title'];
            } else {
                $text  = $this->vars['desc_link' ];
                $title = $this->vars['desc_title'];
            }

            $vars = [
                $this->vars['sortKeyUrlVar' ] => $sortKey,
                $this->vars['orderUrlVar'] => $order,
                'pageID'                   => 1,
            ];
            $html = [];
            $html['href' ] = $_SERVER['SCRIPT_NAME'] . '?' . $this->replaceQuery($_SERVER['QUERY_STRING'], $vars);
            $html['title'] = $title;
            $html['text' ] = $text;

            $buf = <<<EOT
<a href="{$html['href']}" title="{$html['title']}">{$html['text']}</a>
EOT;
            $buf = ltrim($buf);
        }

        return $buf;
    }

    /**
     * @param array<string, string> $vars
     */
    public function replaceQuery(string $query, array $vars): string
    {
        $tmpVars = [];
        parse_str($query, $tmpVars);

        foreach ($vars as $key => $val) {
            $tmpVars[$key] = $val;
        }

        $buf = http_build_query($tmpVars);
        return $buf;
    }
}
