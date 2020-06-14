<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_ButtonTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input button' => array(
                '<input type="button" name="foo" value="foo" disabled inputmode="text">',
            ),
            // This is where Nu Validator doesn't conform to WHATWG spec, because it
            // requires a non-empty value attribute to be present, whereas according
            // to the spec value attribute is optional, and an empty string is
            // perfectly valid.
            // "A label for the button must be provided in the value attribute,
            // though it may be the empty string. If the element has a value attribute,
            // the button's label must be the value of that attribute"
            // https://html.spec.whatwg.org/multipage/input.html#button-state-(type=button)
            'input button empty value' => array(
                '<input type="button" name="foo" value="">',
            ),
            'input button no value' => array(
                '<input type="button" name="foo">',
            ),
            'input button invalid attributes' => array(
                '<input type="button" accept="text/plain" alt="foo" dirname="foo.dir" height="10" max="10" maxlength="64" min="0" minlength="0" multiple pattern="[a-z]+" placeholder="foo" readonly required size="10" src="foo.png" step="1" width="10">',
                '<input type="button">',
            ),
        );
    }
}
