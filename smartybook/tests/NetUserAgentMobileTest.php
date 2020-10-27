<?php
require_once dirname(__FILE__) . '/../simpletest/autorun.php';
require_once 'Net/UserAgent/Mobile.php';

class NetUserAgentMobileTest extends UnitTestCase
{
    /**
     * @test
     */
    public function test_1()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'DoCoMo/2.0 SO902i(c100;TB;W24H12)';

        $agent = &Net_UserAgent_Mobile::factory();
        $display = $agent->getDisplay();

        $this->assertEqual('docomo', strtolower($agent->getCarrierLongName()));
        $this->assertEqual(240, $display->getWidth());
        $this->assertEqual(256, $display->getHeight());
    }
}
