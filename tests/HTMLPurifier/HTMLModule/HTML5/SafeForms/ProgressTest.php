<?php

class HTMLPurifier_HTMLModule_HTML5_SafeForms_ProgressTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            array(
                '<progress></progress>',
            ),
            array(
                '<progress>Foo</progress>',
            ),
            array(
                '<progress value="1" max="100"></progress>',
            ),
            array(
                '<progress value=".1"></progress>',
            ),
            array(
                // Bad numeric value for attribute value on element progress
                // Bad numeric value for attribute max on element progress
                '<progress value="0x01" max="0x02"></progress>',
                '<progress></progress>',
            ),
            array(
                // The value of the 'value' attribute must be less than or
                // equal to one when the max attribute is absent.
                '<progress value="10"></progress>',
                '<progress value="1"></progress>',
            ),
            array(
                '<progress value="-1"></progress>',
                '<progress></progress>',
            ),
            array(
                '<progress value=".5" max=".25"></progress>',
                '<progress value=".25" max=".25"></progress>',
            ),
            'progress invalid max' => array(
                '<progress max="0"></progress>',
                '<progress></progress>',
            ),
            'progress cannot contain nested progress elements' => array(
                '<progress><progress></progress></progress>',
                '<progress></progress>',
            ),
            'progress cannot contain progress element amont its descendants' => array(
                '<progress><em><progress>text</progress></em></progress>',
                '<progress><em></em></progress>',
            ),
            'progress can contain phrasing content only' => array(
                '<progress><div>text</div></progress>',
                '<progress></progress><div>text</div>',
            ),
        );
    }
}
