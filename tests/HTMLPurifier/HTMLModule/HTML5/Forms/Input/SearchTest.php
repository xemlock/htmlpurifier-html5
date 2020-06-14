<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_SearchTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input search' => array(
                '<input type="search" dirname="foo.dir" disabled inputmode="tel" maxlength="64" minlength="0" name="foo" pattern="[a-z0-9]+" placeholder="foo" readonly required value="foo" size="10">',
            ),
            'input search empty value' => array(
                '<input type="search" value="">',
            ),
            'input search no value' => array(
                '<input type="search">',
            ),
            'input search invalid attributes' => array(
                '<input type="search" accept="text/plain" alt="foo" checked height="10" max="10" min="0" multiple src="foo.png" step="1" width="10">',
                '<input type="search">',
            ),
        );
    }
}
