<?php

class HTMLPurifier_HTMLModule_HTML5_Text_SubTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'sub basic' => array('<sub>text</sub>'),
            'sub in span' => array('<span><sub>text</sub></span>'),
            'sub in div' => array('<div><sub>text</sub></div>'),
            'sub in heading' => array('<h1><sub>text</sub></h1>'),
            'sub nested' => array('<sub><sub>text</sub></sub>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/sub/model-isvalid.html
            'sub is structured inline' => array(
                '<p><sub class="class" lang="en">text</sub></p>',
            ),
            'sub is strictly inline' => array(
                '<p><dfn><sub class="class" lang="en">text</sub></dfn></p>',
            ),
            'sub can be empty 1' => array(
                '<p>text <sub></sub></p>',
            ),
            'sub can be empty 2' => array(
                '<p>text <dfn><sub></sub></dfn></p>',
            ),
            'sub can contain interactive 1' => array(
                '<p><sub><a>text</a></sub></p>',
            ),
            'sub can contain interactive 2' => array(
                '<p><dfn><sub><a>text</a></sub></dfn></p>',
            ),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/sub/model-novalid.html
            'sub cannot contain structured inline' => array(
                '<p><sub><ul><li>text</li></ul></sub></p>',
                '<p><sub></sub></p><ul><li>text</li></ul>',
            ),
            'sub cannot contain interactive if parent forbids interactive 1' => array(
                '<p><a><sub><a>text</a></sub></a></p>',
                '<p><a><sub></sub></a></p>',
            ),
            'sub cannot contain interactive if parent forbids interactive 2' => array(
                '<p><a><dfn><sub><a>text</a></sub></dfn></a></p>',
                '<p><a><dfn><sub></sub></dfn></a></p>',
            ),
        );
    }
}
