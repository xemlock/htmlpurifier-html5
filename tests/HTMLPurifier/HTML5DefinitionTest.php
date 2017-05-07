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

    public function testFigure()
    {
        $input = '<figure><img src="image.png" alt="An awesome picture"><figcaption>Fig1. Image</figcaption></figure>';
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($input, $output);
    }

    public function testAudio()
    {
        $input = '<audio controls><source src="audio.ogg" type="audio/ogg"></audio>';
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($input, $output);
    }

    public function testVideo()
    {
        $input = '<video width="400" height="400" poster="poster.png"><source src="video.mp4" type="video/mp4"></video>';
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($input, $output);
    }
}
