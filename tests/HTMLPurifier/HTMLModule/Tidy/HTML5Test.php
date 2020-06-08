<?php

class HTMLPurifier_HTMLModule_Tidy_HTML5Test extends BaseTestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->config->set('HTML.TidyLevel', 'light');
    }

    public function testUnchanged()
    {
        $this->assertPurification('<b>Foo</b>');
        $this->assertPurification('<i>Foo</i>');
        $this->assertPurification('<s>Foo</s>');
        $this->assertPurification('<u>Foo</u>');
    }

    public function testCenter()
    {
        $this->assertPurification(
            '<center>Foo</center>',
            '<div style="text-align:center;">Foo</div>'
        );
    }

    public function testFont()
    {
        $this->assertPurification('<font>Foo</font>', '<span>Foo</span>');

        $this->assertPurification(
            '<font size="1">Foo</font>',
            '<span style="font-size:xx-small;">Foo</span>'
        );
        $this->assertPurification(
            '<font size="7">Foo</font>',
            '<span style="font-size:3rem;">Foo</span>'
        );

        $this->assertPurification(
            '<font size="+4">Foo</font>',
            '<span style="font-size:3rem;">Foo</span>'
        );
        $this->assertPurification(
            '<font size="+0">Foo</font>',
            '<span style="font-size:medium;">Foo</span>'
        );

        $this->assertPurification(
            '<font face="Open Sans">Foo</font>',
            '<span style="font-family:\'Open Sans\';">Foo</span>'
        );
    }

    public function testAcronym()
    {
        $this->assertPurification(
            '<p>The <acronym title="World Wide Web">WWW</acronym> is only a component of the Internet.</p>',
            '<p>The <abbr title="World Wide Web">WWW</abbr> is only a component of the Internet.</p>'
        );
    }

    public function testBig()
    {
        $this->assertPurification('<big>Foo</big>', '<span style="font-size:larger;">Foo</span>');
    }

    public function testStrike()
    {
        $this->assertPurification('<strike>Foo</strike>', '<s>Foo</s>');
    }

    public function testTt()
    {
        $this->assertPurification('<tt>Foo</tt>', '<code>Foo</code>');
    }

    public function testDir()
    {
        $this->assertPurification('<dir><li>Foo</li></dir>', '<ul><li>Foo</li></ul>');
    }

    public function testMenu()
    {
        $this->assertPurification('<menu><li>Foo</li></menu>', '<ul><li>Foo</li></ul>');
    }

    public function testOl()
    {
        $this->assertPurification(
            '<ol type="circle"><li>Foo</li></ol>',
            '<ol><li>Foo</li></ol>'
        );
    }

    public function testUl()
    {
        $this->assertPurification(
            '<ul type="circle"><li>Foo</li></ul>',
            '<ul style="list-style-type:circle;"><li>Foo</li></ul>'
        );
    }

    public function testLi()
    {
        $this->assertPurification(
            '<ul><li value="-2" type="circle">Foo</li></ul>',
            '<ul><li value="-2" style="list-style-type:circle;">Foo</li></ul>'
        );
    }

    public function testIframe()
    {
        $this->config->set('HTML.SafeIframe', true);
        $this->config->set('URI.SafeIframeRegexp', '/^foo$/');

        $this->assertPurification(
            '<iframe width="640" height="360" src="foo" frameborder="0"></iframe>',
            '<iframe width="640" height="360" src="foo" style="border:0;"></iframe>'
        );

        $this->assertPurification(
            '<iframe width="640" height="360" src="foo" frameborder="1"></iframe>',
            '<iframe width="640" height="360" src="foo"></iframe>'
        );
    }
}
