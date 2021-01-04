<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_MonthTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input month valid min max attributes' => array(
                '<input type="month" min="2005-04" max="2010-04" step="1">',
            ),
            'input month invalid min max attributes' => array(
                '<input type="month" min="2005" max="2010" step="1">',
                '<input type="month" step="1">',
            ),
        );
    }
}
