<?php

class AppSmarty extends Smarty
{
    public function __construct()
    {
        $this->config_dir   = dirname(__FILE__) . '/../../_read/configs';
        $this->template_dir = dirname(__FILE__) . '/../../_read/templates';
        $this->compile_dir  = dirname(__FILE__) . '/../../_temp/templates_c';
        $this->cache_dir    = dirname(__FILE__) . '/../../_temp/cahce';
        $this->plugins_dir[] = dirname(__FILE__) . '/../../';
    }
}
