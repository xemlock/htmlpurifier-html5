<?php

class HTMLPurifier_HTMLModule_HTML5_Text_KbdTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'kbd basic' => array('<kbd>Foo</kbd>'),
            'kbd empty' => array('<kbd></kbd>'),
            'kbd in p' => array('<p><kbd>Foo</kbd></p>'),
            'kbd in span' => array('<span><kbd>Foo</kbd></span>'),
            'kbd in div' => array('<div><kbd>Foo</kbd></div>'),
            'kbd in heading' => array('<h1><kbd>Foo</kbd></h1>'),
            'kbd nested' => array('<kbd><kbd>Foo</kbd></kbd>'),
        );
    }
}
