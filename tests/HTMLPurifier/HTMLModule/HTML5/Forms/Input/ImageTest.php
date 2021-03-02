<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_ImageTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input image' => array(
                '<input type="image" alt="foo" height="10" src="http://foo.com/foo.png" width="10">',
            ),
            'input image alt default' => array(
                '<input type="image">',
                '<input type="image" alt="image">',
            ),
            'input image alt from name' => array(
                '<input type="image" name="image1">',
                '<input type="image" name="image1" alt="image1">',
            ),
            'input image invalid attributes' => array(
                // https://html.spec.whatwg.org/multipage/input.html#image-button-state-(type=image)
                // The following content attributes must not be specified and do not apply to the
                // element: accept, autocomplete, checked, dirname, list, max, maxlength, min,
                // minlength, multiple, pattern, placeholder, readonly, required, size, and step.
                '<input type="image" accept="image/jpeg" alt="foo" checked dirname="foo.dir" disabled height="10" max="10" maxlength="64" min="0" minlength="0" multiple pattern="[a-z]+" placeholder="foo" readonly required size="10" src="foo.png" step="1" value="foo.png" width="10">',
                '<input type="image" alt="foo" disabled height="10" src="foo.png" width="10">',
            ),
        );
    }
}
