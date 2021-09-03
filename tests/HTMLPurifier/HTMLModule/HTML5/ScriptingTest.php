<?php

class HTMLPurifier_HTMLModule_HTML5_ScriptingTest extends BaseTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->config->set('HTML.Trusted', true);
    }

    /**
     * @param string $input
     * @param string $expectedOutput OPTIONAL
     * @dataProvider noscriptDataProvider
     */
    public function testNoscript($input, $expectedOutput = null)
    {
        $this->assertPurification($input, $expectedOutput);
    }

    /**
     * Data provider for {@link testNoscript()}
     *
     * @return array
     */
    public function noscriptDataProvider()
    {
        return array(
            'basic' => array(
                '<noscript>Foo</noscript>',
            ),
            'empty' => array(
                '<noscript></noscript>',
                ''
            ),
            'in block element' => array(
                '<div><noscript>Foo</noscript></div>',
            ),
            'in inline element' => array(
                '<span><noscript>Foo</noscript></span>',
            ),
            'with content' => array(
                '<noscript><h1>Foo</h1><div>Bar</div><p>Baz</p><span>Qux</span></noscript>',
            ),
            'nested' => array(
                '<noscript>Foo<noscript>Bar</noscript>Baz</noscript>',
                '<noscript>FooBaz</noscript>',
            ),
            'deeply nested' => array(
                '<noscript>Foo<span><noscript>Bar</noscript></span></noscript>',
                '<noscript>Foo<span></span></noscript>',
            ),
        );
    }

    public function testNoscriptInP()
    {
        $this->config->autoFinalize = false;

        // PHP DOM (xmldom 2.9.1) parser fails at parsing <noscript> in <p>, which affects
        // the default HTMLPurifier lexer (DOMLex):
        //     <p><noscript>Foo</noscript></p>
        // is purified into:
        //     <p></p><noscript>Foo</noscript>
        // In more recent xmldom versions (2.9.12) this is no longer the case.

        // PH5P lexer properly handles <noscript> in <p> elements
        $this->config->set('Core.LexerImpl', 'PH5P');
        $this->assertPurification(
            '<p><noscript>Foo</noscript></p>'
        );

        $this->config->set('Core.LexerImpl', null);
    }
}
