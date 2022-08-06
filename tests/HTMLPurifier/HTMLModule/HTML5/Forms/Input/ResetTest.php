<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_ResetTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_BaseTest
{
    public function dataProvider()
    {
        return array(
            'input reset' => array(
                '<input type="reset" name="foo" value="foo" disabled>',
            ),
            'input reset empty value' => array(
                '<input type="reset" name="foo" value="">',
            ),
            'input reset no value' => array(
                '<input type="reset" name="foo">',
            ),
        );
    }
}
