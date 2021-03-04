<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_PasswordTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input password' => array(
                '<input type="password" disabled maxlength="64" minlength="0" name="foo" pattern="[-0-9]+" placeholder="foo" readonly required value="foo" size="10">',
            ),
            'input password empty value' => array(
                '<input type="password" value="">',
            ),
            'input password no value' => array(
                '<input type="password">',
            ),
            'input password invalid attributes' => array(
                // https://html.spec.whatwg.org/multipage/input.html#password-state-(type=password)
                // The following content attributes must not be specified and do not apply to
                // the element: accept, alt, checked, dirname, formaction, formenctype, formmethod,
                // formnovalidate, formtarget, height, list, max, min, multiple, src, step, and width.
                '<input type="password" accept="text/plain" alt="foo" checked dirname="foo.dir" formaction="http://foo.com" formenctype="application/x-www-form-urlencoded" formmethod="post" formnovalidate formtarget="_self" height="10" list="foo" max="10" min="0" multiple src="foo.png" step="1" width="10">',
                '<input type="password">',
            ),
        );
    }
}
