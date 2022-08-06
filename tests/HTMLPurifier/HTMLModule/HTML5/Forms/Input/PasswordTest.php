<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_PasswordTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_BaseTest
{
    public function dataProvider()
    {
        return array(
            'input password' => array(
                '<input type="password" disabled maxlength="64" name="foo" readonly value="foo" size="10">',
            ),
            'input password empty value' => array(
                '<input type="password" value="">',
            ),
            'input password no value' => array(
                '<input type="password">',
            ),
        );
    }
}
