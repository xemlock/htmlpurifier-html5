<?php

class HTMLPurifier_HTMLModule_HTML5_LinkTest extends BaseTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->config->set('HTML.SafeLink', true);
        $this->config->set('Attr.AllowedRel', array('stylesheet'));
        $this->config->set('URI.SafeLinkRegexp', '%^https?://localhost/%');
    }

    public function testClosingTag()
    {
        $this->assertPurification(
            '<link></link>',
            ''
        );
    }

    public function testSelfClosing()
    {
        $this->assertPurification(
            '<link>',
            ''
        );
    }

    public function testNoHref()
    {
        $this->assertPurification(
            '<link rel="stylesheet">',
            ''
        );
    }

    public function testNoRel()
    {
        $this->assertPurification(
            '<link href="foo">',
            ''
        );
    }

    public function testInvalidUrl()
    {
        $this->assertPurification(
            '<link href="http://google.com/foo.css" rel="stylesheet">',
            ''
        );
    }

    public function testGood()
    {
        $this->assertPurification(
            '<link href="https://localhost/foo.css" rel="stylesheet">',
            '<link href="https://localhost/foo.css" rel="stylesheet">'
        );
    }

    public function testGoodModuleDisabled()
    {
        $this->config->set('HTML.SafeLink', false);

        $this->assertPurification(
            '<link href="https://localhost/foo.css" rel="stylesheet">',
            ''
        );
    }

    public function testWhitelistCapitalised()
    {
        // regex is case sensitive
        $this->assertPurification(
            '<link href="https://localHost/FOO.css" rel="stylesheet">',
            ''
        );
    }

    public function testGoodWithAutoclosedTag()
    {
        $this->assertPurification(
            '<link href="https://localhost/foo.css" rel="stylesheet"></link>',
            '<link href="https://localhost/foo.css" rel="stylesheet">'
        );

        $this->assertPurification(
            '<link href="https://localhost/foo.css" rel="stylesheet" />',
            '<link href="https://localhost/foo.css" rel="stylesheet">'
        );
    }

    public function testMultiRel()
    {
        $this->assertPurification(
            '<link href="https://localhost/foo.css" rel="stylesheet preload">',
            '<link href="https://localhost/foo.css" rel="stylesheet">'
        );
    }

    public function testNullSafeLinkRegexp()
    {
        $this->config->set('URI.SafeLinkRegexp', null);

        $this->assertPurification(
            '<link href="https://localhost/foo.css" rel="stylesheet">',
            ''
        );
    }

    public function testMultipleElements()
    {
        $this->assertPurification(
            '<span>Foo</span><link href="https://localhost/foo.css" rel="stylesheet">',
            '<span>Foo</span><link href="https://localhost/foo.css" rel="stylesheet">'
        );
    }

    public function testEmptyAllowedRel()
    {
        $this->config->set('Attr.AllowedRel', array());

        $this->assertPurification(
            '<link href="https://localhost/foo.css" rel="stylesheet">',
            ''
        );
    }

    public function testInvalidRel()
    {
        $this->config->set('Attr.AllowedRel', array('alternate', 'stylesheet'));

        // 'alternate' is not allowed in links in body
        // https://html.spec.whatwg.org/multipage/links.html#linkTypes
        $this->assertPurification(
            '<link href="https://localhost/foo.css" rel="alternate stylesheet">',
            '<link href="https://localhost/foo.css" rel="stylesheet">'
        );
    }

    public function testDisableExternalResources()
    {
        $this->config->set('URI.DisableResources', true);

        $this->assertPurification(
            '<link href="https://localhost/foo.css" rel="stylesheet">',
            ''
        );
    }

    public function testEnableWithHtmlTrustedConfig()
    {
        $this->config->set('HTML.Link', false);
        $this->config->set('HTML.SafeLink', false);
        $this->config->set('HTML.Trusted', true);

        $this->assertPurification('<link href="http://google.com/foo.css" rel="stylesheet">');
    }

    public function testEnableWithHtmlLinkConfig()
    {
        $this->config->set('HTML.Link', true);
        $this->config->set('HTML.SafeLink', false);
        $this->config->set('HTML.Trusted', true);

        $this->assertPurification('<link href="http://google.com/foo.css" rel="stylesheet">');
    }

    public function testIntegrity()
    {
        $this->assertPurification('<link href="http://localhost/foo.css" rel="stylesheet" integrity="sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY=">');
    }
}
