<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_Input_SubmitTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
{
    public function dataProvider()
    {
        return array(
            'input submit' => array(
                '<input type="submit" name="foo" value="foo" disabled inputmode="text">',
            ),
            'input submit empty value' => array(
                '<input type="submit" name="foo" value="">',
            ),
            'input submit no value' => array(
                '<input type="submit" name="foo">',
            ),
            'input submit invalid attributes' => array(
                '<input type="submit" accept="text/plain" alt="foo" checked dirname="foo.dir" height="10" max="10" maxlength="64" min="0" minlength="0" multiple pattern="[a-z]+" placeholder="foo" readonly required size="10" src="foo.png" step="1" width="10">',
                '<input type="submit">',
            ),
        );
    }
}
