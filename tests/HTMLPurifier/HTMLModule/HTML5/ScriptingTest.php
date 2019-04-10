<?php

class HTMLPurifier_HTMLModule_HTML5_ScriptingTest extends BaseTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->config->set('HTML.Trusted', true);
    }

    public function testDefaultRemoval()
    {
        $this->config->set('HTML.Trusted', false);
        $this->assertResult(
            '<script type="text/javascript">foo();</script>',
            ''
        );
    }

    public function testPreserve()
    {
        $this->assertResult(
            '<script type="text/javascript">foo();</script>'
        );
    }

    public function testAllAttributes()
    {
        $this->assertResult(
            '<script defer src="test.js" type="text/javascript" charset="utf-8" async></script>'
        );
        $this->assertResult(
            '<script defer src="" type="text/javascript">PCDATA</script>',
            '<script defer type="text/javascript">PCDATA</script>'
        );
        $this->assertResult(
            '<script defer src="script.js" type="text/javascript">PCDATA</script>',
            '<script defer src="script.js" type="text/javascript"></script>'
        );
        $this->assertResult(
            '<p><script>document.write("Foo")</script></p>'
        );
        $this->assertResult(
            '<span><script>document.write("Foo")</script></span>'
        );
    }

    public function testUnsupportedAttributes()
    {
        $this->assertResult(
            '<script type="text/javascript" crossorigin="use-credentials">PCDATA</script>',
            '<script type="text/javascript">PCDATA</script>'
        );
    }

    /**
     * @param string $input
     * @param string $expectedOutput OPTIONAL
     * @dataProvider noscriptDataProvider
     */
    public function testNoscript($input, $expectedOutput = null)
    {
        $this->assertResult($input, $expectedOutput);
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
                '<noscript>Foo</noscript><noscript>Bar</noscript>Baz',
            ),
            'deeply nested' => array(
                '<noscript>Foo<span><noscript>Bar</noscript></span></noscript>',
                '<noscript>Foo<span>Bar</span></noscript>',
            ),
        );
    }

    public function testNoscriptInP()
    {
        $this->config->autoFinalize = false;

        // PHP DOM parser fails at parsing <noscript> in <p>, which affects
        // the default HTMLPurifier lexer (DOMLex)
        $this->assertResult(
            '<p><noscript>Foo</noscript></p>',
            '<p></p><noscript>Foo</noscript>'
        );

        // PH5P lexer properly handles <noscript> in <p> elements
        $this->config->set('Core.LexerImpl', 'PH5P');
        $this->assertResult(
            '<p><noscript>Foo</noscript></p>'
        );

        $this->config->set('Core.LexerImpl', null);
    }
}
