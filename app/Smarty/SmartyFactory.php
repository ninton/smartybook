<?php

declare(strict_types=1);

namespace App\Smarty;

use Smarty\Smarty;

final readonly class SmartyFactory
{
    public static function create(): Smarty
    {
        $smarty = new Smarty();

        $smarty->setTemplateDir(SMARTY_TEMPLATE_DIR);
        $smarty->setCompileDir(SMARTY_COMPILE_DIR);
        $smarty->setCacheDir(SMARTY_CACHE_DIR);

        return $smarty;
    }
}
