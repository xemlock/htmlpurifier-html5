<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_EmailTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input email' => array(
                '<input type="email" disabled inputmode="email" maxlength="64" minlength="0" multiple name="email" pattern="[a-z]+@example\.com" placeholder="foo" readonly required size="10">',
            ),
            'input email empty value' => array(
                '<input type="email" value="">',
            ),
            'input email no value' => array(
                '<input type="email">',
            ),
            'input email single value' => array(
                '<input type="email" value="foo@example.com">',
            ),
            'input email multiple values' => array(
                '<input type="email" value="foo@example.com, bar@example.com" multiple>',
                '<input type="email" value="foo@example.com,bar@example.com" multiple>',
            ),
            'input email invalid value' => array(
                '<input type="email" value="foo">',
                '<input type="email">',
            ),
            'input email invalid multiple values' => array(
                '<input type="email" value="foo,bar@example.com,baz" multiple>',
                '<input type="email" value="bar@example.com" multiple>',
            ),
            'input email invalid attributes' => array(
                '<input type="email" accept="text/plain" alt="email" checked dirname="foo.dir" height="10" max="10" min="0" src="foo.png" step="1" width="10">',
                '<input type="email">',
            ),
        );
    }
}
