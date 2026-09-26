<?php

namespace SmartyBook\chapter5_6\_read\classes;

use Smarty\Smarty;

class AppSmarty extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        $this->setConfigDir(__DIR__ . '/../../_read/configs');
        $this->setTemplateDir(__DIR__ . '/../../_read/templates');
        $this->setCompileDir(__DIR__ . '/../../_temp/templates_c');
        $this->setCacheDir(__DIR__ . '/../../_temp/cache');

        include_once __DIR__ . '/../../modifier.mb_truncate.php';
        $this->registerPlugin('modifier', 'mb_truncate', smarty_modifier_mb_truncate(...));
    }
}
