<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_HiddenTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_BaseTest
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
        );
    }
}
