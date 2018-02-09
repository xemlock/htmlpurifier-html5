<?php

class HTMLPurifier_HTML5DefinitionTest extends PHPUnit_Framework_TestCase
{
    public function getPurifier($config = null)
    {
        $config = HTMLPurifier_HTML5Config::create($config);
        $purifier = new HTMLPurifier($config);
        return $purifier;
    }

    public function testTime()
    {
        $input = '<p>This book was published <time datetime="2014-10" pubdate><em>last</em> month</time></p>';
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($input, $output);
    }

    public function testImg()
    {
        $input = '<img src="image-src.png" srcset="image-1x.png 1x, image-2x.png 2x, image-3x.png 3x, image-4x.png 4x" alt="">';
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

    public function figureInput()
    {
        return array(
            array('<figure><img src="image.png" alt="An awesome picture"><figcaption>Fig1. Image</figcaption></figure>'),
            array('<figure><p>Something</p><figcaption><cite>Someone</cite></figcaption><p>Something</p></figure>'),
            array('<figure><figcaption><cite>Someone</cite></figcaption>Something</figure>'),
            array('<figure></figure>'),
        );
    }

    /**
     * @dataProvider figureInput
     */
    public function testFigure($input)
    {
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($input, $output);
    }

    public function audioInput()
    {
        return array(
            array('<audio controls><source src="audio.ogg" type="audio/ogg"></audio>'),
            array('<audio controls src="audio.ogg"></audio>'),
            array('<audio controls><source src="audio.ogg" type="audio/ogg">Your browser does not support audio</audio>'),
            array('<audio controls src="audio.ogg">Your browser does not support audio</audio>'),
        );
    }

    /**
     * @dataProvider audioInput
     */
    public function testAudio($input)
    {
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($input, $output);
    }

    public function videoInput()
    {
        return array(
            array('<video width="400" height="400" poster="poster.png"><source src="video.mp4" type="video/mp4"></video>'),
            array('<video width="400" height="400" poster="poster.png" src="video.mp4"></video>'),
            array('<video width="400" height="400" poster="poster.png"><source src="video.mp4" type="video/mp4">Your browser does not support video</video>'),
            array('<video width="400" height="400" poster="poster.png" src="video.mp4">Your browser does not support video</video>'),
        );
    }

    /**
     * @dataProvider videoInput
     */
    public function testVideo($input)
    {
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($input, $output);
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
     * @depends testAudio
     */
    public function testBoolAttr($input, $expectedOuptut)
    {
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($expectedOuptut, $output);
    }

    public function pictureInput()
    {
        return array(
            array(
                '<picture><img src="image.png" alt=""></picture>',
                '<picture><img src="image.png" alt=""></picture>',
            ),
            array(
                '<picture><source src="image.webp" type="image/webp"><img src="image.png" alt=""></picture>',
                '<picture><source src="image.webp" type="image/webp"><img src="image.png" alt=""></picture>',
            ),
            array(
                // Text not allowed in element picture
                '<picture>Text before<img src="image.png" alt=""></picture>',
                '<picture><img src="image.png" alt=""></picture>',
            ),
            array(
                // Text not allowed in element picture
                '<picture><img src="image.png" alt="">Text after</picture>',
                '<picture><img src="image.png" alt=""></picture>',
            ),
            array(
                // More than one child element img
                '<picture><img src="image.png" alt=""><img src="image2.png" alt=""></picture>',
                '<picture><img src="image.png" alt=""></picture>',
            ),
            array(
                // Child element source must be before child element img
                '<picture><img src="image.png" alt=""><source src="image.webp" type="image/webp"></picture>',
                '<picture><img src="image.png" alt=""></picture>',
            ),
            array(
                // Element picture is missing required child element img
                '<picture></picture>',
                '',
            ),
            array(
                // Element picture is missing required child element img
                '<picture><source src="image.webp" type="image/webp"></picture>',
                '',
            ),
        );
    }

    /**
     * @dataProvider pictureInput
     */
    public function testPicture($input, $expectedOuptut)
    {
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($expectedOuptut, $output);
    }
}
