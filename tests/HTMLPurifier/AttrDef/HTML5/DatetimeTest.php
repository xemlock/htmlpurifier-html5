<?php

/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpUnhandledExceptionInspection */

/**
 * @property HTMLPurifier_AttrDef_HTML5_Datetime $attr
 */
class HTMLPurifier_AttrDef_HTML5_DatetimeTest extends AttrDefTestCase
{
    /**
     * @var string
     */
    protected $defaultTimezone;

    protected function setUp()
    {
        parent::setUp();

        $this->defaultTimezone = date_default_timezone_get();

        date_default_timezone_set('UTC');
    }

    protected function tearDown()
    {
        parent::tearDown();

        date_default_timezone_set($this->defaultTimezone);
    }

    /**
     * @param HTMLPurifier_AttrDef_HTML5_Datetime|string|string[] $attr
     * @return $this
     */
    public function attr($attr = null)
    {
        if ($attr instanceof HTMLPurifier_AttrDef_HTML5_Datetime) {
            $this->attr = $attr;
        } else {
            $this->attr = new HTMLPurifier_AttrDef_HTML5_Datetime((array) $attr);
        }
        return $this;
    }

    /**
     * @dataProvider yearData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testYear($input, $expected = null)
    {
        $this->attr('Year')->assertValidate($input, $expected);
    }

    public function yearData()
    {
        return array(
            // valid
            array('2010'),
            array('0001'),
            array('40000'),

            // valid year extracted from month, date and datetime strings
            array('2010-04', '2010'),
            array('2010-04-10', '2010'),
            array('2010-04-10 08:41:04', '2010'),
            array('2010-04-10 08:41:04+02:00', '2010'),

            // invalid
            array('', false),
            array('0000', false),
            array('100', false),
        );
    }

    /**
     * @dataProvider monthData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testMonth($input, $expected = null)
    {
        $this->attr('Month')->assertValidate($input, $expected);
    }

    public function monthData()
    {
        return array(
            // valid month
            array('0001-01'),
            array('2010-04'),
            array('40000-04'),

            // valid month extracted from date and datetime strings
            array('2010-04-10', '2010-04'),
            array('2010-04-10 08:41:04', '2010-04'),
            array('2010-04-10 08:41:04+02:00', '2010-04'),

            // invalid
            array('', false),
            array('0000-00', false),
            array('0000-01', false),
            array('2000-15', false),
            array('2000-20', false),
            array('100-01', false),
        );
    }

    /**
     * @dataProvider dateData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testDate($input, $expected = null)
    {
        $this->attr('Date')->assertValidate($input, $expected);
    }

    public function dateData()
    {
        return array(
            // valid
            array('0001-01-01'),
            array('2000-02-29'),
            array('2010-04-10'),

            // valid date extracted from datetime strings
            array('2010-04-10 08:41:04', '2010-04-10'),
            array('2010-04-10 08:41:04+02:00', '2010-04-10'),

            // invalid
            array('', false),
            array('0000-01-01', false),
            array('2000-15-01', false),
            array('2000-20-01', false),
            array('2100-02-29', false),
            array('100-01-01', false),
        );
    }

    /**
     * @dataProvider timeData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testTime($input, $expected = null)
    {
        $this->attr('Time')->assertValidate($input, $expected);
    }

    public function timeData()
    {
        return array(
            // valid time
            array('00:00'),
            array('00:00:00'),
            array('12:34'),
            array('12:34:56'),
            array('12:34:56.789'),
            array('12:34:56.000', '12:34:56'),
            array('12:34:56.001', '12:34:56.001'),
            array('12:34:56.01', '12:34:56.01'),
            array('12:34:56.010', '12:34:56.01'),
            array('12:34:56.100', '12:34:56.1'),
            array('12:34:56.6666', '12:34:56.667'),

            // valid time extracted from datetime
            array('2010-04-10 08:41:04', '08:41:04'),

            // invalid time
            array('', false),
            array('24:00', false),
            array('00:60', false),
            array('00:00:60', false),
        );
    }

    /**
     * @dataProvider datetimeLocalData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testDatetimeLocal($input, $expected = null)
    {
        $this->attr('DatetimeLocal')->assertValidate($input, $expected);
    }

    public function datetimeLocalData()
    {
        return array(
            // valid
            array('2010-04-10 08:41', '2010-04-10T08:41'),
            array('2010-04-10 08:41:04', '2010-04-10T08:41:04'),
            array('2010-04-10 08:41:04.321', '2010-04-10T08:41:04.321'),
            array('2010-04-10T08:41'),
            array('2010-04-10T08:41:04'),
            array('2010-04-10T08:41:04.321'),

            // extracted from global datetime
            array('2010-04-10 08:41+02:00', '2010-04-10T08:41'),
            array('2010-04-10 08:41:04+02:00', '2010-04-10T08:41:04'),
            array('2010-04-10 08:41:04.321+02:00', '2010-04-10T08:41:04.321'),
            array('2010-04-10T08:41+02:00', '2010-04-10T08:41'),
            array('2010-04-10T08:41:04+02:00', '2010-04-10T08:41:04'),
            array('2010-04-10T08:41:04.321+02:00', '2010-04-10T08:41:04.321'),

            // incomplete
            array('2010-04-10', false),
            array('2010-04', false),
            array('2010', false),

            // invalid
            array('', false),
            array('2100-02-29 00:00', false),
            array('2000-01-01 24:00', false),
            array('2020-20-20 00:00', false),
            array('100-01-01 00:00', false),
        );
    }

    /**
     * @dataProvider datetimeGlobalData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testDatetimeGlobal($input, $expected = null)
    {
        $this->attr('DatetimeGlobal')->assertValidate($input, $expected);
    }

    public function datetimeGlobalData()
    {
        return array(
            // valid
            array('2010-04-10 08:41+02:00', '2010-04-10T08:41+02:00'),
            array('2010-04-10 08:41:04+02:00', '2010-04-10T08:41:04+02:00'),
            array('2010-04-10 08:41:04.321+02:00', '2010-04-10T08:41:04.321+02:00'),
            array('2010-04-10T08:41+02:00'),
            array('2010-04-10T08:41:04+02:00'),
            array('2010-04-10T08:41:04.321+02:00'),

            array('2010-04-10 10:41Z', '2010-04-10T10:41Z'),
            array('2010-04-10 10:41:04Z', '2010-04-10T10:41:04Z'),
            array('2010-04-10 08:41:04.321Z', '2010-04-10T08:41:04.321Z'),
            array('2010-04-10T10:41Z'),
            array('2010-04-10T10:41:04Z'),
            array('2010-04-10T08:41:04.321Z'),

            array('2010-04-10 08:41+0200', '2010-04-10T08:41+02:00'),
            array('2010-04-10 08:41:04+0200', '2010-04-10T08:41:04+02:00'),
            array('2010-04-10 08:41:04.321+0200', '2010-04-10T08:41:04.321+02:00'),
            array('2010-04-10T08:41+0200', '2010-04-10T08:41+02:00'),
            array('2010-04-10T08:41:04+0200', '2010-04-10T08:41:04+02:00'),
            array('2010-04-10T08:41:04.321+0200', '2010-04-10T08:41:04.321+02:00'),

            // valid after normalization
            array('2010-04-10 10:41z', '2010-04-10T10:41Z'),
            array('2010-04-10t10:41Z', '2010-04-10T10:41Z'),

            // missing timezone offset, taken from server
            array('2010-04-10 08:41', '2010-04-10T08:41+00:00'),
            array('2010-04-10T08:41:04', '2010-04-10T08:41:04+00:00'),

            // incomplete
            array('2010-04-10', false),
            array('2010-04', false),
            array('2010', false),

            // invalid
            array('', false),
            array('2000-01-01 00:00+24:00', false),
            array('2000-01-01 24:00+00:00', false),
            array('2100-02-29 00:00+00:00', false),
            array('2020-20-20 00:00+00:00', false),
            array('100-01-01 00:00', false),
        );
    }

    /**
     * @dataProvider datetimeData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testDatetime($input, $expected = null)
    {
        $this->attr('Datetime')->assertValidate($input, $expected);
    }

    public function datetimeData()
    {
        return array(
            // valid
            array('2010-04-10 08:41', '2010-04-10T08:41'),
            array('2010-04-10 08:41:04', '2010-04-10T08:41:04'),
            array('2010-04-10 08:41:04.321', '2010-04-10T08:41:04.321'),
            array('2010-04-10T08:41'),
            array('2010-04-10T08:41:04'),
            array('2010-04-10T08:41:04.321'),

            array('2010-04-10 08:41+02:00', '2010-04-10T08:41+02:00'),
            array('2010-04-10 08:41:04+02:00', '2010-04-10T08:41:04+02:00'),
            array('2010-04-10 08:41:04.321+02:00', '2010-04-10T08:41:04.321+02:00'),
            array('2010-04-10T08:41+02:00'),
            array('2010-04-10T08:41:04+02:00'),
            array('2010-04-10T08:41:04.321+02:00'),

            array('2010-04-10 10:41Z', '2010-04-10T10:41Z'),
            array('2010-04-10 10:41:04Z', '2010-04-10T10:41:04Z'),
            array('2010-04-10 08:41:04.321Z', '2010-04-10T08:41:04.321Z'),
            array('2010-04-10T10:41Z'),
            array('2010-04-10T10:41:04Z'),
            array('2010-04-10T08:41:04.321Z'),

            // incomplete
            array('2010-04-10', false),
            array('2010-04', false),
            array('2010', false),

            // invalid
            array('', false),

            array('2100-02-29 00:00', false),
            array('2000-01-01 24:00', false),
            array('2020-20-20 00:00', false),
            array('100-01-01 00:00', false),

            array('2000-01-01 00:00+24:00', false),
            array('2000-01-01 24:00+00:00', false),
            array('2100-02-29 00:00+00:00', false),
            array('2020-20-20 00:00+00:00', false),
            array('100-01-01 00:00+01:00', false),
        );
    }

    /**
     * @dataProvider timezoneOffsetData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testTimezoneOffset($input, $expected = null)
    {
        $this->attr('TimezoneOffset')->assertValidate($input, $expected);
    }

    public function timezoneOffsetData()
    {
        return array(
            // valid
            array('Z'),
            array('+00:00'),
            array('-08:00'),
            array('+0000', '+00:00'),
            array('-0800', '-08:00'),
            array('+01:23'),
            array('-04:56'),

            // invalid but fixable
            array('z', 'Z'),
            array('-00:00', '+00:00'),

            // invalid
            array('', false),
            array('-24:00', false),
            array('24:00', false),
            array('00:60', false),
        );
    }

    /**
     * @dataProvider defaultData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testDefault($input, $expected = null)
    {
        $this->attr()->assertValidate($input, $expected);
    }

    public function defaultData()
    {
        return array(
            // valid local datetime
            array('2010-04-10 08:41', '2010-04-10T08:41'),
            array('2010-04-10 08:41:04', '2010-04-10T08:41:04'),
            array('2010-04-10 08:41:04.321', '2010-04-10T08:41:04.321'),
            array('2010-04-10T08:41'),
            array('2010-04-10T08:41:04'),
            array('2010-04-10T08:41:04.321'),

            // valid global datetime
            array('2010-04-10 08:41+02:00', '2010-04-10T08:41+02:00'),
            array('2010-04-10 08:41:04+02:00', '2010-04-10T08:41:04+02:00'),
            array('2010-04-10 08:41:04.321+02:00', '2010-04-10T08:41:04.321+02:00'),
            array('2010-04-10T08:41+02:00'),
            array('2010-04-10T08:41:04+02:00'),
            array('2010-04-10T08:41:04.321+02:00'),

            array('2010-04-10 10:41Z', '2010-04-10T10:41Z'),
            array('2010-04-10 10:41:04Z', '2010-04-10T10:41:04Z'),
            array('2010-04-10 08:41:04.321Z', '2010-04-10T08:41:04.321Z'),
            array('2010-04-10T10:41Z'),
            array('2010-04-10T10:41:04Z'),
            array('2010-04-10T08:41:04.321Z'),

            // valid time
            array('00:00'),
            array('00:00:00'),
            array('12:34'),
            array('12:34:56'),
            array('12:34:56.789'),
            array('12:34:56.000', '12:34:56'),
            array('12:34:56.6666', '12:34:56.667'),

            // valid date
            array('0001-01-01'),
            array('2000-02-29'),
            array('2010-04-10'),

            // valid month
            array('0001-01'),
            array('2010-04'),
            array('40000-04'),

            // valid year
            array('2010'),
            array('0001'),
            array('40000'),

            // valid timezone offset
            array('Z'),
            array('+00:00'),
            array('-08:00'),
            array('+0000', '+00:00'),
            array('-0800', '-08:00'),

            // invalid
            array('', false),

            // invalid datetime
            array('2100-02-29 00:00', false),
            array('2000-01-01 24:00', false),
            array('2020-20-20 00:00', false),
            array('100-01-01 00:00', false),

            array('2000-01-01 00:00+24:00', false),
            array('2000-01-01 24:00+00:00', false),
            array('2100-02-29 00:00+00:00', false),
            array('2020-20-20 00:00+00:00', false),
            array('100-01-01 00:00+01:00', false),

            // invalid time
            array('', false),
            array('24:00', false),
            array('00:60', false),
            array('00:00:60', false),

            // invalid date
            array('0000-01-01', false),
            array('2100-02-29', false),
            array('2100-20-20', false),
            array('100-01-01', false),

            // invalid month
            array('2010-20', false),
            array('0000-01', false),
            array('100-01', false),

            // invalid year
            array('0000', false),
            array('100', false),

            // invalid timezone offset
            array('-24:00', false),
            array('24:00', false),
            array('00:60', false),
        );
    }

    public function testMake()
    {
        $factory = new HTMLPurifier_AttrDef_HTML5_Datetime();
        $attr = $factory->make('Time,Datetime');

        $this->assertInstanceOf(get_class($factory), $attr);

        $this->attr = $attr;
        $this->assertValidate('21:37');
        $this->assertValidate('2005-04-02 21:37', '2005-04-02T21:37');
    }

    /**
     * @expectedException HTMLPurifier_Exception
     * @expectedExceptionMessage not a valid format
     */
    public function testInvalidFormat()
    {
        new HTMLPurifier_AttrDef_HTML5_Datetime(array('Invalid'));
    }
}
