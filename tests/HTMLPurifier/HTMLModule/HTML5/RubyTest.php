<?php

class HTMLPurifier_HTMLModule_HTML5_RubyTest extends PHPUnit_Framework_TestCase
{
    public function getPurifier($config = null)
    {
        $config = HTMLPurifier_HTML5Config::create($config);
        $config->set('Cache.DefinitionImpl', null);
        $purifier = new HTMLPurifier($config);
        return $purifier;
    }

    public function rubyInput()
    {
        return array(
            array(
                '<ruby>明日<rp>(</rp><rt>あした</rt><rp>)</rp></ruby>',
            ),
            array(
                '<ruby>明日<rt>あした</rt></ruby>',
            ),
            array(
                '<ruby>明日<rt></rt></ruby>',
            ),
            array(
                '<ruby>明日<rp></rp><rt></rt><rp></rp></ruby>',
            ),
            array(
                '<ruby>Foo<rp><rt><rp></ruby>',
                '<ruby>Foo<rp></rp><rt></rt><rp></rp></ruby>',
            ),
            array(
                // Element ruby is missing a required instance of child element rp.
                '<ruby>Foo<rp><rt></ruby>',
                '',
            ),
            array(
                // Element ruby is missing a required instance of one or more of
                // the following child elements: rp, rt, rtc.
                '<ruby>Foo<rp></rp></ruby>',
                '',
            ),
            array(
                // Element ruby is missing a required instance of one or more of
                // the following child elements: rp, rt, rtc.
                '<ruby>Foo</ruby>',
                '',
            ),
            array(
                '<ruby><rb>Bar</rb><rt>Baz</rt></ruby>',
            ),
            array(
                // Text before <rb> element
                '<ruby>Foo<rb>Bar</rb><rt>Baz</rt></ruby>',
            ),
            array(
                '<ruby><rb>Bar</rb><rp>(</rp><rt>Baz</rt><rp>)</rp></ruby>',
            ),
            array(
                // Multiple sequences of <rb><rt> elements
                '<ruby><rb>Bar</rb><rt>Baz</rt><rb>Qux</rb><rt>Quux</rt></ruby>',
            ),
            array(
                // Text after <rb> element
                '<ruby><rb>Bar</rb>Baz<rt>Qux</rt></ruby>',
            ),
            array(
                // Multiple consecutive <rb> elements
                '<ruby><rb>Bar</rb><rb>Baz</rb><rb>Qux</rb>Quux<rt>Quuz</rt></ruby>',
            ),
            array(
                // Element ruby is missing a required instance of one or more of
                // the following child elements: rp, rt, rtc.
                '<ruby>Foo<rb>Bar</rb><rt>Baz</rt><rb>Qux</rb></ruby>',
                '',
            ),
            array(
                // Inline element in <ruby>
                '<ruby><span>Foo</span><rt></rt></ruby>',
            ),
            array(
                // Block-level elements are moved outside <ruby>
                '<ruby><div>Foo</div><rt></rt></ruby>',
                '<div>Foo</div>',
            ),
            array(
                '<ruby><rb>Foo</rb><rt>Bar</rt></ruby>'
            ),
            array(
                '<ruby>Foo<rb>Bar</rb><rb>Baz</rb><rb>Qux</rb><rt></rt><rb>Quux</rb><rt></rt></ruby>',
            ),
            array(
                // Empty <rtc> element
                '<ruby><rtc></rtc></ruby>',
            ),
            array(
                // Properly auto-close <rtc> element
                '<ruby><rtc>Foo<rtc>Bar</ruby>',
                '<ruby><rtc>Foo</rtc><rtc>Bar</rtc></ruby>',
            ),
            array(
                // Multiple <rtc> elements
                '<ruby><rtc>Foo<rp></rp>Bar<rt></rt></rtc><rtc>Baz</rtc></ruby>',
            ),
            array(
                // Block-level elements are moved outside <rtc>
                '<ruby><rtc><div>Foo</div></rtc></ruby>',
                '<ruby><rtc></rtc></ruby><div>Foo</div>',
            ),
            array(
                // <rt> element can only be child of <ruby> and <rtc> elements
                '<rt>Foo</rt>',
                'Foo',
            ),
            array(
                // <rp> element can only be child of <ruby> and <rtc> elements
                '<rp>Foo</rp>',
                'Foo',
            ),
            array(
                // <rb> element can only be child of <ruby> element
                '<rb>Foo</rb>',
                'Foo',
            ),
            array(
                // <rtc> element can only be child of <ruby> element
                '<rtc>Foo</rtc>',
                'Foo',
            ),
            array(
                // Nested <ruby> elements
                '<ruby><rtc><ruby>Foo<rt></rt></ruby><rt><ruby>Bar<rt></rt></ruby></rt></rtc></ruby>',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expectedOutput OPTIONAL
     * @dataProvider rubyInput
     */
    public function testRuby($input, $expectedOutput = null)
    {
        $output = $this->getPurifier()->purify($input);
        $this->assertEquals($expectedOutput !== null ? $expectedOutput : $input, $output);
    }
}
