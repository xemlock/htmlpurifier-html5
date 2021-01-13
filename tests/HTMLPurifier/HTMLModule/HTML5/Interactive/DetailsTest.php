<?php

class HTMLPurifier_HTMLModule_HTML5_Interactive_DetailsTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            array(
                '<details><summary>Foo <strong>Bar</strong></summary>Baz <p>Qux</p></details>',
                '<details><summary>Foo <strong>Bar</strong></summary>Baz <p>Qux</p></details>',
            ),
            array(
                '<details open><summary>Foo</summary>Bar</details>',
                '<details open><summary>Foo</summary>Bar</details>',
            ),
            array(
                '<details>Foo</details>',
                '<details><summary></summary>Foo</details>',
            ),
            array(
                '<details><summary>Foo</summary><summary>Bar</summary></details>',
                '<details><summary>Foo</summary>Bar</details>',
            ),
            array(
                '<details>Foo<summary>Bar</summary>Baz</details>',
                '<details><summary>Bar</summary>FooBaz</details>',
            ),
            array(
                '<details class="foo"><summary>Foo</summary></details>',
            ),
            array(
                '<details></details>',
                '',
            ),
            array(
                '<summary>Foo</summary>',
                'Foo',
            ),
            'summary can contain heading' => array(
                '<details><summary><h1>Foo</h1></summary></details>',
            ),
            'summary cannot contain flow content' => array(
                '<details><summary><div>Foo</div></summary></details>',
                '<details><summary></summary><div>Foo</div></details>',
            ),
            'summary contains multiple headings' => array(
                '<details><summary><h1>Foo</h1><h2>Bar</h2></summary>Baz</details>',
            ),
            'summary contains headings and phrasing content' => array(
                '<details><summary><h1>Foo</h1>Bar</summary>Baz</details>',
            ),
            'summary can contain img' => array(
                '<details><summary><img src="foo.png" alt=""></summary></details>',
            ),
        );
    }

    public function testDetailsWithWhitespace()
    {
        // depending on libxml version present whitespace handling by DOMLex
        // lexer may differ, so for testing input with whitespaces we switch
        // to more reliable lexer implementation
        $this->config->set('Core.LexerImpl', 'DirectLex');

        $this->assertPurification(
            '<details>  </details>',
            ''
        );
        $this->assertPurification(
            '<details>  <div>Foo</div></details>',
            '<details>  <summary></summary><div>Foo</div></details>'
        );
        $this->assertPurification(
            '<details>  Foo</details>',
            '<details><summary></summary>  Foo</details>'
        );
    }

    public function testDetailsWithForbiddenSummary()
    {
        $this->config->set('HTML.ForbiddenElements', array('summary'));

        $this->assertPurification('<details><summary>Foo</summary>Bar</summary>', '');
        $this->assertWarning('Cannot allow details without allowing summary');
    }
}
