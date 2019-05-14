<?php

class HTMLPurifier_HTMLModule_HTML5_TextTest extends BaseTestCase
{
    public function figureInput()
    {
        return array(
            array(
                '<figure><img src="image.png" alt="An awesome picture"><figcaption>Fig.1 Image</figcaption></figure>',
            ),
            array(
                '<figure><figcaption><cite>Someone</cite></figcaption>Something</figure>',
            ),
            array(
                '<figure><p>Something</p><figcaption><cite>Someone</cite></figcaption><p>Something</p></figure>',
                '<figure><p>Something</p><figcaption><cite>Someone</cite></figcaption></figure>',
            ),
            array(
                '<figure><figcaption>Foo</figcaption><figcaption>Bar</figcaption>Baz</figure>',
                '<figure><figcaption>Foo</figcaption>Baz</figure>',
            ),
            'nested figure' => array(
                '<figure><img src="image.png" alt=""><figure><figcaption>Foo</figcaption></figure><figcaption>Bar</figcaption></figure>',
            ),
            'empty figure' => array(
                '<figure></figure>',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider figureInput
     */
    public function testFigure($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    /**
     * @dataProvider timeData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testTime($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function timeData()
    {
        return array(
            // valid month
            array('<time>2011-11</time>'),

            // valid date
            array('<time>2011-11-18</time>'),

            // valid yearless date
            array('<time>11-18</time>'),

            // valid time
            array('<time>14:54</time>'),
            array('<time>14:54:39</time>'),
            array('<time>14:54:39.929</time>'),

            // valid local date and time
            array('<time>2011-11-18T14:54</time>'),
            array('<time>2011-11-18T14:54:39</time>'),
            array('<time>2011-11-18T14:54:39.929</time>'),
            array('<time>2011-11-18 14:54</time>'),
            array('<time>2011-11-18 14:54:39</time>'),
            array('<time>2011-11-18 14:54:39.929</time>'),

            // valid time-zone offset
            array('<time>Z</time>'),
            array('<time>-08:00</time>'),
            array('<time>+00:00</time>'),
            array('<time>-0800</time>'),
            array('<time>+0000</time>'),

            // valid global date and time
            array('<time>2011-11-18T14:54Z</time>'),
            array('<time>2011-11-18T14:54:39Z</time>'),
            array('<time>2011-11-18T14:54:39.929Z</time>'),
            array('<time>2011-11-18T14:54+0000</time>'),
            array('<time>2011-11-18T14:54:39+0000</time>'),
            array('<time>2011-11-18T14:54:39.929+0000</time>'),
            array('<time>2011-11-18T14:54+00:00</time>'),
            array('<time>2011-11-18T14:54:39+00:00</time>'),
            array('<time>2011-11-18T14:54:39.929+00:00</time>'),
            array('<time>2011-11-18T06:54-0800</time>'),
            array('<time>2011-11-18T06:54:39-0800</time>'),
            array('<time>2011-11-18T06:54:39.929-0800</time>'),
            array('<time>2011-11-18T06:54-08:00</time>'),
            array('<time>2011-11-18T06:54:39-08:00</time>'),
            array('<time>2011-11-18T06:54:39.929-08:00</time>'),
            array('<time>2011-11-18 14:54Z</time>'),
            array('<time>2011-11-18 14:54:39Z</time>'),
            array('<time>2011-11-18 14:54:39.929Z</time>'),
            array('<time>2011-11-18 14:54+0000</time>'),
            array('<time>2011-11-18 14:54:39+0000</time>'),
            array('<time>2011-11-18 14:54:39.929+0000</time>'),
            array('<time>2011-11-18 14:54+00:00</time>'),
            array('<time>2011-11-18 14:54:39+00:00</time>'),
            array('<time>2011-11-18 14:54:39.929+00:00</time>'),
            array('<time>2011-11-18 06:54-0800</time>'),
            array('<time>2011-11-18 06:54:39-0800</time>'),
            array('<time>2011-11-18 06:54:39.929-0800</time>'),
            array('<time>2011-11-18 06:54-08:00</time>'),
            array('<time>2011-11-18 06:54:39-08:00</time>'),
            array('<time>2011-11-18 06:54:39.929-08:00</time>'),

            // valid week string
            array('<time>2011-W47</time>'),

            // valid year
            array('<time>2011</time>'),
            array('<time>0001</time>'),

            // valid duration
            array('<time>PT4H18M3S</time>'),
            array('<time>4h 18m 3s</time>'),

            // no datetime attribute, invalid datetime contents
            array('<time></time>', '<time datetime="1970-01-01"></time>'),
            array('<time>Foo</time>', '<time datetime="1970-01-01">Foo</time>'),
            array('<time><i>Foo</i></time>', '<time datetime="1970-01-01"><i>Foo</i></time>'),
            array('<time><time>Foo</time></time>', '<time datetime="1970-01-01">Foo</time>'),

            // inline
            array('<p>This book was published <time datetime="2014-10"><em>last</em> month</time></p>'),
        );
    }

    /**
     * @dataProvider timeDatetimeData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testTimeDatetime($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function timeDatetimeData()
    {
        return array(
            array('<time datetime="2011-11">Foo</time>'),

            // valid date
            array('<time datetime="2011-11-18">Foo</time>'),

            // valid yearless date
            array('<time datetime="11-18">Foo</time>'),

            // valid time
            array('<time datetime="14:54">Foo</time>'),
            array('<time datetime="14:54:39">Foo</time>'),
            array('<time datetime="14:54:39.929">Foo</time>'),

            // valid local date and time
            array('<time datetime="2011-11-18T14:54">Foo</time>'),
            array('<time datetime="2011-11-18T14:54:39">Foo</time>'),
            array('<time datetime="2011-11-18T14:54:39.929">Foo</time>'),
            array(
                '<time datetime="2011-11-18 14:54">Foo</time>',
                '<time datetime="2011-11-18T14:54">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39">Foo</time>',
                '<time datetime="2011-11-18T14:54:39">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39.929">Foo</time>',
                '<time datetime="2011-11-18T14:54:39.929">Foo</time>',
            ),

            // valid time-zone offset
            array('<time datetime="Z">Foo</time>'),
            array('<time datetime="+00:00">Foo</time>'),
            array('<time datetime="-08:00">Foo</time>'),
            array(
                '<time datetime="+0000">Foo</time>',
                '<time datetime="+00:00">Foo</time>',
            ),
            array(
                '<time datetime="-0800">Foo</time>',
                '<time datetime="-08:00">Foo</time>',
            ),

            // valid global date and time
            array(
                '<time datetime="2011-11-18T14:54Z">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54:39Z">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54:39.929Z">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54+0000">Foo</time>',
                '<time datetime="2011-11-18T14:54+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54:39+0000">Foo</time>',
                '<time datetime="2011-11-18T14:54:39+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54:39.929+0000">Foo</time>',
                '<time datetime="2011-11-18T14:54:39.929+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54:39+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T14:54:39.929+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T06:54-0800">Foo</time>',
                '<time datetime="2011-11-18T06:54-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T06:54:39-0800">Foo</time>',
                '<time datetime="2011-11-18T06:54:39-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T06:54:39.929-0800">Foo</time>',
                '<time datetime="2011-11-18T06:54:39.929-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T06:54-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T06:54:39-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18T06:54:39.929-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54Z">Foo</time>',
                '<time datetime="2011-11-18T14:54Z">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39Z">Foo</time>',
                '<time datetime="2011-11-18T14:54:39Z">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39.929Z">Foo</time>',
                '<time datetime="2011-11-18T14:54:39.929Z">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54+0000">Foo</time>',
                '<time datetime="2011-11-18T14:54+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39+0000">Foo</time>',
                '<time datetime="2011-11-18T14:54:39+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39.929+0000">Foo</time>',
                '<time datetime="2011-11-18T14:54:39.929+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54+00:00">Foo</time>',
                '<time datetime="2011-11-18T14:54+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39+00:00">Foo</time>',
                '<time datetime="2011-11-18T14:54:39+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 14:54:39.929+00:00">Foo</time>',
                '<time datetime="2011-11-18T14:54:39.929+00:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 06:54-0800">Foo</time>',
                '<time datetime="2011-11-18T06:54-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 06:54:39-0800">Foo</time>',
                '<time datetime="2011-11-18T06:54:39-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 06:54:39.929-0800">Foo</time>',
                '<time datetime="2011-11-18T06:54:39.929-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 06:54-08:00">Foo</time>',
                '<time datetime="2011-11-18T06:54-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 06:54:39-08:00">Foo</time>',
                '<time datetime="2011-11-18T06:54:39-08:00">Foo</time>',
            ),
            array(
                '<time datetime="2011-11-18 06:54:39.929-08:00">Foo</time>',
                '<time datetime="2011-11-18T06:54:39.929-08:00">Foo</time>',
            ),

            // valid week string
            array('<time datetime="2011-W47">Foo</time>'),

            // valid year
            array('<time datetime="2011">Foo</time>'),
            array('<time datetime="0001">Foo</time>'),

            // valid duration
            array('<time datetime="PT4H18M3S">Foo</time>'),
            array('<time datetime="4h 18m 3s">Foo</time>'),

            // time with inline elements
            array('<time datetime="Z"><i>UTC</i></time>'),

            // invalid datetime - use UNIX epoch instead of removing <time> element
            array(
                '<time datetime=""></time>',
                '<time datetime="1970-01-01"></time>',
            ),
            array(
                '<time datetime="">Foo</time>',
                '<time datetime="1970-01-01">Foo</time>',
            ),
            array(
                '<time datetime="10">Foo</time>',
                '<time datetime="1970-01-01">Foo</time>',
            ),
            array(
                '<time datetime="Foo">Foo</time>',
                '<time datetime="1970-01-01">Foo</time>',
            ),
        );
    }
}
