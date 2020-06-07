<?php

class HTMLPurifier_HTMLModule_HTML5_Text_StrongTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'strong basic' => array('<strong>Foo</strong>'),
            'strong in span' => array('<span><strong>Foo</strong></span>'),
            'strong in div' => array('<div><strong>Foo</strong></div>'),
            'strong in heading' => array('<h1><strong>Foo</strong></h1>'),
            'strong nested' => array('<strong><strong>Foo</strong></strong>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/strong/model-isvalid.html
            'strong is structured inline' => array(
                '<p><strong class="class" lang="en">text</strong></p>',
            ),
            'strong is strictly inline' => array(
                '<p><dfn><strong class="class" lang="en">text</strong></dfn></p>',
            ),
            'strong can be empty 1' => array(
                '<p>text <strong></strong></p>',
            ),
            'strong can be empty 2' => array(
                '<p>text <dfn><strong></strong></dfn></p>',
            ),
            'strong can contain interactive 1' => array(
                '<p><strong><a>text</a></strong></p>',
            ),
            'strong can contain interactive 2' => array(
                '<p><dfn><strong><a>text</a></strong></dfn></p>',
            ),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/strong/model-novalid.html
            'strong cannot contain structured inline' => array(
                '<p><strong>text <ul><li>list</li></ul></strong></p>',
                '<p><strong>text </strong></p><ul><li>list</li></ul>',
            ),
        );
    }
}
