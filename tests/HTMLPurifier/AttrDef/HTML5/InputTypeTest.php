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

    public function testValidInputType()
    {
        $this->assertValidate('text');
    }

    public function testInvalidInputType()
    {
        $this->assertValidate('foo', false);
        $this->assertValidate('', false);
    }

    public function testUppercaseInputType()
    {
        $this->assertValidate('TEXT', 'text');
    }

    public function testNullAllowedInputTypes()
    {
        $this->config->set('Attr.AllowedInputTypes', null);
        $this->assertValidate('text');
        $this->assertValidate('password');
    }

    public function testEmptyAllowedInputTypes()
    {
        $this->config->set('Attr.AllowedInputTypes', array());
        $this->assertValidate('text', false);
        $this->assertValidate('password', false);
    }

    public function testTextInputTypeNotAllowed()
    {
        $this->config->set('Attr.AllowedInputTypes', array('password'));

        $this->assertValidate('text', false);
        $this->assertValidate('password');
    }

    public function testInvalidAllowedInputTypes()
    {
        $this->config->set('Attr.AllowedInputTypes', array('foo'));
        $this->assertValidate('foo', false);
        $this->assertValidate('text', false);
    }
}
