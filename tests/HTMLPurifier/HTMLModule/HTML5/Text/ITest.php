<?php

class HTMLPurifier_HTMLModule_HTML5_Text_ITest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'i basic' => array('<i>text</i>'),
            'i in span' => array('<span><i>text</i></span>'),
            'i in div' => array('<div><i>text</i></div>'),
            'i in heading' => array('<h1><i>text</i></h1>'),
            'i nested' => array('<i><i>text</i></i>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/i/model-isvalid.html
            'i is structured inline' => array(
                '<p><i class="class" lang="en">text</i></p>',
            ),
            'i is strictly inline' => array(
                '<p><dfn><i class="class" lang="en">text</i></dfn></p>',
            ),
            'i can be empty 1' => array(
                '<p>text <i></i></p>',
            ),
            'i can be empty 2' => array(
                '<p>text <dfn><i></i></dfn></p>',
            ),
            'i can contain interactive 1' => array(
                '<p><i><a>text</a></i></p>',
            ),
            'i can contain interactive 2' => array(
                '<p><dfn><i><a>text</a></i></dfn></p>',
            ),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/i/model-novalid.html
            'i cannot contain structured inline' => array(
                '<p><i><ul><li>text</li></ul></i></p>',
                '<p><i></i></p><ul><li>text</li></ul>',
            ),
            'i cannot contain interactive if parent forbids interactive 1' => array(
                '<p><a><i><a>text</a></i></a></p>',
                '<p><a><i></i></a></p>',
            ),
            'i cannot contain interactive if parent forbids interactive 2' => array(
                '<p><a><dfn><i><a>text</a></i></dfn></a></p>',
                '<p><a><dfn><i></i></dfn></a></p>',
            ),
        );
    }
}
