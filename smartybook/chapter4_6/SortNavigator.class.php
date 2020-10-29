<?php

/**
 *  昇順・降順ボタンを表示する
 */
class SortNavigator
{
    private $sort;
    private $order;
    private $vars;

    /**
     *  @param  string
     *  @param  string
     *  @return void
     */
    public function __construct($i_sort, $i_order)
    {
        $this->vars['asc_current' ] = '△';
        $this->vars['asc_link'    ] = '▲';
        $this->vars['desc_current'] = '▽';
        $this->vars['desc_link'   ] = '▼';
        $this->vars['separator'   ] = '';

        $this->vars['sortUrlVar' ] = 'sort';
        $this->vars['orderUrlVar'] = 'order';
//      $this->vars['sortDefVal' ] = '';
//      $this->vars['orderDefVal'] = 'asc';

        $this->sort  = $i_sort;
        $this->order = $i_order;
    }

    /**
     *  @param  string
     *  @param  string
     *  @return void
     */
    public function setOption($i_key, $i_value)
    {
        if (isset($this->vars[$i_key])) {
            $this->vars[$i_key] = $i_value;
        }
    }

    /**
     *  @param  string
     *  @return string
     */
    public function show($i_sort)
    {
        $asc_navi  = $this->showLink($i_sort, "asc");
        $desc_navi = $this->showLink($i_sort, "desc");

        $buf = $asc_navi . $this->vars['separator'] . $desc_navi;
        print $buf;
    }

    /**
     *  @param  string
     *  @param  string
     *  @return string
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

            $vars = array(
                $this->vars['sortUrlVar' ] => $i_sort,
                $this->vars['orderUrlVar'] => $i_order,
                'pageID' => 1
                );
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
     *  @param  string
     *  @param  array
     *  @return string
     */
    public function replaceQuery($i_query, $i_vars)
    {
        parse_str($i_query, $vars);

        foreach ($i_vars as $key => $val) {
            $vars[$key] = $val;
        }

        $buf = http_build_query($vars);
        return $buf;
    }
}
