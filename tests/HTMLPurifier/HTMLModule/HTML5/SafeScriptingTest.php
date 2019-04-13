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
        $this->assertPurification(
            '<script></script>',
            ''
        );
    }

    public function testGood()
    {
        $this->assertPurification(
            '<script type="text/javascript" src="https://localhost/foo.js" async defer charset="utf-8"></script>'
        );
    }

    public function testGoodWithAutoclosedTag()
    {
        $this->assertPurification(
            '<script type="text/javascript" src="https://localhost/foo.js" async defer charset="utf-8"/>',
            '<script type="text/javascript" src="https://localhost/foo.js" async defer charset="utf-8"></script>'
        );
    }

    public function testBad()
    {
        $this->assertPurification(
            '<script type="text/javascript" src="https://localhost/foobar.js" />',
            ''
        );
        $this->assertPurification(
            '<script type="text/javascript" src="https://localhost/FOO.JS" />',
            ''
        );
    }

    public function testBadWithContent()
    {
        $this->assertPurification(
            '<script type="text/javascript" src="">Foo</script>',
            ''
        );
        $this->assertPurification(
            '<script type="text/javascript" src="https://localhost/foo.js">Foo</script>',
            '<script type="text/javascript" src="https://localhost/foo.js"></script>'
        );
        $this->assertPurification(
            '<script type="text/javascript" src="https://localhost/foobar.js">Foo</script>',
            ''
        );
    }
}
