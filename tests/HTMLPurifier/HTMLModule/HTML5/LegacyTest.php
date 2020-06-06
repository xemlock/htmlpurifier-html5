<?php

class HTMLPurifier_HTMLModule_HTML5_LegacyTest extends BaseTestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->config->set('HTML.TidyLevel', 'none');
    }

    public function testCenter()
    {
        $this->assertPurification('<center>Foo</center>');
    }

    public function testFont()
    {
        $this->assertPurification('<font>Foo</font>');

        $this->assertPurification('<font size="1" face="Arial">Foo</font>');
        $this->assertPurification('<font size="7">Foo</font>');

        $this->assertPurification('<font size="+4">Foo</font>');
        $this->assertPurification('<font size="+0">Foo</font>');
        $this->assertPurification('<font size="-2">Foo</font>');

        $this->assertPurification('<font size="1.0">Foo</font>', '<font size="1">Foo</font>');
        $this->assertPurification('<font size="1.9">Foo</font>', '<font size="1">Foo</font>');
        $this->assertPurification('<font size="-1.1">Foo</font>', '<font size="-1">Foo</font>');
        $this->assertPurification('<font size="-1.9">Foo</font>', '<font size="-1">Foo</font>');

        $this->assertPurification('<font size="">Foo</font>', '<font>Foo</font>');
        $this->assertPurification('<font size="a">Foo</font>', '<font>Foo</font>');
    }

    public function testBig()
    {
        $this->assertPurification('<big>Foo</big>');
    }

    public function testStrike()
    {
        $this->assertPurification('<strike>Foo</strike>');
    }

    public function testTt()
    {
        $this->assertPurification('<tt>Foo</tt>');
    }

    public function testDir()
    {
        $this->assertPurification('<dir><li>Foo</li></dir>');
    }

    public function testMenu()
    {
        $this->assertPurification('<menu><li>Foo</li></menu>');
    }

    public function testOl()
    {
        $this->assertPurification('<ol type="circle"><li>Foo</li></ol>', '<ol><li>Foo</li></ol>');
    }

    public function testUl()
    {
        $this->assertPurification('<ul type="circle"><li>Foo</li></ul>');
    }

    public function testLi()
    {
        $this->assertPurification('<ul><li value="-2" type="circle">Foo</li></ul>');
    }
}
