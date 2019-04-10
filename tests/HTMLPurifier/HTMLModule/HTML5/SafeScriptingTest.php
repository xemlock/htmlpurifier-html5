<?php

class HTMLPurifier_HTMLModule_HTML5_SafeScriptingTest extends BaseTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->config->set('HTML.SafeScripting', array('https://localhost/foo.js'));
    }

    public function testMinimal()
    {
        $this->assertResult(
            '<script></script>',
            ''
        );
    }

    public function testGood()
    {
        $this->assertResult(
            '<script type="text/javascript" src="https://localhost/foo.js" async defer charset="utf-8"></script>'
        );
    }

    public function testGoodWithAutoclosedTag()
    {
        $this->assertResult(
            '<script type="text/javascript" src="https://localhost/foo.js" async defer charset="utf-8"/>',
            '<script type="text/javascript" src="https://localhost/foo.js" async defer charset="utf-8"></script>'
        );
    }

    public function testBad()
    {
        $this->assertResult(
            '<script type="text/javascript" src="https://localhost/foobar.js" />',
            ''
        );
        $this->assertResult(
            '<script type="text/javascript" src="https://localhost/FOO.JS" />',
            ''
        );
    }

    public function testBadWithContent()
    {
        $this->assertResult(
            '<script type="text/javascript" src="">Foo</script>',
            ''
        );
        $this->assertResult(
            '<script type="text/javascript" src="https://localhost/foo.js">Foo</script>',
            '<script type="text/javascript" src="https://localhost/foo.js"></script>'
        );
        $this->assertResult(
            '<script type="text/javascript" src="https://localhost/foobar.js">Foo</script>',
            ''
        );
    }
}
