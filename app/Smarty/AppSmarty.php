<?php

declare(strict_types=1);

namespace App\Smarty;

use Smarty\Smarty;

class AppSmarty extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        $this->setTemplateDir(SMARTY_TEMPLATE_DIR);
        $this->setCompileDir(SMARTY_COMPILE_DIR);
    }
}
