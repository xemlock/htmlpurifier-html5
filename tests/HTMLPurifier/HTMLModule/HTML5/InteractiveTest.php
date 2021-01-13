<?php

class HTMLPurifier_HTMLModule_HTML5_InteractiveTest extends BaseTestCase
{
    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider dialogDataProvider
     */
    public function testDialog($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function dialogDataProvider()
    {
        return array(
            array(
                '<dialog></dialog>',
            ),
            array(
                '<dialog open class="foo"></dialog>',
            ),
            array(
                '<dialog><h1>Foo</h1><p>Bar</p></dialog>',
            ),
            array(
                '<dialog tabindex="1"><h1>Foo</h1></dialog>',
                '<dialog><h1>Foo</h1></dialog>',
            ),
        );
    }
}
