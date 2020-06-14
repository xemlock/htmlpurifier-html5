<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_ResetTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input reset' => array(
                '<input type="reset" name="foo" value="foo">',
            ),
            'input reset empty value' => array(
                '<input type="reset" name="foo" value="">',
            ),
            'input reset no value' => array(
                '<input type="reset" name="foo">',
            ),
            'input reset valid attributes' => array(
                '<input type="reset" disabled inputmode="text">',
            ),
            'input reset invalid attributes' => array(
                '<input type="reset" accept="text/plain" alt="foo" checked dirname="foo.dir" height="10" max="10" maxlength="64" min="0" minlength="0" multiple pattern="[a-z]+" placeholder="foo" readonly required size="10" src="foo.png" step="1" width="10">',
                '<input type="reset">',
            ),
        );
    }
}
