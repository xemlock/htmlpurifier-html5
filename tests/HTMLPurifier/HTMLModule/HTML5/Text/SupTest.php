<?php

class HTMLPurifier_HTMLModule_HTML5_Text_SupTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'sup basic' => array('<sup>text</sup>'),
            'sup in span' => array('<span><sup>text</sup></span>'),
            'sup in div' => array('<div><sup>text</sup></div>'),
            'sup in heading' => array('<h1><sup>text</sup></h1>'),
            'sup nested' => array('<sup><sup>text</sup></sup>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/sup/model-isvalid.html
            'sup is structured inline' => array(
                '<p><sup class="class" lang="en">text</sup></p>',
            ),
            'sup is strictly inline' => array(
                '<p><dfn><sup class="class" lang="en">text</sup></dfn></p>',
            ),
            'sup can be empty 1' => array(
                '<p>text <sup></sup></p>',
            ),
            'sup can be empty 2' => array(
                '<p>text <dfn><sup></sup></dfn></p>',
            ),
            'sup can contain interactive 1' => array(
                '<p><sup><a>text</a></sup></p>',
            ),
            'sup can contain interactive 2' => array(
                '<p><dfn><sup><a>text</a></sup></dfn></p>',
            ),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/sup/model-novalid.html
            'sup cannot contain structured inline' => array(
                '<p><sup><ul><li>text</li></ul></sup></p>',
                '<p><sup></sup></p><ul><li>text</li></ul>',
            ),
            'sup cannot contain interactive if parent forbids interactive 1' => array(
                '<p><a><sup><a>text</a></sup></a></p>',
                '<p><a><sup></sup></a></p>',
            ),
            'sup cannot contain interactive if parent forbids interactive 2' => array(
                '<p><a><dfn><sup><a>text</a></sup></dfn></a></p>',
                '<p><a><dfn><sup></sup></dfn></a></p>',
            ),
        );
    }
}
