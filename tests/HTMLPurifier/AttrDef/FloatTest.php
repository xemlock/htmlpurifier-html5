<?php

class HTMLPurifier_AttrDef_FloatTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var HTMLPurifier_Context
     */
    protected $context;

    /**
     * @var HTMLPurifier_HTML5Config
     */
    protected $config;

    public function setUp()
    {
        $this->config = HTMLPurifier_HTML5Config::createDefault();
        $this->context = new HTMLPurifier_Context();
    }

    protected function validateAttr(HTMLPurifier_AttrDef_HTML5_Float $attr, $value)
    {
        return $attr->validate($value, $this->config, $this->context);
    }

    public function testValidate()
    {
        $attr = new HTMLPurifier_AttrDef_HTML5_Float();

        // Don't use assertEquals() when comparing strings. Here is why:
        // "+1e10" == "1E10" // true
        $this->assertSame('0', $this->validateAttr($attr, '0'));
        $this->assertSame('1', $this->validateAttr($attr, '1'));
        $this->assertSame('1', $this->validateAttr($attr, ' 1'));
        $this->assertSame('1E10', $this->validateAttr($attr, '1E10'));
        $this->assertSame('1E10', $this->validateAttr($attr, '+1E10'));

        $this->assertFalse($this->validateAttr($attr, 'foo'));
        $this->assertFalse($this->validateAttr($attr, 'bar'));
        $this->assertFalse($this->validateAttr($attr, '0xcafe'));
        $this->assertFalse($this->validateAttr($attr, '0b0101'));
        $this->assertFalse($this->validateAttr($attr, '0.01.1'));
        $this->assertFalse($this->validateAttr($attr, ''));
        $this->assertFalse($this->validateAttr($attr, ' '));
    }

    public function testValidateOptions()
    {
        $attr = new HTMLPurifier_AttrDef_HTML5_Float(array('min' => 10));
        $this->assertFalse($this->validateAttr($attr, '0'));
        $this->assertSame('10', $this->validateAttr($attr, '10'));
        $this->assertSame('11', $this->validateAttr($attr, '11'));

        $attr = new HTMLPurifier_AttrDef_HTML5_Float(array('min' => 10, 'minInclusive' => false));
        $this->assertFalse($this->validateAttr($attr, '0'));
        $this->assertFalse($this->validateAttr($attr, '10'));
        $this->assertSame('11', $this->validateAttr($attr, '11'));

        $attr = new HTMLPurifier_AttrDef_HTML5_Float(array('max' => 20));
        $this->assertSame('0', $this->validateAttr($attr, '0'));
        $this->assertSame('10', $this->validateAttr($attr, '10'));
        $this->assertSame('20', $this->validateAttr($attr, '20'));
        $this->assertFalse($this->validateAttr($attr, '21'));

        $attr = new HTMLPurifier_AttrDef_HTML5_Float(array('max' => 20, 'maxInclusive' => false));
        $this->assertSame('0', $this->validateAttr($attr, '0'));
        $this->assertSame('10', $this->validateAttr($attr, '10'));
        $this->assertFalse($this->validateAttr($attr, '20'));
        $this->assertFalse($this->validateAttr($attr, '21'));

        $attr = new HTMLPurifier_AttrDef_HTML5_Float(array('min' => 10, 'max' => 20));
        $this->assertFalse($this->validateAttr($attr, '0'));
        $this->assertSame('10', $this->validateAttr($attr, '10'));
        $this->assertSame('20', $this->validateAttr($attr, '20'));
        $this->assertFalse($this->validateAttr($attr, '21'));
    }

    public function testMake()
    {
        $factory = new HTMLPurifier_AttrDef_HTML5_Float();

        $attr = $factory->make('');
        $this->assertEquals(new HTMLPurifier_AttrDef_HTML5_Float(), $attr);

        $attr = $factory->make('min:10,max:100');
        $this->assertEquals(new HTMLPurifier_AttrDef_HTML5_Float(array('min' => 10, 'max' => 100)), $attr);

        $attr = $factory->make('min:10,minInclusive:0');
        $this->assertEquals(new HTMLPurifier_AttrDef_HTML5_Float(array('min' => 10, 'minInclusive' => false)), $attr);

        $attr = $factory->make('max:10,maxInclusive:1');
        $this->assertEquals(new HTMLPurifier_AttrDef_HTML5_Float(array('max' => 10, 'maxInclusive' => true)), $attr);
    }
}
