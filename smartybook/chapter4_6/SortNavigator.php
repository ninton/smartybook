<?php

namespace SmartyBook\chapter4_6;

/**
 *  昇順・降順ボタンを表示する
 */
class SortNavigator
{
    /** @var string */
    private $sort;
    /** @var string */
    private $order;
    /** @var array<string, string> */
    private $vars;

    /**
     *  @param string $i_sort
     *  @param string $i_order
     *  @return void
     */
    public function __construct($i_sort, $i_order)
    {
        $this->vars['asc_current' ] = '△';
        $this->vars['asc_link'    ] = '▲';
        $this->vars['asc_title'   ] = '昇順';
        $this->vars['desc_current'] = '▽';
        $this->vars['desc_link'   ] = '▼';
        $this->vars['desc_title'  ] = '降順';
        $this->vars['separator'   ] = '';

        $this->vars['sortUrlVar' ] = 'sort';
        $this->vars['orderUrlVar'] = 'order';

        $this->sort  = $i_sort;
        $this->order = $i_order;
    }

    /**
     *  @param string $i_key
     *  @param string $i_value
     *  @return void
     */
    public function setOption($i_key, $i_value)
    {
        if (isset($this->vars[$i_key])) {
            $this->vars[$i_key] = $i_value;
        }
    }

    /**
     *  @param string $i_sort
     *  @return void
     */
    public function show($i_sort)
    {
        $asc_navi  = $this->showLink($i_sort, 'asc');
        $desc_navi = $this->showLink($i_sort, 'desc');

        $buf = $asc_navi . $this->vars['separator'] . $desc_navi;
        print $buf;
    }

    /**
     *  @param string $i_sort
     *  @param string $i_order
     *  @return string
     *
     */
    public function showLink($i_sort, $i_order)
    {
        if (($i_sort == $this->sort) && ($i_order == $this->order)) {
            if ($i_order == 'asc') {
                $text  = $this->vars['asc_current'];
            } else {
                $text  = $this->vars['desc_current'];
            }
            $buf = $text;
        } else {
            if ($i_order == 'asc') {
                $text  = $this->vars['asc_link' ];
                $title = $this->vars['asc_title'];
            } else {
                $text  = $this->vars['desc_link' ];
                $title = $this->vars['desc_title'];
            }

            $vars = [
                $this->vars['sortUrlVar' ] => $i_sort,
                $this->vars['orderUrlVar'] => $i_order,
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
     *  @param string $i_query
     *  @param array<string, string> $i_vars
     *  @return string
     */
    public function replaceQuery($i_query, $i_vars): string
    {
        $vars = [];
        parse_str($i_query, $vars);

        foreach ($i_vars as $key => $val) {
            $vars[$key] = $val;
        }

        $buf = http_build_query($vars);
        return $buf;
    }
}
