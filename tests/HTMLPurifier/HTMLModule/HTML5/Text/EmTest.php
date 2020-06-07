<?php

class HTMLPurifier_HTMLModule_HTML5_Text_EmTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'em basic' => array('<em>Foo</em>'),
            'em in span' => array('<span><em>Foo</em></span>'),
            'em in div' => array('<div><em>Foo</em></div>'),
            'em in heading' => array('<h1><em>Foo</em></h1>'),
            'em nested' => array('<em><em>Foo</em></em>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/em/model-isvalid.html
            'em is structured inline' => array(
                '<p><em class="class" lang="en">text</em></p>',
            ),
            'em is strictly inline' => array(
                '<p><dfn><em class="class" lang="en">text</em></dfn></p>',
            ),
            'em can be empty 1' => array(
                '<p>text <em></em></p>',
            ),
            'em can be empty 2' => array(
                '<p>text <dfn><em></em></dfn></p>',
            ),
            'em can contain interactive 1' => array(
                '<p><em><a>text</a></em></p>',
            ),
            'em can contain interactive 2' => array(
                '<p><dfn><em><a>text</a></em></dfn></p>',
            ),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/em/model-novalid.html
            'em cannot contain structured inline' => array(
                '<p><em>text <ul><li>list</li></ul></em></p>',
                '<p><em>text </em></p><ul><li>list</li></ul>',
            ),
        );
    }
}
