<?php

class HTMLPurifier_HTML5ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $config = HTMLPurifier_HTML5Config::create();
        $this->assertInstanceOf('HTMLPurifier_Config', $config);

        $config2 = HTMLPurifier_HTML5Config::create($config);
        $this->assertSame($config, $config2);

        $config3 = HTMLPurifier_HTML5Config::create(array(
            'Core.Encoding' => 'iso-8859-1',
        ));
        $this->assertInstanceOf('HTMLPurifier_Config', $config3);
        $this->assertEquals('iso-8859-1', $config3->get('Core.Encoding'));
    }
}
