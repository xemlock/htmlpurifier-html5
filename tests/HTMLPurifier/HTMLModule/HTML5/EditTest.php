<?php

class HTMLPurifier_HTMLModule_HTML5_EditTest extends BaseTestCase
{
    public function testInsDel()
    {
        $this->assertPurification('<p>This was <del>deleted</del> <ins>added</ins>.</p>');
        $this->assertPurification('<del><p>This paragraph has been deleted.</p></del>');
        $this->assertPurification('<ins><p>This paragraph has been added.</p></ins>');
    }

    public function testInsDelAttrs()
    {
        $this->assertPurification('<del datetime="2010-04-10T10:41:04" cite="ATM-QAR">Foo</del>');
        $this->assertPurification('<ins datetime="2011-07-29" cite="KBWLLP">Foo</ins>');
    }
}
