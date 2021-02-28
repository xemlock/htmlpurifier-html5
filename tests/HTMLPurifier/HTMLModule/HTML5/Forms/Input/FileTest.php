<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_FileTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input file' => array(
                '<input type="file" name="uploads" accept=".jpg, .jpeg, .png, .svg, .gif" multiple required>',
            ),
            'input file invalid attributes' => array(
                '<input type="file" alt="foo" checked dirname="foo.dir" height="10" max="10" maxlength="10" min="0" minlength="0" pattern="[a-z]+" size="10" src="foo.png" step="1" value="foo.jpg" width="10">',
                '<input type="file">',
            ),
        );
    }
}
