<?php

class HTMLPurifier_HTMLModule_HTML5_Text_WbrTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'wbr basic' => array('<wbr>'),
            'wbr xhtml' => array('<wbr/>', '<wbr>'),
            'wbr close' => array('<wbr>text</wbr>', '<wbr>text'),
            'wbr in p' => array('<p><wbr class="class" lang="en"></p>'),
            'wbr in span' => array('<span><wbr></span>'),
            'wbr in div' => array('<div><wbr></div>'),
            'wbr in heading' => array('<h1><wbr></h1>'),
        );
    }
}
