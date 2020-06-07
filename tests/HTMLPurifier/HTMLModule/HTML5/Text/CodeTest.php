<?php

class HTMLPurifier_HTMLModule_HTML5_Text_CodeTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'code basic' => array('<code>Foo</code>'),
            'code in span' => array('<span><code>Foo</code></span>'),
            'code in div' => array('<div><code>Foo</code></div>'),
            'code in heading' => array('<h1><code>Foo</code></h1>'),
            'code nested' => array('<code><code>Foo</code></code>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/code/model-isvalid.html
            'code is structured inline' => array(
                '<p><code class="class" lang="en">text</code></p>',
            ),
            'code is strictly inline' => array(
                '<p><dfn><code class="class" lang="en">text</code></dfn></p>',
            ),
            'code can be empty 1' => array(
                '<p>text <code></code></p>',
            ),
            'code can be empty 2' => array(
                '<p>text <dfn><code></code></dfn></p>',
            ),
            'code can contain interactive 1' => array(
                '<p><code><a>text</a></code></p>',
            ),
            'code can contain interactive 2' => array(
                '<p><dfn><code><a>text</a></code></dfn></p>',
            ),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/code/model-novalid.html
            'code cannot contain structured inline' => array(
                '<p><code>text <ul><li>list</li></ul></code></p>',
                '<p><code>text </code></p><ul><li>list</li></ul>',
            ),
        );
    }
}
