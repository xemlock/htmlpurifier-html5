<?php

class HTMLPurifier_HTMLModule_HTML5_FormsTest extends BaseTestCase
{
    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider fieldsetDataProvider
     */
    public function testFieldset($input, $expected = null)
    {
        $this->config->set('HTML.Trusted', true);

        $this->assertPurification($input, $expected);
    }

    public function fieldsetDataProvider()
    {
        return array(
            array(
                '<fieldset></fieldset>',
            ),
            array(
                '<fieldset><legend></legend></fieldset>',
            ),
            array(
                '<fieldset><legend>Foo</legend>Bar</fieldset>',
            ),
            array(
                '<form action="foo"><fieldset><legend>Foo</legend>Bar</fieldset></form>',
            ),
            array(
                '<div><fieldset><legend>Foo</legend>Bar</fieldset></div>',
            ),
            // no tag except <fieldset> allows <legend>, so the <div> will
            // autoclose and <legend> will be moved to its valid position
            'legend inside div' => array(
                '<fieldset><div><legend>Foo</legend></div></fieldset>',
                '<fieldset><legend>Foo</legend><div></div></fieldset>',
            ),
            'multiple legend elements' => array(
                '<fieldset><legend>Foo</legend><legend>Bar</legend></fieldset>',
                '<fieldset><legend>Foo</legend>Bar</fieldset>',
            ),
        );
    }

    public function testFieldsetWhitespace()
    {
        // depending on libxml version present whitespace handling by DOMLex
        // lexer may differ, so for testing input with whitespaces we switch
        // to more reliable lexer implementation
        $this->config->set('Core.LexerImpl', 'DirectLex');
        $this->config->set('HTML.Trusted', true);

        $this->assertPurification('
            <form action="foo">
                <fieldset disabled name="bar">
                    <legend>Personal Information</legend>
                    Last Name: <input name="personal_lastname" type="text" tabindex="1">
                    First Name: <input name="personal_firstname" type="text" tabindex="2">
                    Address: <input name="personal_address" type="text" tabindex="3">
                </fieldset>
            </form>
        ');

        // legend not first
        $this->assertPurification(
            '<fieldset>  <div>Foo</div><legend>Bar</legend></fieldset>',
            '<fieldset>  <legend>Bar</legend><div>Foo</div></fieldset>'
        );
        $this->assertPurification(
            '<fieldset>  Foo<legend>Bar</legend></fieldset>',
            '<fieldset><legend>Bar</legend>  Foo</fieldset>'
        );
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider legendDataProvider
     */
    public function testLegend($input, $expected = null)
    {
        $this->config->set('HTML.Trusted', true);

        $this->assertPurification($input, $expected);
    }

    public function legendDataProvider()
    {
        return array(
            'empty legend outside fieldset' => array(
                '<legend></legend>',
                '',
            ),
            'legend outside fieldset' => array(
                '<legend>Foo</legend>',
                'Foo',
            ),
            'legend outside fieldset inside div' => array(
                '<div><legend>Foo</legend></div>',
                '<div>Foo</div>',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider progressDataProvider
     */
    public function testProgress($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
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
