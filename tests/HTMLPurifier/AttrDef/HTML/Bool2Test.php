<?php

class HTMLPurifier_AttrDef_HTML_Bool2Test extends PHPUnit_Framework_TestCase
{
    protected $context, $config;

    public function setUp()
    {
        $this->config = HTMLPurifier_HTML5Config::createDefault();
        $this->context = new HTMLPurifier_Context();
    }

    protected function validateAttr($attr, $value)
    {
        return $attr->validate($value, $this->config, $this->context);
    }

    public function testValidate()
    {
        $attr = new HTMLPurifier_AttrDef_HTML_Bool2('foo');

        $this->assertTrue($this->validateAttr($attr, 'foo'));
        $this->assertTrue($this->validateAttr($attr, 'FOO'));
        $this->assertTrue($this->validateAttr($attr, 'FoO'));
        $this->assertTrue($this->validateAttr($attr, ''));

        $this->assertFalse($this->validateAttr($attr, 'bar'));
    }

    public function testMake()
    {
        $factory = new HTMLPurifier_AttrDef_HTML_Bool2();
        $attr1 = $factory->make('foo');
        $attr2 = new HTMLPurifier_AttrDef_HTML_Bool2('foo');

        $this->assertEquals($attr1, $attr2);
    }
}
