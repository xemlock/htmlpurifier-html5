<?php

class HTMLPurifier_HTMLModule_HTML5_Scripting_ScriptTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    protected function setUp()
    {
        parent::setUp();

        $this->config->set('HTML.Trusted', true);
    }

    public function dataProvider()
    {
        return array(
            'script inline' => array(
                '<script type="text/javascript">foo();</script>'
            ),
            'script valid attributes' => array(
                '<script defer src="test.js" type="text/javascript" charset="utf-8" async></script>'
            ),
            'script empty src in inline script' => array(
                '<script defer src="" type="text/javascript">PCDATA</script>',
                '<script defer type="text/javascript">PCDATA</script>'
            ),
            'script src in inline script' => array(
                '<script defer src="script.js" type="text/javascript">PCDATA</script>',
                '<script defer src="script.js" type="text/javascript"></script>'
            ),
            'script in p' => array(
                '<p><script>document.write("Foo")</script></p>'
            ),
            'script in inline' => array(
                '<span><script>document.write("Foo")</script></span>'
            ),
            'script in heading' => array(
                '<h1><script>document.write("Foo")</script></h1>'
            ),
            'script unsupported attributes' => array(
                '<script type="text/javascript" crossorigin="use-credentials">PCDATA</script>',
                '<script type="text/javascript">PCDATA</script>'
            ),

            // integrity metadata tests
            'script valid integrity' => array(
                '<script src="script.js" integrity="sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY=" crossorigin="anonymous"></script>',
            ),
            'script invalid integrity' => array(
                '<script src="script.js" integrity="sha256-fooBar"></script>',
                '<script src="script.js"></script>',
            ),
            'script multiple integrity hashes' => array(
                '<script src="script.js" integrity="sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY= sha384-H8BRh8j48O9oYatfu5AZzq6A9RINhZO5H16dQZngK7T62em8MUt1FLm52t+eX6xO sha512-Q2bFTOhEALkN8hOms2FKTDLy7eugP2zFZ1T8LCvX42Fp3WoNr3bjZSAHeOsHrbV1Fu9/A0EzCinRE7Af1ofPrw=="></script>',
            ),
            'script multiple integrity hashes invalid removed' => array(
                '<script src="script.js" integrity="sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY= sha384-H8BRh8j48O9oYatfu5AZzq6A9RINhZO5H16dQZngK7T62em8MUt1FLm52t+eX6xO sha256-fooBar"></script>',
                '<script src="script.js" integrity="sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY= sha384-H8BRh8j48O9oYatfu5AZzq6A9RINhZO5H16dQZngK7T62em8MUt1FLm52t+eX6xO"></script>',
            ),
            'script integrity should be removed if no src present' => array(
                '<script integrity="sha256-ymsp1QFcwiJbIgAoSOkMtqe4GFczZH1KjXLq6y5f+QY=">foo();</script>',
                '<script>foo();</script>',
            ),
        );
    }

    public function testDefaultRemoval()
    {
        $this->config->set('HTML.Trusted', false);
        $this->assertPurification(
            '<script type="text/javascript">foo();</script>',
            ''
        );
    }
}
