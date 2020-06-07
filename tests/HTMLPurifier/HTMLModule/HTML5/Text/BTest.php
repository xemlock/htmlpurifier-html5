<?php

class HTMLPurifier_HTMLModule_HTML5_Text_BTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'b basic' => array('<b>text</b>'),
            'b empty' => array('<b></b>'),
            'b in p' => array('<p><b class="class" lang="en">text</b></p>'),
            'b in span' => array('<span><b>text</b></span>'),
            'b in div' => array('<div><b>text</b></div>'),
            'b in heading' => array('<h1><b>text</b></h1>'),
            'b nested' => array('<b><b>text</b></b>'),
        );
    }
}
