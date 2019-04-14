<?php

class HTMLPurifier_HTMLModule_HTML5_BdoTest extends BaseTestCase
{
    public function testBdo()
    {
        $this->config->set('Attr.DefaultTextDir', 'ltr');

        $this->assertPurification('<bdo dir="ltr">Foo</bdo>');
        $this->assertPurification('<bdo dir="auto">Foo</bdo>', '<bdo dir="ltr">Foo</bdo>');
        $this->assertPurification('<bdo><span>Foo</span></bdo>', '<bdo dir="ltr"><span>Foo</span></bdo>');
        $this->assertPurification('<bdo><span>Foo</span></bdo>', '<bdo dir="ltr"><span>Foo</span></bdo>');
        $this->assertPurification('<div><bdo>Foo</bdo></div>', '<div><bdo dir="ltr">Foo</bdo></div>');
        $this->assertPurification('<bdo><div>Foo</div></bdo>', '<bdo dir="ltr"></bdo><div>Foo</div>');
    }

    public function testBdi()
    {
        $this->assertPurification('<bdi dir="auto">Foo</bdi>');
        $this->assertPurification('<bdi><span>Foo</span></bdi>');
        $this->assertPurification('<span><bdi>Foo</bdi></span>');
        $this->assertPurification('<div><bdi>Foo</bdi></div>');
        $this->assertPurification('<bdi><div>Foo</div></bdi>', '<bdi></bdi><div>Foo</div>');
    }
}
