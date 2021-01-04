<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_DatetimeLocalTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input datetime' => array(
                '<input type="datetime">',
                '<input type="datetime-local">',
            ),
        );
    }
}
