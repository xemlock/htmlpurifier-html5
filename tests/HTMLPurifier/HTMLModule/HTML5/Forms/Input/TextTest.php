<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_TextTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_BaseTest
{
    public function dataProvider()
    {
        return array(
            'input text' => array(
                '<input type="text" disabled maxlength="64" name="foo" readonly value="foo" size="10">',
            ),
            'input text empty value' => array(
                '<input type="text" value="">',
            ),
            'input text no value' => array(
                '<input type="text">',
            ),
        );
    }
}
