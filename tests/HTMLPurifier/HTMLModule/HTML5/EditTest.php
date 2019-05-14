<?php

class HTMLPurifier_HTMLModule_HTML5_EditTest extends BaseTestCase
{
    /**
     * @var string
     */
    protected $defaultTimezone;

    protected function setUp()
    {
        parent::setUp();

        $this->defaultTimezone = date_default_timezone_get();

        date_default_timezone_set('UTC');
    }

    protected function tearDown()
    {
        parent::tearDown();

        date_default_timezone_set($this->defaultTimezone);
    }

    public function testInsDel()
    {
        $this->assertPurification('<p>This was <del>deleted</del> <ins>added</ins>.</p>');

        $this->assertPurification('<del><p>This paragraph has been deleted.</p></del>');
        $this->assertPurification('<del></del>');

        $this->assertPurification('<ins><p>This paragraph has been added.</p></ins>');
        $this->assertPurification('<ins></ins>');
    }

    public function testInsDelAttrs()
    {
        $this->assertPurification('<del datetime="2010-04-10T10:41:04Z" cite="ATM-QAR">Foo</del>');
        $this->assertPurification('<ins datetime="2011-07-29" cite="KBWLLP">Foo</ins>');
    }

    /**
     * @dataProvider delDatetimeAttrData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testDelDatetimeAttr($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function delDatetimeAttrData()
    {
        return array(
            array('<del datetime="2010-04-10">Foo</del>'),
            array('<del datetime="2010-04-10T10:41:04Z">Foo</del>'),
            array('<del datetime="2010-04-10T10:41+00:00">Foo</del>'),
            array(
                '<del datetime="2010-04-10 10:41">Foo</del>',
                '<del datetime="2010-04-10T10:41+00:00">Foo</del>',
            ),
            array(
                '<del datetime="2010-04">Foo</del>',
                '<del>Foo</del>',
            ),
            array(
                '<del datetime="2010">Foo</del>',
                '<del>Foo</del>',
            ),
            array(
                '<del datetime="04-10">Foo</del>',
                '<del>Foo</del>',
            ),
            array(
                '<del datetime="10:41">Foo</del>',
                '<del>Foo</del>',
            ),
            array(
                '<del datetime="+02:00">Foo</del>',
                '<del>Foo</del>',
            ),
            array(
                '<del datetime="Foo">Foo</del>',
                '<del>Foo</del>',
            ),
        );
    }

    /**
     * @dataProvider insDatetimeAttrData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testInsDatetimeAttr($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function insDatetimeAttrData()
    {
        return array(
            array('<ins datetime="2010-04-10">Foo</ins>'),
            array('<ins datetime="2010-04-10T10:41:04Z">Foo</ins>'),
            array('<ins datetime="2010-04-10T10:41+00:00">Foo</ins>'),
            array(
                '<ins datetime="2010-04-10 10:41">Foo</ins>',
                '<ins datetime="2010-04-10T10:41+00:00">Foo</ins>',
            ),
            array(
                '<ins datetime="2010-04">Foo</ins>',
                '<ins>Foo</ins>',
            ),
            array(
                '<ins datetime="2010">Foo</ins>',
                '<ins>Foo</ins>',
            ),
            array(
                '<ins datetime="04-10">Foo</ins>',
                '<ins>Foo</ins>',
            ),
            array(
                '<ins datetime="10:41">Foo</ins>',
                '<ins>Foo</ins>',
            ),
            array(
                '<ins datetime="+02:00">Foo</ins>',
                '<ins>Foo</ins>',
            ),
            array(
                '<ins datetime="Foo">Foo</ins>',
                '<ins>Foo</ins>',
            ),
        );
    }
}
