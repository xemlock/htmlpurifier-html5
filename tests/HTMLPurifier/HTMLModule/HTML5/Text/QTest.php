<?php

class HTMLPurifier_HTMLModule_HTML5_Text_QTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'q basic' => array('<q>Foo</q>'),
            'q in span' => array('<span><q>Foo</q></span>'),
            'q in div' => array('<div><q>Foo</q></div>'),
            'q in heading' => array('<h1><q>Foo</q></h1>'),
            'q nested' => array('<q><q>Foo</q></q>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/q/model-isvalid.html
            'q is structured inline' => array(
                '<p><q cite="url" class="class" lang="en">text</q></p>',
            ),
            'q is strictly inline' => array(
                '<p><dfn><q cite="url" class="class" lang="en">text</q></dfn></p>',
            ),
            'q can be empty 1' => array(
                '<p>text <q></q></p>',
            ),
            'q can be empty 2' => array(
                '<p>text <dfn><q></q></dfn></p>',
            ),
            'q can contain interactive 1' => array(
                '<p><q><a>text</a></q></p>',
            ),
            'q can contain interactive 2' => array(
                '<p><dfn><q><a>text</a></q></dfn></p>',
            ),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/q/model-novalid.html
            'q cannot contain structured inline' => array(
                '<p><q>text <ul><li>list</li></ul></q></p>',
                '<p><q>text </q></p><ul><li>list</li></ul>',
            ),
        );
    }
}
