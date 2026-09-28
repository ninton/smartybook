<?php

namespace SmartyBook\chapter5_6\_read\classes;

use App\Smarty\AppSmarty as Smarty;

class AppSmarty extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        include_once dirname(__DIR__, 2) . '/modifier.mb_truncate.php';
        $this->registerPlugin('modifier', 'mb_truncate', smarty_modifier_mb_truncate(...));
    }
}
