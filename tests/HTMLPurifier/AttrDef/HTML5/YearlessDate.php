<?php

/**
 * @property HTMLPurifier_AttrDef_HTML5_YearlessDate $attr
 */
class HTMLPurifier_AttrDef_HTML5_YearlessDateTest extends AttrDefTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->attr = new HTMLPurifier_AttrDef_HTML5_YearlessDate();
    }

    /**
     * @dataProvider yearlessDateData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testYearlessDate($input, $expected = null)
    {
        $this->assertValidate($input, $expected);
    }

    public function yearlessDateData()
    {
        return array(
            // valid
            array('01-01'),
            array('02-29'),
            array('04-10'),
            array('12-31'),

            // invalid format
            array('', false),
            array('1-1', false),
            array('1-01', false),
            array('01-1', false),

            // semantically invalid
            array('00-01', false),
            array('20-01', false),
            array('01-40', false),
            array('02-30', false),
            array('04-31', false),
        );
    }
}
