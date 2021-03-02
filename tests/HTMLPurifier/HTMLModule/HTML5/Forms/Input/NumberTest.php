<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_NumberTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input number valid attributes' => array(
                '<input type="number" min="10" max="100" step=".01" value="21.37">',
            ),
            'input number empty value' => array(
                '<input type="number" value="">',
            ),
            'input number no value' => array(
                '<input type="number">',
            ),
            'input number invalid attributes' => array(
                // https://html.spec.whatwg.org/multipage/input.html#number-state-(type=number)
                // The following content attributes must not be specified and do not apply to the
                // element: accept, alt, checked, dirname, formaction, formenctype, formmethod,
                // formnovalidate, formtarget, height, maxlength, minlength, multiple, pattern,
                // size, src, and width.
                '<input type="number" accept="text/plain" alt="foo" checked dirname="foo.dir" disabled height="10" max="10" maxlength="64" min="0" minlength="0" multiple pattern="[a-z]+" placeholder="foo" readonly required size="10" src="foo.png" step="1" value="foo" width="10">',
                '<input type="number" disabled max="10" min="0" placeholder="foo" readonly required step="1">',
            ),
        );
    }
}
