<?php

class HTMLPurifier_HTMLModule_HTML5_FormsTest extends BaseTestCase
{
    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider progressDataProvider
     */
    public function testProgress($input, $expected = null)
    {
        $this->assertResult($input, $expected);
    }

    public function progressDataProvider()
    {
        return array(
            array(
                '<progress></progress>',
            ),
            array(
                '<progress value="1" max="100"></progress>',
            ),
            array(
                '<progress value=".1"></progress>',
            ),
            array(
                // Bad numeric value for attribute value on element progress
                // Bad numeric value for attribute max on element progress
                '<progress value="0x01" max="0x02"></progress>',
                '<progress></progress>',
            ),
            array(
                // The value of the 'value' attribute must be less than or
                // equal to one when the max attribute is absent.
                '<progress value="10"></progress>',
                '<progress value="1"></progress>',
            ),
            array(
                '<progress value="-1"></progress>',
                '<progress></progress>',
            ),
            array(
                '<progress value=".5" max=".25"></progress>',
                '<progress value=".25" max=".25"></progress>',
            ),
            array(
                '<progress max="0"></progress>',
                '<progress></progress>',
            ),
            array(
                // No nested <progress> elements
                '<progress><progress></progress></progress>',
                '<progress></progress>',
            ),
            array(
                // Phrasing content, but there must be no <progress> element among its descendants.
                '<progress><em><progress>Foo</progress></em></progress>',
                '<progress><em>Foo</em></progress>',
            ),
            array(
                // Phrasing content only
                '<progress><div>Foo</div></progress>',
                '<progress></progress><div>Foo</div>',
            ),
        );
    }
}
