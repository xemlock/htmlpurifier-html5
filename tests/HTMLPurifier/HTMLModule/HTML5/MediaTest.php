<?php

class HTMLPurifier_HTMLModule_HTML5_MediaTest extends BaseTestCase
{
    public function testImg()
    {
        $this->assertResult(
            '<img src="image-src.png" srcset="image-1x.png 1x, image-2x.png 2x" sizes="(min-width: 640px) 480px" alt="">'
        );
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider pictureDataProvider
     */
    public function testPicture($input, $expected = null)
    {
        $this->assertResult($input, $expected);
    }

    public function pictureDataProvider()
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

    public function testPictureWithForbiddenImg()
    {
        $this->config->set('HTML.ForbiddenElements', array('img'));

        $this->assertResult(
            '<picture><source src="image.webp" type="image/webp"><img src="image.png" alt=""></picture>',
            ''
        );
        $this->assertWarning('Cannot allow picture without allowing img');
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider audioDataProvider
     */
    public function testAudio($input, $expected = null)
    {
        $this->assertResult($input, $expected);
    }

    public function audioDataProvider()
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
     * @param string $expected OPTIONAL
     * @dataProvider videoDataProvider
     */
    public function testVideo($input, $expected = null)
    {
        $this->assertResult($input, $expected);
    }

    public function videoDataProvider()
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
}
