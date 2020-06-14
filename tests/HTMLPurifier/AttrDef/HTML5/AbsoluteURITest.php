<?php

/**
 * @property HTMLPurifier_AttrDef_HTML5_AbsoluteURI $attr
 */
class HTMLPurifier_AttrDef_HTML5_AbsoluteURITest extends AttrDefTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->attr = new HTMLPurifier_AttrDef_HTML5_AbsoluteURI();
    }

    public function testAbsolute()
    {
        $this->assertValidate('http://www.example.com/');
        $this->assertValidate('http://foo');
        $this->assertValidate('javascript:foo();', false);
        $this->assertValidate('ftp://www.example.com/');
        $this->assertValidate('news:rec.alt');
        $this->assertValidate('nntp://news.example.com/324234');
        $this->assertValidate('mailto:foo@example.com');
        $this->assertValidate('tel:+15555555555');
    }

    public function testRelative()
    {
        $this->config->autoFinalize = false;

        $this->assertValidate('www.example.com', false);

        $this->config->set('URI.Base', 'http://example.com');
        $this->assertValidate('foo1', 'http://example.com/foo1');
        $this->assertValidate('/foo1', 'http://example.com/foo1');

        $this->config->set('URI.Base', 'http://example.com/');
        $this->assertValidate('/foo2', 'http://example.com/foo2');

        $this->config->set('URI.Base', '/');
        $this->assertValidate('/foo3', false);

        $this->config->set('URI.Base', null);
        $this->assertValidate('http://example.com/foo');
        $this->assertValidate('example.com/foo', false);
    }

    public function testEmbeds()
    {
        $this->attr = new HTMLPurifier_AttrDef_HTML5_AbsoluteURI(true);
        $this->assertValidate('http://example.com/?foo=bar');
        $this->assertValidate('mailto:foo@example.com', false);
    }

    public function testHostBlacklist()
    {
        $this->config->set('URI.HostBlacklist', array('example2.com'));
        $this->assertValidate('http://example1.com');
        $this->assertValidate('http://example2.com', false);
    }

    public function testMunge()
    {
        $this->config->set('URI.Munge', 'http://www.google.com/url?q=%s');
        $this->assertValidate(
            'http://www.example.com/',
            'http://www.google.com/url?q=http%3A%2F%2Fwww.example.com%2F'
        );
    }

    public function testDisable()
    {
        $this->config->set('URI.Disable', true);
        $this->assertValidate('http://example.com/foo', false);
    }

    public function testInvalid()
    {
        $this->assertValidate('', false);
        $this->assertValidate('http:', false);
        $this->assertValidate('http:/foo', false);
        $this->assertValidate('foo:bar', false);
    }

    public function testMake()
    {
        $this->assertInstanceOf('HTMLPurifier_AttrDef_HTML5_AbsoluteURI', $this->attr->make(''));
    }
}
