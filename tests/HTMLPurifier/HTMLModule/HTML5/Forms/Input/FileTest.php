<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_FileTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_BaseTest
{
    public function dataProvider()
    {
        return array(
            'input file' => array(
                '<input type="file" name="uploads" accept=".jpg, .jpeg, .png, .svg, .gif">',
            ),
        );
    }
}
