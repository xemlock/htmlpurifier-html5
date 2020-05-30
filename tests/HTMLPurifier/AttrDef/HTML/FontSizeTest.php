<?php

class HTMLPurifier_AttrDef_HTML_FontSizeTest extends AttrDefTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->attr = new HTMLPurifier_AttrDef_HTML_FontSize();
    }

    public function testValid()
    {
        $this->assertValidate('1');
        $this->assertValidate('7');

        $this->assertValidate('+4');
        $this->assertValidate('+0');
        $this->assertValidate('-2');

        $this->assertValidate('1.0', '1');
        $this->assertValidate('1.9', '1');
        $this->assertValidate('-1.1', '-1');
        $this->assertValidate('-1.9', '-1');
    }

    public function testInvalid()
    {
        $this->assertValidate('', false);
        $this->assertValidate('a', false);

        $this->assertValidate('0', '1');
        $this->assertValidate('-3', '-2');
        $this->assertValidate('+5', '+4');
    }
}
