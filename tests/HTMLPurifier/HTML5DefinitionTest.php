<?php

class HTMLPurifier_HTML5DefinitionBaseTest extends BaseTestCase
{
    const LEGACY_MODULE_NAME = 'Legacy';

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

    /**
     * Assert that you can enable modules that weren't previously enabled.
     *
     * @return void
     */
    public function testEnableLegacyModule()
    {
        $this->config->set('HTML.EnableModules', array(static::LEGACY_MODULE_NAME));

        $this->assertPurification(
            "<table><tr bgcolor='yellow'><td>X</td></tr></table>",
           "<table><tr bgcolor=\"#FFFF00\"><td>X</td></tr></table>"
        );
    }

    /**
     * Assert that disable modules configuration option overrides the enable modules option.
     *
     * @return void
     */
    public function testDisableModule()
    {
        $this->config->set('HTML.EnableModules', array(static::LEGACY_MODULE_NAME));
        $this->config->set('HTML.DisableModules', array(static::LEGACY_MODULE_NAME));

        $this->assertPurification(
            "<table><tr bgcolor='yellow'><td>X</td></tr></table>",
            "<table><tr><td>X</td></tr></table>"
        );
    }
}
