<?php

class HTMLPurifier_HTMLModule_HTML5_SafeForms_LegendTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'legend basic' => array(
                '<fieldset><legend>text</legend></fieldset>',
            ),
            'legend can be empty' => array(
                '<fieldset><legend></legend></fieldset>',
            ),
            'legend can contain heading' => array(
                '<fieldset><legend><h1>text</h1></legend></fieldset>',
            ),
            'legend can contain hrgoup' => array(
                '<fieldset><legend><hgroup><h1>text</h1></hgroup></legend></fieldset>',
            ),

            'legend cannot contain block' => array(
                '<fieldset><legend><div>text</div></legend></fieldset>',
                '<fieldset><legend></legend><div>text</div></fieldset>',
            ),
            'legend empty outside fieldset' => array(
                '<legend></legend>',
                '',
            ),
            'legend outside fieldset' => array(
                '<legend>text</legend>',
                'text',
            ),
            'legend outside fieldset inside div' => array(
                '<div><legend>text</legend></div>',
                '<div>text</div>',
            ),
        );
    }
}
