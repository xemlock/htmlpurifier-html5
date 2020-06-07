<?php

class HTMLPurifier_HTMLModule_HTML5_Text_SpanTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'span basic' => array('<span>text</span>'),
            'span in span' => array('<span><span>text</span></span>'),
            'span in div' => array('<div><span>text</span></div>'),
            'span in heading' => array('<h1><span>text</span></h1>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/span/model-isvalid.html
            'span is structured inline' => array(
                '<p><span class="class" lang="en">text</span></p>',
            ),
            'span is strictly inline' => array(
                '<p><dfn><span class="class" lang="en">text</span></dfn></p>',
            ),
            'span can be empty 1' => array(
                '<p>text <span></span></p>',
            ),
            'span can be empty 2' => array(
                '<p>text <dfn><span></span></dfn></p>',
            ),
            'span can contain interactive 1' => array(
                '<p><span><a>text</a></span></p>',
            ),
            'span can contain interactive 2' => array(
                '<p><dfn><span><a>text</a></span></dfn></p>',
            ),
        );
    }
}
