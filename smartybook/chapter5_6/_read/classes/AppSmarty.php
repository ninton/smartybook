<?php

namespace SmartyBook\chapter5_6\_read\classes;

use SmartyBC;

class AppSmarty extends SmartyBC
{
    public function __construct()
    {
        parent::__construct();

        $this->config_dir   = dirname(__FILE__) . '/../../_read/configs';
        $this->template_dir = dirname(__FILE__) . '/../../_read/templates';
        $this->compile_dir  = dirname(__FILE__) . '/../../_temp/templates_c';
        $this->cache_dir    = dirname(__FILE__) . '/../../_temp/cahce';

        $plugins_dir = $this->plugins_dir;
        $plugins_dir[] = __DIR__ . '/../../../vendor/smarty/smarty/libs/plugins';
        $plugins_dir[] = dirname(__FILE__) . '/../..';
        $this->plugins_dir = $plugins_dir;
    }
}
