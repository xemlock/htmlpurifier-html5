<?php

class HTMLPurifier_HTMLModule_HTML5_Text_CiteTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'cite basic' => array('<cite>Foo</cite>'),
            'cite in span' => array('<span><cite>Foo</cite></span>'),
            'cite in div' => array('<div><cite>Foo</cite></div>'),
            'cite in heading' => array('<h1><cite>Foo</cite></h1>'),
            'cite nested' => array('<cite><cite>Foo</cite></cite>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/cite/model-isvalid.html
            'cite is structured inline' => array(
                '<p><cite class="class" lang="en">text</cite></p>',
            ),
            'cite is strictly inline' => array(
                '<p><dfn><cite class="class" lang="en">text</cite></dfn></p>',
            ),
            'cite can be empty 1' => array(
                '<p>text <cite></cite></p>',
            ),
            'cite can be empty 2' => array(
                '<p>text <dfn><cite></cite></dfn></p>',
            ),
            'cite can contain interactive 1' => array(
                '<p><cite><a>text</a></cite></p>',
            ),
            'cite can contain interactive 2' => array(
                '<p><dfn><cite><a>text</a></cite></dfn></p>',
            ),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/cite/model-novalid.html
            'cite cannot contain structured inline' => array(
                '<p><cite><ul><li>text</li></ul></cite></p>',
                '<p><cite></cite></p><ul><li>text</li></ul>',
            ),
            'cite cannot contain interactive if parent forbids interactive 1' => array(
                '<p><a><cite><a>text</a></cite></a></p>',
                '<p><a><cite></cite></a></p>',
            ),
            'cite cannot contain interactive if parent forbids interactive 2' => array(
                '<p><a><dfn><cite><a>text</a></cite></dfn></a></p>',
                '<p><a><dfn><cite></cite></dfn></a></p>',
            ),
        );
    }
}
