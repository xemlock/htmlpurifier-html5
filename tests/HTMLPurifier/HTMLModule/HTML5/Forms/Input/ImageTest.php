<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_ImageTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input image alt default' => array(
                '<input type="image">',
                '<input type="image" alt="image">',
            ),
            'input image alt from name' => array(
                '<input type="image" name="image1">',
                '<input type="image" name="image1" alt="image1">',
            ),
        );
    }
}
