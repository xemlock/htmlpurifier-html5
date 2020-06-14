<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_RadioTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input radio' => array(
                '<input type="radio" name="foo" value="foo" checked disabled inputmode="text" required>',
            ),
            'input radio empty value' => array(
                '<input type="radio" name="foo" value="">',
            ),
            'input radio no value' => array(
                '<input type="radio" name="foo">',
                '<input type="radio" name="foo" value="">',
            ),
            'input radio invalid attributes' => array(
                '<input type="radio" accept="text/plain" alt="foo" dirname="foo.dir" height="10" max="10" maxlength="64" min="0" minlength="0" multiple pattern="[a-z]+" placeholder="foo" readonly size="10" src="foo.png" step="1" width="10">',
                '<input type="radio" value="">',
            ),
        );
    }
}
