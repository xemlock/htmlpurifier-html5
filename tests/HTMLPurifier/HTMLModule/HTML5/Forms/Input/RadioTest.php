<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_RadioTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_BaseTest
{
    public function dataProvider()
    {
        return array(
            'input radio' => array(
                '<input type="radio" name="foo" value="foo" checked disabled>',
            ),
            'input radio empty value' => array(
                '<input type="radio" name="foo" value="">',
            ),
            'input radio no value' => array(
                '<input type="radio" name="foo">',
                '<input type="radio" name="foo" value="">',
            ),
        );
    }
}
