<?php

class HTMLPurifier_HTML5DefinitionBaseTest extends BaseTestCase
{
    public function getPurifier($config = null)
    {
        $config = HTMLPurifier_HTML5Config::create($config);
        $config->set('Cache.DefinitionImpl', null);
        $purifier = new HTMLPurifier($config);
        return $purifier;
    }

    public function testTime()
    {
        $input = '<p>This book was published <time datetime="2014-10" pubdate><em>last</em> month</time></p>';
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($input, $output);
    }

    public function testIframe()
    {
        $input = '<iframe width="640" height="360" src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allowfullscreen></iframe>';
        $output = $this->getPurifier(array(
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(http:|https:)?//(www.youtube(?:-nocookie)?.com/embed/)%',
        ))->purify($input);

        $this->assertEquals($input, $output);
    }

    /**
     * Data provider for {@link testAnchor()}
     * @return array
     */
    public function anchorInput()
    {
        return array(
            array(
                '<a href="foo" type="video/mp4" hreflang="en"><h1>Heading</h1><p>Description</p></a>',
            ),
            array(
                '<a href="foo" target="_blank" rel="nofollow">Visit</a>',
                '<a href="foo" target="_blank" rel="nofollow noreferrer noopener">Visit</a>',
            ),
            array(
                '<a href="foo" download>Download</a>',
                '<a href="foo" download="">Download</a>',
            ),
            array(
                '<a href="foo" download="bar">Download</a>',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expectedOutput OPTIONAL
     * @dataProvider anchorInput
     */
    public function testAnchor($input, $expectedOutput = null)
    {
        $output = $this->getPurifier(array(
            'Attr.AllowedFrameTargets' => array('_blank'),
        ))->purify($input);
        $this->assertEquals($expectedOutput !== null ? $expectedOutput : $input, $output);
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
     * @param string $expectedOutput OPTIONAL
     * @dataProvider figureInput
     */
    public function testFigure($input, $expectedOutput = null)
    {
        $output = $this->getPurifier()->purify($input);
        $this->assertEquals($expectedOutput !== null ? $expectedOutput : $input, $output);
    }

    public function boolAttrInput()
    {
        return array(
            array('<audio controls src="audio.ogg"></audio>', '<audio controls src="audio.ogg"></audio>'),
            array('<audio controls="" src="audio.ogg"></audio>', '<audio controls src="audio.ogg"></audio>'),
            array('<audio controls="controls" src="audio.ogg"></audio>', '<audio controls src="audio.ogg"></audio>'),
            array('<audio controls="CoNtRoLs" src="audio.ogg"></audio>', '<audio controls src="audio.ogg"></audio>'),
            array('<audio controls="bar" src="audio.ogg"></audio>', '<audio src="audio.ogg"></audio>'),
        );
    }

    /**
     * @dataProvider boolAttrInput
     */
    public function testBoolAttr($input, $expectedOutput)
    {
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($expectedOutput, $output);
    }

    public function progressInput()
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

    /**
     * @param string $input
     * @param string $expectedOutput OPTIONAL
     * @dataProvider progressInput
     */
    public function testProgress($input, $expectedOutput = null)
    {
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($expectedOutput !== null ? $expectedOutput : $input, $output);
    }
}
