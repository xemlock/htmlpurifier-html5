<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_ColorTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input color' => array(
                '<input type="color" name="foo" value="#ff0000" disabled inputmode="text">',
            ),
            'input color empty value' => array(
                '<input type="color" name="foo" value="">',
            ),
            'input color no value' => array(
                '<input type="color" name="foo" value="">',
            ),
            'input color invalid value 1' => array(
                '<input type="color" name="foo" value="foo">',
                '<input type="color" name="foo">',
            ),
            'input color invalid value 2' => array(
                '<input type="color" name="foo" value="#f00">',
                '<input type="color" name="foo" value="#ff0000">',
            ),
            'input color invalid value 3' => array(
                '<input type="color" name="foo" value="#ff000000">',
                '<input type="color" name="foo">',
            ),
            'input color invalid attributes' => array(
                '<input type="color" accept="text/plain" alt="foo" checked dirname="foo.dir" height="10" max="10" maxlength="64" min="0" minlength="0" multiple pattern="[a-z]+" placeholder="foo" readonly required size="10" src="foo.png" step="1" width="10">',
                '<input type="color">',
            ),
        );
    }
}
