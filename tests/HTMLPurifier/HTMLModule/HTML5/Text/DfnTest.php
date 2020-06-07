<?php

class HTMLPurifier_HTMLModule_HTML5_Text_DfnTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'dfn basic' => array('<dfn>Foo</dfn>'),
            'dfn in span' => array('<span><dfn>Foo</dfn></span>'),
            'dfn in div' => array('<div><dfn>Foo</dfn></div>'),
            'dfn in heading' => array('<h1><dfn>Foo</dfn></h1>'),
            'dfn nested' => array('<dfn><dfn>Foo</dfn></dfn>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/dfn/model-isvalid.html
            'dfn is structured inline' => array(
                '<p><dfn class="class" lang="en" title="text1">text</dfn></p>',
            ),
            'dfn is strictly inline' => array(
                '<p><i><dfn class="class" lang="en">text2</dfn></i></p>',
            ),
            'dfn can be empty 1' => array(
                '<p>text <dfn></dfn></p>',
            ),
            'dfn can be empty 2' => array(
                '<p>text <i><dfn title="text3"></dfn></i></p>',
            ),
            'dfn can contain interactive 1' => array(
                '<p><dfn><a>text4</a></dfn></p>',
            ),
            'dfn can contain interactive 2' => array(
                '<p><i><dfn><a>text5</a></dfn></i></p>',
            ),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/dfn/model-novalid.html
            'dfn cannot contain structured inline' => array(
                '<p><dfn><ul><li>text</li></ul></dfn></p>',
                '<p><dfn></dfn></p><ul><li>text</li></ul>',
            ),
            'dfn cannot contain interactive if parent forbids interactive 1' => array(
                '<p><a><dfn><a>text</a></dfn></a></p>',
                '<p><a><dfn></dfn></a></p>',
            ),
            'dfn cannot contain interactive if parent forbids interactive 2' => array(
                '<p><a><var><dfn><a>text</a></dfn></var></a></p>',
                '<p><a><var><dfn></dfn></var></a></p>',
            ),
        );
    }
}
