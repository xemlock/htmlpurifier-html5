<?php

class HTMLPurifier_HTML5DefinitionBaseTest extends BaseTestCase
{
    public function testIframe()
    {
        $this->config->set('HTML.SafeIframe', true);
        $this->config->set('URI.SafeIframeRegexp', '%^(http:|https:)?//(www.youtube(?:-nocookie)?.com/embed/)%');

        $this->assertPurification(
            '<iframe width="640" height="360" src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allowfullscreen></iframe>'
        );
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
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider boolAttrInput
     */
    public function testBoolAttr($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }
}
