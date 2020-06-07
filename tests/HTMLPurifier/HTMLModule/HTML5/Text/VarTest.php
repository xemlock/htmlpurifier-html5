<?php

class HTMLPurifier_HTMLModule_HTML5_Text_VarTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'var basic' => array('<var>text</var>'),
            'var in span' => array('<span><var>text</var></span>'),
            'var in div' => array('<div><var>text</var></div>'),
            'var in heading' => array('<h1><var>text</var></h1>'),
            'var nested' => array('<var><var>text</var></var>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/var/model-isvalid.html
            'var is structured inline' => array(
                '<p><var class="class" lang="en">text</var></p>',
            ),
            'var is strictly inline' => array(
                '<p><dfn><var class="class" lang="en">text</var></dfn></p>',
            ),
            'var can be empty 1' => array(
                '<p>text <var></var></p>',
            ),
            'var can be empty 2' => array(
                '<p>text <dfn><var></var></dfn></p>',
            ),
            'var can contain interactive 1' => array(
                '<p><var><a>text</a></var></p>',
            ),
            'var can contain interactive 2' => array(
                '<p><dfn><var><a>text</a></var></dfn></p>',
            ),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/var/model-novalid.html
            'var cannot contain structured inline' => array(
                '<p><var><ul><li>text</li></ul></var></p>',
                '<p><var></var></p><ul><li>text</li></ul>',
            ),
            'var cannot contain interactive if parent forbids interactive 1' => array(
                '<p><a><var><a>text</a></var></a></p>',
                '<p><a><var></var></a></p>',
            ),
            'var cannot contain interactive if parent forbids interactive 2' => array(
                '<p><a><dfn><var><a>text</a></var></dfn></a></p>',
                '<p><a><dfn><var></var></dfn></a></p>',
            ),
        );
    }
}
