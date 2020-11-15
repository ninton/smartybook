<?php

// phpcs:disable PSR1.Files.SideEffects

namespace SmartyBook\Tests;

require_once __DIR__ . '/../vendor/simpletest/simpletest/autorun.php';

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
