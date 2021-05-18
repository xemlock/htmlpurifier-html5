<?php

class HTMLPurifier_HTMLModule_HTML5_LinkTest extends BaseTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->config->set('Attr.AllowedRel', array('stylesheet', 'preload'));
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
            '<link href="https://localhost/foo.css" rel="stylesheet preload">'
        );
    }
}
