<?php

class HTMLPurifier_HTML5ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $config = HTMLPurifier_HTML5Config::create(null);
        $this->assertInstanceOf('HTMLPurifier_Config', $config);

        $config2 = HTMLPurifier_HTML5Config::create($config);
        $this->assertSame($config->def, $config2->def);

        $config3 = HTMLPurifier_HTML5Config::create(array(
            'Core.Encoding' => 'iso-8859-1',
        ));
        $this->assertInstanceOf('HTMLPurifier_Config', $config3);
        $this->assertEquals('iso-8859-1', $config3->get('Core.Encoding'));

        $config4 = HTMLPurifier_HTML5Config::create(null);
        $config4->set('Core.Encoding', 'iso-8859-1');
        $this->assertInstanceOf('HTMLPurifier_Config', $config4);
        $this->assertEquals('iso-8859-1', $config4->get('Core.Encoding'));
    }

    public function testInherit()
    {
        $parent = HTMLPurifier_Config::create(array(
            'Core.Encoding' => 'iso-8859-2',
            'HTML.Trusted' => true,
        ));

        $config = HTMLPurifier_HTML5Config::inherit($parent);

        $this->assertInstanceof('HTMLPurifier_Config', $config);
        $this->assertSame($parent->def, $config->def);
        $this->assertEquals('iso-8859-2', $config->get('Core.Encoding'));
        $this->assertTrue($config->get('HTML.Trusted'));
    }
}
