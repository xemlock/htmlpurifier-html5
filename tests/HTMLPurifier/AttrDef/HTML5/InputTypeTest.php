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
    }

    public function testUppercaseInputType()
    {
        $this->assertValidate('TEXT', 'text');
    }
}
