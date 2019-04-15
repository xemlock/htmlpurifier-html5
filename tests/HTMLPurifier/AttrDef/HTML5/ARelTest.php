<?php

class HTMLPurifier_AttrDef_HTML5_ARelTest extends BaseTestCase
{
    /**
     * @var HTMLPurifier_Context
     */
    protected $context;

    /**
     * @var HTMLPurifier_AttrDef_HTML5_ARel
     */
    protected $attr;

    protected function setUp()
    {
        parent::setUp();

        $this->context = new HTMLPurifier_Context();
        $this->attr = new HTMLPurifier_AttrDef_HTML5_ARel();
    }

    public function testDefault()
    {
        $this->assertSame(
            false,
            $this->attr->validate('nofollow', $this->config, $this->context)
        );
    }

    public function testAllowed()
    {
        $this->config->set('Attr.AllowedRel', array('nofollow'));

        $this->assertSame(
            'nofollow',
            $this->attr->validate('nofollow', $this->config, $this->context)
        );
    }

    public function testInvalid()
    {
        $this->config->set('Attr.AllowedRel', array('nofollow', 'foo'));

        $this->assertSame(
            false,
            $this->attr->validate('foo', $this->config, $this->context)
        );
        $this->assertSame(
            'nofollow',
            $this->attr->validate('foo nofollow', $this->config, $this->context)
        );
    }
}
