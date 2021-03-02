<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_MonthTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input month valid attributes' => array(
                '<input type="month" min="2005-04" max="2010-04" step="1" value="2009-01">',
            ),
            'input month empty value' => array(
                '<input type="month" value="">',
            ),
            'input month no value' => array(
                '<input type="month">',
            ),
            'input month invalid attributes' => array(
                // https://html.spec.whatwg.org/multipage/input.html#month-state-(type=month)
                // The following content attributes must not be specified and do not apply to the
                // element: accept, alt, checked, dirname, formaction, formenctype, formmethod,
                // formnovalidate, formtarget, height, maxlength, minlength, multiple, pattern,
                // placeholder, size, src, and width.
                '<input type="month" accept="text/plain" alt="foo" checked dirname="foo.dir" disabled height="10" max="10" maxlength="64" min="0" minlength="0" multiple pattern="[a-z]+" placeholder="foo" readonly required size="10" src="foo.png" step="1" value="foo" width="10">',
                '<input type="month" disabled readonly required step="1">',
            ),
        );
    }
}
