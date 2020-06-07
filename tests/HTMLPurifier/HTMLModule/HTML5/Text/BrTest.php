<?php

class HTMLPurifier_HTMLModule_HTML5_Text_BrTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'br basic' => array('<br>'),
            'br xhtml' => array('<br/>', '<br>'),
            'br close' => array('<br>text</br>', '<br>text'),
            'br in div' => array('<div><br></div>'),
            'br in heading' => array('<h1><br></h1>'),

            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/html/elements/br/model-isvalid.html
            'br is structured inline' => array(
                '<p>text <br class="class" lang="en"></p>',
            ),
            'br is strictly inline' => array(
                '<p>text <dfn><br class="class" lang="en"></dfn></p>',
            ),
        );
    }
}
