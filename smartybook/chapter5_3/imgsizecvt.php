<?php

require_once('./ini.php');
require_once __DIR__  . '/plib/imgsizecvt_funcs.php';

switch (strtolower($_SERVER['REQUEST_METHOD'])) {
    case 'post':
        proc_image_resize(basename($_POST['fname']));
        $url = get_current_url();
        header("Location: $url");
        break;

    default:
        $rcd_arr = proc_image_list();
        $smarty = new Smarty();
        $smarty->assign('rcd_arr', $rcd_arr);
        $smarty->display('imgsizecvt.tpl');
        break;
}
