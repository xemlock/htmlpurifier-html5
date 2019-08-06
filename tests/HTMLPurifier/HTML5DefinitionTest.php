<?php

class HTMLPurifier_HTML5DefinitionBaseTest extends BaseTestCase
{
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
