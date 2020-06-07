<?php

class HTMLPurifier_HTMLModule_HTML5_Text_STest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            's basic' => array('<s>text</s>'),
            's empty' => array('<s></s>'),
            's in p' => array('<p><s class="class" lang="en">text</s></p>'),
            's in span' => array('<span><s>text</s></span>'),
            's in div' => array('<div><s>text</s></div>'),
            's in heading' => array('<h1><s>text</s></h1>'),
            's nested' => array('<s><s>text</s></s>'),
        );
    }
}
