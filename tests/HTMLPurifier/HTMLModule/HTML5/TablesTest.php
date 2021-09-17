<?php

class HTMLPurifier_HTMLModule_HTML5_TablesTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            array('<table></table>'),
            array('<table><thead><tr><th>foo</th></tr></thead></table>'),
            array('<table><tr><th>foo</th></tr></table>'),
            array('<table><tbody><tr><th>foo</th></tr></tbody></table>'),
            array('<table><tr><td>foo</td></tr></table>'),
            array('<table><thead><tr><th>foo</th></tr></thead><tbody><tr><th>foo</th></tr></tbody></table>'),
            array('<table><tr><th>foo</th></tr><tr><td>foo</td></tr></table>'),
        );
    }
}
