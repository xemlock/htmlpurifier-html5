<?php

/**
 * @property HTMLPurifier_AttrDef_HTML5_Week $attr
 */
class HTMLPurifier_AttrDef_HTML5_WeekTest extends AttrDefTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->attr = new HTMLPurifier_AttrDef_HTML5_Week();
    }

    /**
     * @dataProvider weekData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testWeek($input, $expected = null)
    {
        $this->assertValidate($input, $expected);
    }

    public function weekData()
    {
        return array(
            // valid
            array('0001-W01'),
            array('2000-W10'),
            array('2100-W52'),

            // invalid format
            array('', false),
            array('2000', false),
            array('2000-W1', false),

            // semantically invalid
            array('0000-W01', false),
            array('2000-W54', false),
            array('2100-W53', false),
        );
    }
}
