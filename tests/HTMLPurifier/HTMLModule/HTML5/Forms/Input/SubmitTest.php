<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_SubmitTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_BaseTest
{
    public function dataProvider()
    {
        return array(
            'input submit' => array(
                '<input type="submit" name="foo" value="foo" disabled>',
            ),
            'input submit empty value' => array(
                '<input type="submit" name="foo" value="">',
            ),
            'input submit no value' => array(
                '<input type="submit" name="foo">',
            ),
        );
    }
}
