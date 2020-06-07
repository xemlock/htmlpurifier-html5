<?php

class HTMLPurifier_HTMLModule_HTML5_Text_SampTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'samp basic' => array('<samp>Foo</samp>'),
            'samp in span' => array('<span><samp>Foo</samp></span>'),
            'samp in div' => array('<div><samp>Foo</samp></div>'),
            'samp in heading' => array('<h1><samp>Foo</samp></h1>'),
            'samp nested' => array('<samp><samp>Foo</samp></samp>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/samp/model-isvalid.html
            'samp is structured inline' => array(
                '<p><samp class="class" lang="en">text</samp></p>',
            ),
            'samp is strictly inline' => array(
                '<p><dfn><samp class="class" lang="en">text</samp></dfn></p>',
            ),
            'samp can be empty 1' => array(
                '<p>text <samp></samp></p>',
            ),
            'samp can be empty 2' => array(
                '<p>text <dfn><samp></samp></dfn></p>',
            ),
            'samp can contain interactive 1' => array(
                '<p><samp><a>text</a></samp></p>',
            ),
            'samp can contain interactive 2' => array(
                '<p><dfn><samp><a>text</a></samp></dfn></p>',
            ),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/samp/model-novalid.html
            'samp cannot contain structured inline' => array(
                '<p><samp>text <ul><li>list</li></ul></samp></p>',
                '<p><samp>text </samp></p><ul><li>list</li></ul>',
            ),
        );
    }
}
