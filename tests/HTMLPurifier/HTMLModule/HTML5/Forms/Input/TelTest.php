<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_TelTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input tel' => array(
                '<input type="tel" disabled inputmode="tel" maxlength="64" minlength="0" name="foo" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="foo" readonly required value="+1202 456 1111" size="10">',
            ),
            'input tel empty value' => array(
                '<input type="tel" value="">',
            ),
            'input tel no value' => array(
                '<input type="tel">',
            ),
            'input tel invalid attributes' => array(
                '<input type="tel" accept="text/plain" alt="foo" checked dirname="foo.dir" height="10" max="10" min="0" multiple src="foo.png" step="1" width="10">',
                '<input type="tel">',
            ),
        );
    }
}
