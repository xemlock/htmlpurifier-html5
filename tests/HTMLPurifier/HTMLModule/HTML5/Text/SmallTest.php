<?php

class HTMLPurifier_HTMLModule_HTML5_Text_SmallTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'small basic' => array('<small>Foo</small>'),
            'small in span' => array('<span><small>Foo</small></span>'),
            'small in div' => array('<div><small>Foo</small></div>'),
            'small in heading' => array('<h1><small>Foo</small></h1>'),
            'small nested' => array('<small><small>Foo</small></small>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/small/model-isvalid.html
            'small is structured inline' => array(
                '<p><small class="class" lang="en">text</small></p>',
            ),
            'small is strictly inline' => array(
                '<p><dfn><small class="class" lang="en">text</small></dfn></p>',
            ),
            'small can be empty 1' => array(
                '<p>text <small></small></p>',
            ),
            'small can be empty 2' => array(
                '<p>text <dfn><small></small></dfn></p>',
            ),
            'small can contain interactive 1' => array(
                '<p><small><a>text</a></small></p>',
            ),
            'small can contain interactive 2' => array(
                '<p><dfn><small><a>text</a></small></dfn></p>',
            ),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/small/model-novalid.html
            'small cannot contain structured inline' => array(
                '<p><small>text <ul><li>list</li></ul></small></p>',
                '<p><small>text </small></p><ul><li>list</li></ul>',
            ),
        );
    }
}
