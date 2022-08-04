<?php

class HTMLPurifier_HTMLModule_HTML5_TablesTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            array('<table></table>'),
            array('<table><caption><h3>foo</h3><p>bar<p>baz</caption></table>', '<table><caption><h3>foo</h3><p>bar</p><p>baz</p></caption></table>'),
            array('<table><caption><h3>foo</h3></caption></table>'),
            array('<table><caption><p>foo<p>bar</caption></table>', '<table><caption><p>foo</p><p>bar</p></caption></table>'),
            array('<table><caption>foo</caption></table>'),
            array('<table><caption>foo</table>', '<table><caption>foo</caption></table>'),
            array('<table><caption>foo </table>', '<table><caption>foo </caption></table>'),
            array('<table><caption><div>foo<table></table>bar</div> baz</caption></table>', '<table><caption><div>foobar</div> baz</caption></table>'),
            array('<table><tbody><tr><th>foo</th></tr></tbody><caption>foo</caption></table>', '<table><caption>foo</caption><tbody><tr><th>foo</th></tr></tbody></table>'),
            array('<table><thead><tr><th>foo</th></tr></thead></table>'),
            array('<table><tr><th>foo</th></tr></table>'),
            array('<table><tbody><tr><th>foo</th></tr></tbody></table>'),
            array('<table><tr><td>foo</td></tr></table>'),
            array('<table><thead><tr><th>foo</th></tr></thead><tbody><tr><th>foo</th></tr></tbody></table>'),
            array('<table><tr><th>foo</th></tr><tr><td>foo</td></tr></table>'),
        );
    }
}
