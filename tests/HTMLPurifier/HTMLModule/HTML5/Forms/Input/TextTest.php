<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_TextTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input text' => array(
                '<input type="text" dirname="foo.dir" disabled inputmode="tel" maxlength="64" minlength="0" name="foo" pattern="[a-z0-9]+" placeholder="foo" readonly required value="foo" size="10">',
            ),
            'input text no type' => array(
                '<input>',
                '<input type="text">',
            ),
            'input text empty value' => array(
                '<input type="text" value="">',
            ),
            'input text no value' => array(
                '<input type="text">',
            ),
            'input text invalid attributes' => array(
                '<input type="text" accept="text/plain" alt="foo" checked height="10" max="10" min="0" multiple src="foo.png" step="1" width="10">',
                '<input type="text">',
            ),
        );
    }
}
