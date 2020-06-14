<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_InputTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->config->set('HTML.Forms', true);
    }

    public function dataProvider()
    {
        return array(
            // text
            'input no type' => array(
                '<input>',
                '<input type="text">',
            ),
            'input empty type' => array(
                '<input type="">',
                '<input type="text">',
            ),
            'input isindex name' => array(
                '<input type="text" name="isindex">',
                '<input type="text">',
            ),

            // image
            'input image alt default' => array(
                '<input type="image">',
                '<input type="image" alt="image">',
            ),
            'input image alt from name' => array(
                '<input type="image" name="image1">',
                '<input type="image" name="image1" alt="image1">',
            ),

            // datetime (obsolete)
            'input datetime' => array(
                '<input type="datetime">',
                '<input type="datetime-local">',
            ),

            // week

            //
        );
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider minMaxAttributeProvider
     */
    public function testMinMaxAttribute($input, $expected = null)
    {
        $this->testDataProvider($input, $expected);
    }

    public function minMaxAttributeProvider()
    {
        // Valid for date, month, week, time, datetime-local, number, and range
        return array(
            // date
            array(
                '<input type="date" min="2005-04-02" max="2010-04-10" step="1">',
            ),
            array(
                '<input type="date" min="2005-04" max="2010-04" step="1">',
                '<input type="date" step="1">',
            ),

            // month
            array(
                '<input type="month" min="2005-04" max="2010-04" step="1">',
            ),
            array(
                '<input type="month" min="2005" max="2010" step="1">',
                '<input type="month" step="1">',
            ),

            // week
            array(
                '<input type="week" min="2005-W13" max="2010-W14" step="1">',
            ),
            array(
                '<input type="week" min="2005" max="2010" step="1">',
                '<input type="week" step="1">',
            ),

            // time
            array(
                '<input type="time" min="21:37" max="23:59" step="1">',
            ),
            array(
                '<input type="time" min="21:37:00" max="23:59:59" step="1">',
            ),
            array(
                '<input type="time" min="21" max="23" step="1">',
                '<input type="time" step="1">',
            ),

            // datetime-local
            array(
                '<input type="datetime-local" min="2005-04-02 21:37" max="2010-04-10 08:41" step="1">',
                '<input type="datetime-local" min="2005-04-02T21:37" max="2010-04-10T08:41" step="1">',
            ),
            array(
                '<input type="datetime-local" min="2005-04-02" max="2010-04-10" step="1">',
                '<input type="datetime-local" step="1">',
            ),

            // number
            array(
                '<input type="number" min="1" max="10" step="1">',
            ),
            array(
                '<input type="number" min="2005-04" max="2010-04" step="1">',
                '<input type="number" step="1">',
            ),

            // range
            array(
                '<input type="range" min="1" max="10" step="1">',
            ),
            array(
                '<input type="range" min="2005-04" max="2010-04" step="1">',
                '<input type="range" step="1">',
            ),

            // invalid
            array(
                '<input type="button" min="1" max="10">',
                '<input type="button">',
            ),
            array(
                '<input type="checkbox" min="1" max="10">',
                '<input type="checkbox" value="">',
            ),
            array(
                '<input type="color" min="1" max="10">',
                '<input type="color">',
            ),
            array(
                '<input type="email" min="1" max="10">',
                '<input type="email">',
            ),
            array(
                '<input type="file" min="1" max="10">',
                '<input type="file">',
            ),
            array(
                '<input type="hidden" min="1" max="10">',
                '<input type="hidden" value="">',
            ),
            array(
                '<input type="image" min="1" max="10">',
                '<input type="image" alt="image">',
            ),
            array(
                '<input type="password" min="1" max="10">',
                '<input type="password">',
            ),
            array(
                '<input type="radio" min="1" max="10">',
                '<input type="radio" value="">',
            ),
            array(
                '<input type="reset" min="1" max="10">',
                '<input type="reset">',
            ),
            array(
                '<input type="search" min="1" max="10">',
                '<input type="search">',
            ),
            array(
                '<input type="submit" min="1" max="10">',
                '<input type="submit">',
            ),
            array(
                '<input type="tel" min="1" max="10">',
                '<input type="tel">',
            ),
            array(
                '<input min="1" max="10">',
                '<input type="text">',
            ),
            array(
                '<input type="text" min="1" max="10">',
                '<input type="text">',
            ),
            array(
                '<input type="url" min="1" max="10">',
                '<input type="url">',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider stepAttributeProvider
     */
    public function testStepAttribute($input, $expected = null)
    {
        $this->testDataProvider($input, $expected);
    }

    public function stepAttributeProvider()
    {
        // date, month, week, time, datetime-local, number, or range
        return array(
            // date
            array(
                '<input type="date" min="2005-04-02" max="2010-04-10" step="1">',
            ),
            array(
                '<input type="date" min="2005-04-02" max="2010-04-10" step="any">',
            ),

            // month


            // week


            // time



            // datetime-local


            // number

            // range


            // invalid
            array(
                '<input type="button" step="1">',
                '<input type="button">',
            ),
            array(
                '<input type="checkbox" step="1">',
                '<input type="checkbox" value="">',
            ),
            array(
                '<input type="color" step="1">',
                '<input type="color">',
            ),
            array(
                '<input type="email" step="1">',
                '<input type="email">',
            ),
            array(
                '<input type="file" step="1">',
                '<input type="file">',
            ),
            array(
                '<input type="hidden" step="1">',
                '<input type="hidden" value="">',
            ),
            array(
                '<input type="image" step="1">',
                '<input type="image" alt="image">',
            ),
            array(
                '<input type="password" step="1">',
                '<input type="password">',
            ),
            array(
                '<input type="radio" step="1">',
                '<input type="radio" value="">',
            ),
            array(
                '<input type="reset" step="1">',
                '<input type="reset">',
            ),
            array(
                '<input type="search" step="1">',
                '<input type="search">',
            ),
            array(
                '<input type="submit" step="1">',
                '<input type="submit">',
            ),
            array(
                '<input type="tel" step="1">',
                '<input type="tel">',
            ),
            array(
                '<input step="1">',
                '<input type="text">',
            ),
            array(
                '<input type="text" step="1">',
                '<input type="text">',
            ),
            array(
                '<input type="url" step="1">',
                '<input type="url">',
            ),
        );
    }

    public function testFile()
    {}

    public function testHidden()
    {}

    public function testImage()
    {}

    public function testMonth()
    {}

    public function testNumber()
    {}

    public function testPassword()
    {}

    public function testRange()
    {}

    public function testTime()
    {}

    public function testWeek()
    {}
}
