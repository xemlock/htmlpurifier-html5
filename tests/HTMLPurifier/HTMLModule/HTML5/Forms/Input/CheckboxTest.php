<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_CheckboxTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_BaseTest
{
    public function dataProvider()
    {
        return array(
            'input checkbox' => array(
                '<input type="checkbox" name="foo" value="foo" checked disabled>',
            ),
            'input checkbox empty value' => array(
                '<input type="checkbox" name="foo" value="">',
            ),
            'input checkbox no value' => array(
                '<input type="checkbox" name="foo">',
                '<input type="checkbox" name="foo" value="">',
            ),
        );
    }
}
