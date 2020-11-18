<?php

namespace SmartyBook\chapter5_6\_read\classes;

use Smarty;

class AppSmarty extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        $this->setConfigDir(dirname(__FILE__) . '/../../_read/configs');
        $this->setTemplateDir(dirname(__FILE__) . '/../../_read/templates');
        $this->setCompileDir(dirname(__FILE__) . '/../../_temp/templates_c');
        $this->setCacheDir(dirname(__FILE__) . '/../../_temp/cahce');

        $this->addPluginsDir(__DIR__ . '/../../../vendor/smarty/smarty/libs/plugins');
        $this->addPluginsDir(dirname(__FILE__) . '/../..');
    }
}
