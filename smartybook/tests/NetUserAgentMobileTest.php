<?php

require_once dirname(__FILE__) . '/../simpletest/autorun.php';
require_once 'Net/UserAgent/Mobile.php';

class NetUserAgentMobileTest extends UnitTestCase
{
    private $level;

    public function setUp()
    {
        parent::setUp();

        // PHP Strict Standards:  Non-static method Net_UserAgent_Mobile::factory() should not be called statically
        // PHP Deprecated: Assigning the return value of new by reference is deprecated in Net/UserAgent/Mobile/DoCoMo/ScreenInfo.php line 2088
        $this->level = error_reporting(error_reporting() & ~E_STRICT & ~E_DEPRECATED);
    }

    public function tearDown()
    {
        parent::tearDown();
        error_reporting($this->level);
    }

    /**
     * @test
     */
    public function test_1()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'DoCoMo/2.0 SO902i(c100;TB;W24H12)';

        $agent = Net_UserAgent_Mobile::factory();
        $display = $agent->getDisplay();

        $this->assertEqual('docomo', strtolower($agent->getCarrierLongName()));
        $this->assertEqual(240, $display->getWidth());
        $this->assertEqual(256, $display->getHeight());
    }
}
