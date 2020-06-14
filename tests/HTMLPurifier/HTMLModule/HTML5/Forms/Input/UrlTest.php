<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_UrlTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input url empty value' => array(
                '<input type="url" value="">',
            ),
            'input url no value' => array(
                '<input type="url">',
            ),
            'input url absolute uri' => array(
                '<input type="url" value="https://foo-bar.com/file.txt">',
            ),
            'input url relative uri' => array(
                '<input type="url" value="file.txt">',
                '<input type="url">',
            ),
            'input url valid attributes' => array(
                '<input type="url" disabled inputmode="url" maxlength="64" minlength="0" name="url" pattern="http://.*" placeholder="foo" readonly required size="10">',
            ),
            'input url invalid attributes' => array(
                '<input type="url" accept="text/plain" alt="foo" checked dirname="foo.dir" height="10" max="10" min="0" multiple src="foo.png" step="1" width="10">',
                '<input type="url">',
            ),
        );
    }
}
