<?php

namespace SmartyBook\Tests;

use TestSuite;

class AllTests extends TestSuite
{
    public function __construct()
    {
        parent::__construct('All tests');

        $arr = glob(__DIR__ . "/*Test.php");
        foreach ($arr as $path) {
            $this->addFile($path);
        }
    }
}
