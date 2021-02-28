<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_HiddenTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input hidden' => array(
                '<input type="hidden" name="foo" value="foo" disabled>',
            ),
            'input hidden no value attribute' => array(
                '<input type="hidden">',
                '<input type="hidden" value="">',
            ),
            'input hidden empty value attribute' => array(
                '<input type="hidden" value="">',
            ),
            'input hidden invalid attributes' => array(
                '<input type="hidden" accept="text/plain" alt="foo" checked dirname="foo.dir" height="10" max="10" maxlength="64" min="0" minlength="0" multiple pattern="[a-z]+" placeholder="foo" readonly required size="10" src="foo.png" step="1" width="10">',
                '<input type="hidden" value="">',
            ),
        );
    }
}
