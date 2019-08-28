<?php

class HTMLPurifier_HTML5ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $config = HTMLPurifier_HTML5Config::create(null);
        $this->assertInstanceOf('HTMLPurifier_Config', $config);

        $config2 = HTMLPurifier_HTML5Config::create($config);
        $this->assertSame($config->def, $config2->def);
    }

    public function testCreateFromArray()
    {
        $config = HTMLPurifier_HTML5Config::create(array(
            'Core.Encoding' => 'iso-8859-1',
        ));
        $this->assertInstanceOf('HTMLPurifier_Config', $config);
        $this->assertEquals('iso-8859-1', $config->get('Core.Encoding'));
    }

    public function testCreateFromNull()
    {
        $config = HTMLPurifier_HTML5Config::create(null);
        $config->set('Core.Encoding', 'iso-8859-1');
        $this->assertInstanceOf('HTMLPurifier_Config', $config);
        $this->assertEquals('iso-8859-1', $config->get('Core.Encoding'));
    }

    public function testCreateFromIni()
    {
        $config = HTMLPurifier_HTML5Config::create(dirname(__FILE__) . '/../assets/ConfigTest.ini');
        $this->assertInstanceOf('HTMLPurifier_Config', $config);
        $this->assertEquals('iso-8859-1', $config->get('Core.Encoding'));
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

    public function testDoctype()
    {
        $config = HTMLPurifier_HTML5Config::create(null);
        $this->assertEquals('HTML5', $config->get('HTML.Doctype'));

        $config = HTMLPurifier_HTML5Config::create(array('HTML.Doctype' => 'HTML 4.01 Transitional'));
        $this->assertEquals('HTML 4.01 Transitional', $config->get('HTML.Doctype'));
    }
}
