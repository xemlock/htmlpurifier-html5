<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_DatetimeLocalTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input datetime' => array(
                '<input type="datetime">',
                '<input type="datetime-local">',
            ),
            'input datetime-local' => array(
                '<input type="datetime-local" name="meeting-time" value="2018-06-12T19:30" min="2018-06-07T00:00" max="2018-06-14T00:00" step="1" required>',
            ),
            'input datetime-local step any' => array(
                '<input type="datetime-local" step="any">',
            ),
            'input datetime-local invalid attributes' => array(
                '<input type="datetime-local" accept="text/plain" alt="foo" checked dirname="foo.dir" height="10" max="10" maxlength="64" min="0" minlength="0" multiple pattern="[a-z]+" placeholder="foo" size="10" src="foo.png" step="0" value="2018-06" width="10">',
                '<input type="datetime-local">',
            ),
        );
    }
}
