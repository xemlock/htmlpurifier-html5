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

    public function testImg()
    {
        $input = '<img src="image-src.png" srcset="image-1x.png 1x, image-2x.png 2x, image-3x.png 3x, image-4x.png 4x" sizes="(min-width: 640px) 480px" alt="">';
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

    public function audioInput()
    {
        return array(
            array('<audio controls><source src="audio.ogg" type="audio/ogg"></audio>'),
            array('<audio controls src="audio.ogg"></audio>'),
            array('<audio controls><source src="audio.ogg" type="audio/ogg">Your browser does not support audio</audio>'),
            array('<audio controls><source src="audio.ogg" type="audio/ogg"><track kind="subtitles" src="subtitles.vtt">Your browser does not support audio</audio>'),
            array('<audio controls><track kind="subtitles" src="subtitles.vtt">Your browser does not support audio</audio>'),
            array('<audio src="audio.ogg">Your browser does not support audio</audio>'),
            array('<audio src="audio.ogg"><p>Your browser does not support audio</p></audio>'),
            array('<audio src="audio.ogg"><track kind="subtitles" src="subtitles.vtt"></audio>'),
            array(
                // <audio> is a phrasing content element
                '<strong><audio controls><source type="audio/mp3" src="audio.mp3"></audio></strong>',
            ),
            array(
                // Media elements are not allowed as child elements of non-media elements
                '<audio><p><source type="audio/mp3" src="audio.mp3"></p></audio>',
                '<audio><p></p></audio>',
            ),
            array(
                '<audio></audio>',
                '',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expectedOutput OPTIONAL
     * @dataProvider audioInput
     */
    public function testAudio($input, $expectedOutput = null)
    {
        $output = $this->getPurifier()->purify($input);
        $this->assertEquals($expectedOutput !== null ? $expectedOutput : $input, $output);
    }

    public function videoInput()
    {
        return array(
            array('<video width="400" height="400" poster="poster.png"><source src="video.mp4" type="video/mp4"></video>'),
            array('<video width="400" height="400" poster="poster.png" src="video.mp4"></video>'),
            array('<video width="400" height="400" poster="poster.png"><source src="video.mp4" type="video/mp4">Your browser does not support video</video>'),
            array('<video width="400" height="400" poster="poster.png" src="video.mp4">Your browser does not support video</video>'),
            array('<video src="video.mp4"></video>'),
            array('<video src="video.mp4">Your browser does not support video</video>'),
            array('<video src="video.mp4"><p>Your browser does not support video</p></video>'),
            array('<video src="video.mp4"><track kind="subtitles" src="subtitles.vtt"></video>'),
            array('<video><source src="video.mp4" type="video/mp4"></video>'),
            array('<video><track kind="subtitles" src="subtitles.vtt"></video>'),
            array('<video><source src="video.mp4" type="video/mp4"><track kind="subtitles" src="subtitles.vtt"></video>'),
            array(
                // <video> is a phrasing content element
                '<em><video><source src="video.mp4" type="video/mp4"></video></em>',
            ),
            array(
                // Media elements are not allowed as child elements of non-media elements
                '<video><p><source src="video.mp4" type="video/mp4"</p></video>',
                '<video><p></p></video>',
            ),
            array(
                '<video></video>',
                '',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expectedOutput OPTIONAL
     * @dataProvider videoInput
     */
    public function testVideo($input, $expectedOutput = null)
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
     * @depends testAudio
     */
    public function testBoolAttr($input, $expectedOutput)
    {
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($expectedOutput, $output);
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
                '<picture> </picture>',
                '',
            ),
            array(
                // Element picture is missing required child element img
                '<picture><source src="image.webp" type="image/webp"></picture>',
                '',
            ),
            array(
                // <picture> is a phrasing content element
                '<span><picture><img src="image.png" alt=""></picture></span>',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expectedOutput OPTIONAL
     * @dataProvider pictureInput
     */
    public function testPicture($input, $expectedOutput = null)
    {
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($expectedOutput !== null ? $expectedOutput : $input, $output);
    }

    public function testPictureWithForbiddenImg()
    {
        $purifier = $this->getPurifier(array('HTML.ForbiddenElements' => array('img')));
        $output = $purifier->purify('<picture><source src="image.webp" type="image/webp"><img src="image.png" alt=""></picture>');

        $this->assertWarning('Cannot allow picture without allowing img');
        $this->assertEquals('', $output);
    }

    public function detailsInput()
    {
        return array(
            array(
                '<details><summary>Foo <strong>Bar</strong></summary>Baz <p>Qux</p></details>',
                '<details><summary>Foo <strong>Bar</strong></summary>Baz <p>Qux</p></details>',
            ),
            array(
                '<details open><summary>Foo</summary>Bar</details>',
                '<details open><summary>Foo</summary>Bar</details>',
            ),
            array(
                '<details>Foo</details>',
                '<details><summary></summary>Foo</details>',
            ),
            array(
                '<details><summary>Foo</summary><summary>Bar</summary></details>',
                '<details><summary>Foo</summary>Bar</details>',
            ),
            array(
                '<details>Foo<summary>Bar</summary>Baz</details>',
                '<details><summary>Bar</summary>FooBaz</details>',
            ),
            array(
                '<details></details>',
                '',
            ),
            array(
                '<details> </details>',
                '',
            ),
            array(
                '<summary>Foo</summary>',
                'Foo',
            ),
        );
    }

    /**
     * @dataProvider detailsInput
     */
    public function testDetails($input, $expectedOutput)
    {
        $output = $this->getPurifier()->purify($input);

        $this->assertEquals($expectedOutput, $output);
    }

    public function testDetailsWithForbiddenSummary()
    {
        $purifier = $this->getPurifier(array(
            'HTML.ForbiddenElements' => array('summary'),
        ));
        $this->assertEquals('', $purifier->purify('<details><summary>Foo</summary>Bar</summary>'));
        $this->assertWarning('Cannot allow details without allowing summary');
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
