<?php

class HTMLPurifier_HTMLModule_HTML5_Text_AbbrTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'abbr basic' => array('<abbr>Foo</abbr>'),
            'abbr in span' => array('<span><abbr>Foo</abbr></span>'),
            'abbr in div' => array('<div><abbr>Foo</abbr></div>'),
            'abbr in heading' => array('<h1><abbr>Foo</abbr></h1>'),
            'abbr nested' => array('<abbr><abbr>Foo</abbr></abbr>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/abbr/model-isvalid.html
            'abbr is structured inline' => array(
                '<p><abbr class="class" lang="en" title="">text</abbr></p>',
            ),
            'abbr is strictly inline' => array(
                '<p><dfn><abbr title="text1" class="class" lang="en">text</abbr></dfn></p>',
            ),
            'abbr can be empty 1' => array(
                '<p>text <abbr title=""></abbr></p>',
            ),
            'abbr can be empty 2' => array(
                '<p>text <dfn><abbr title=""></abbr></dfn></p>',
            ),
            'abbr can contain interactive 1' => array(
                '<p><abbr title=""><a>text</a></abbr></p>',
            ),
            'abbr can contain interactive 2' => array(
                '<p><dfn><abbr title=""><a>text</a></abbr></dfn></p>',
            ),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/abbr/model-novalid.html
            'abbr cannot contain structured inline' => array(
                '<p><abbr><ul><li>text</li></ul></abbr></p>',
                '<p><abbr></abbr></p><ul><li>text</li></ul>',
            ),
            'abbr cannot contain interactive if parent forbids interactive 1' => array(
                '<p><a><abbr><a>text</a></abbr></a></p>',
                '<p><a><abbr></abbr></a></p>',
            ),
            'abbr cannot contain interactive if parent forbids interactive 2' => array(
                '<p><a><dfn><abbr><a>text</a></abbr></dfn></a></p>',
                '<p><a><dfn><abbr></abbr></dfn></a></p>',
            ),
        );
    }
}
