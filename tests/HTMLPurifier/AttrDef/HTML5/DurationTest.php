<?php

/**
 * @property HTMLPurifier_AttrDef_HTML5_Duration $attr
 */
class HTMLPurifier_AttrDef_HTML5DurationTest extends AttrDefTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->attr = new HTMLPurifier_AttrDef_HTML5_Duration();
    }

    /**
     * @dataProvider durationData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testISODuration($input, $expected = null)
    {
        $this->assertValidate($input, $expected);
    }

    public function durationData()
    {
        return array(
            // valid
            array('PT4H18M3S'),
            array('P1DT4H18M3S'),

            array('PT4H18M3.0S', 'PT4H18M3S'),
            array('PT4H18M3.010S', 'PT4H18M3.01S'),
            array('PT4H18M3.100S', 'PT4H18M3.1S'),

            array('1w 2d 3m 4s'),
            array('1w 2d 3m 4.0s', '1w 2d 3m 4s'),
            array('1w 2d 3m 4.010s', '1w 2d 3m 4.01s'),
            array('1w 2d 3m 4.100s', '1w 2d 3m 4.1s'),

            array('1w 4s'),
            array('1w'),
            array('2d'),
            array('3m'),
            array('4s'),

            // empty duration
            array('0d', '0s'),
            array('0.000s', '0s'),

            // any order
            array('4s 3m 2d 1w', '1w 2d 3m 4s'),

            // seconds
            array('4.100s', '4.1s'),
            array('4.010s', '4.01s'),
            array('4.001s', '4.001s'),

            // zero pad
            array('08h 41m 04s', '8h 41m 4s'),

            // spaces between values and units
            array('8 h 41 m 4 s', '8h 41m 4s'),

            // no spaces between parts
            array('8h41m4s', '8h 41m 4s'),

            // case sensitivity
            array('1W 2D 3M 4S', '1w 2d 3m 4s'),
            array('1W 2d 3M 4s', '1w 2d 3m 4s'),

            // invalid but fixable
            array('PT', 'PT0S'),
            array('P1W', 'P7D'),
            array('P1W1D', 'P8D'),
            array('PT4H18M3.6666S', 'PT4H18M3.667S'),
            array('pt4H18M3s', 'PT4H18M3S'),

            // duplicated components, only first is relevant
            array('1w 2w 3h 4h', '1w 3h'),

            // round extra decimals
            array('4.0001s', '4s'),
            array('4.6666s', '4.667s'),

            // invalid
            array('', false),
            array('2010-04-10', false),
        );
    }
}
