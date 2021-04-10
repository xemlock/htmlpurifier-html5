<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_WeekTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input week valid attributes' => array(
                // The following common input element content attributes apply to the element:
                // autocomplete, disabled, list, max, min, readonly, required, and step.
                '<input type="week" min="2005-W01" max="2010-W12" step="1" value="2009-W05" readonly required>',
            ),
            'input week empty value' => array(
                '<input type="week" value="">',
            ),
            'input week no value' => array(
                '<input type="week">',
            ),
            'input week invalid value' => array(
                '<input type="week" value="foo">',
                '<input type="week">',
            ),
            'input week invalid attributes' => array(
                // https://html.spec.whatwg.org/multipage/input.html#week-state-(type=week)
                // The following content attributes must not be specified and do not apply to the
                // element: accept, alt, checked, dirname, formaction, formenctype, formmethod,
                // formnovalidate, formtarget, height, maxlength, minlength, multiple, pattern,
                // placeholder, size, src, and width.
                '<input type="week" acqcept="text/plain" alt="foo" checked dirname="foo.dir" height="10" max="10" maxlength="64" min="0" minlength="0" multiple pattern="[a-z]+" placeholder="foo" size="10" src="foo.png" width="10">',
                '<input type="week">',
            ),
        );
    }
}
