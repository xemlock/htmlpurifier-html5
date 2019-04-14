<?php

class HTMLPurifier_HTMLModule_HTML5_TextTest extends BaseTestCase
{
    public function testTime()
    {
        $this->assertPurification(
            '<p>This book was published <time datetime="2014-10" pubdate><em>last</em> month</time></p>'
        );
    }

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
            array(
                '<figure><img src="image.png" alt=""><figure><figcaption>Foo</figcaption></figure><figcaption>Bar</figcaption></figure>',
            ),
            array(
                '<figure></figure>',
                '',
            ),
            array(
                '<figure> </figure>',
                '',
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
}
