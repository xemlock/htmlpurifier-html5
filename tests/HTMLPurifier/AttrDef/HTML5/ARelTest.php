<?php

/**
 * @property HTMLPurifier_AttrDef_HTML5_ARel $attr
 */
class HTMLPurifier_AttrDef_HTML5_ARelTest extends AttrDefTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->attr = new HTMLPurifier_AttrDef_HTML5_ARel();
    }

    public function testDefault()
    {
        $this->assertValidate('nofollow');
        $this->assertValidate('stylesheet', false);
    }

    public function testAllowed()
    {
        $this->config->set('Attr.AllowedRel', array('nofollow'));

        $this->assertValidate('nofollow');
        $this->assertValidate('canonical', false);
    }

    public function testInvalid()
    {
        $this->config->set('Attr.AllowedRel', array('nofollow', 'foo'));

        $this->assertValidate('foo', false);
        $this->assertValidate('foo nofollow', 'nofollow');
    }
}
