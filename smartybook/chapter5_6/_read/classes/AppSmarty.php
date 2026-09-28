<?php

namespace SmartyBook\chapter5_6\_read\classes;

use App\Smarty\AppSmarty as Smarty;

class AppSmarty extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        $this->setConfigDir(__DIR__ . '/../../_read/configs');

        include_once __DIR__ . '/../../modifier.mb_truncate.php';
        $this->registerPlugin('modifier', 'mb_truncate', smarty_modifier_mb_truncate(...));
    }
}
