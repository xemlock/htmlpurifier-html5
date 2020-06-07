<?php

class HTMLPurifier_HTMLModule_HTML5_Text_MarkTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'mark basic' => array('<mark>text</mark>'),
            'mark in span' => array('<span><mark>text</mark></span>'),
            'mark in div' => array('<div><mark>text</mark></div>'),
            'mark in heading' => array('<h1><mark>text</mark></h1>'),
            'mark nested' => array('<mark><mark>text</mark></mark>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/mark/model-isvalid.html
            'mark is structured inline' => array(
                '<p><mark class="class" lang="en">text</mark></p>',
            ),
            'mark is strictly inline' => array(
                '<p><dfn><mark class="class" lang="en">text</mark></dfn></p>',
            ),
            'mark can be empty 1' => array(
                '<p>text <mark></mark></p>',
            ),
            'mark can be empty 2' => array(
                '<p>text <dfn><mark></mark></dfn></p>',
            ),
            'mark can contain interactive 1' => array(
                '<p><mark><a>text</a></mark></p>',
            ),
            'mark can contain interactive 2' => array(
                '<p><dfn><mark><a>text</a></mark></dfn></p>',
            ),
        );
    }
}
