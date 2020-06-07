<?php

class HTMLPurifier_HTMLModule_HTML5_Text_UTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'u basic' => array('<u>text</u>'),
            'u empty' => array('<u></u>'),
            'u in p' => array('<p><u class="class" lang="en">text</u></p>'),
            'u in span' => array('<span><u>text</u></span>'),
            'u in div' => array('<div><u>text</u></div>'),
            'u in heading' => array('<h1><u>text</u></h1>'),
            'u nested' => array('<u><u>text</u></u>'),
        );
    }
}
