<?php

// PHP Strict Standards:  Non-static method Net_UserAgent_Mobile::factory() should not be called statically
error_reporting(error_reporting() & ~E_STRICT & ~E_DEPRECATED);
require_once(dirname(__FILE__) . '/config.php');
require_once(dirname(__FILE__) . '/classes/App.class.php');
require_once(dirname(__FILE__) . '/classes/AppAmazon.class.php');
require_once(dirname(__FILE__) . '/classes/AppSmarty.class.php');
require_once(dirname(__FILE__) . '/classes/MyList.class.php');
require_once(dirname(__FILE__) . '/classes/MyListManager.class.php');
