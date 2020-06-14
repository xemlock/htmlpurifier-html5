<?php

/**
 * @property HTMLPurifier_AttrDef_HTML5_InputType $attr
 */
class HTMLPurifier_AttrDef_HTML5_InputTypeTest extends AttrDefTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->attr = new HTMLPurifier_AttrDef_HTML5_InputType();
    }

    public function testDefault()
    {
        $this->assertValidate('email');
    }

    public function testNullAllowedInputTypes()
    {
        $this->config->set('Attr.AllowedInputTypes', null);
        $this->assertValidate('email');
    }

    public function testEmptyAllowedInputTypes()
    {
        $this->config->set('Attr.AllowedInputTypes', array());
        $this->assertValidate('email', false);
    }

    public function testInvalidAllowedInputTypes()
    {
        $this->config->set('Attr.AllowedInputTypes', array('foo'));
        $this->assertValidate('foo', false);
        $this->assertValidate('email', false);
    }

    public function testEmpty()
    {
        $this->assertValidate('', 'text');
    }

    public function testDatetime()
    {
        $this->assertValidate('datetime', 'datetime-local');
    }
}
