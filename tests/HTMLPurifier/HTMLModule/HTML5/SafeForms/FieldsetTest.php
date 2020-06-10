<?php

class HTMLPurifier_HTMLModule_HTML5_SafeForms_FieldsetTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            array(
                '<fieldset></fieldset>',
            ),
            array(
                '<fieldset><legend></legend></fieldset>',
            ),
            array(
                '<fieldset><legend>Foo</legend>Bar</fieldset>',
            ),
            array(
                '<div><fieldset><legend>Foo</legend>Bar</fieldset></div>',
            ),
            'fieldset with legend inside div' => array(
                // no tag except <fieldset> allows <legend>, so the <div> will
                // autoclose and <legend> will be moved to its valid position
                '<fieldset><div><legend>Foo</legend></div></fieldset>',
                '<fieldset><legend>Foo</legend><div></div></fieldset>',
            ),
            'fieldset with multiple legend elements' => array(
                '<fieldset><legend>Foo</legend><legend>Bar</legend></fieldset>',
                '<fieldset><legend>Foo</legend>Bar</fieldset>',
            ),
        );
    }

    public function testFieldsetWhitespace()
    {
        // depending on libxml version present whitespace handling by DOMLex
        // lexer may differ, so for testing input with whitespaces we switch
        // to more reliable lexer implementation
        $this->config->set('Core.LexerImpl', 'DirectLex');

        // legend not first
        $this->assertPurification(
            '<fieldset>  <div>Foo</div><legend>Bar</legend></fieldset>',
            '<fieldset>  <legend>Bar</legend><div>Foo</div></fieldset>'
        );
        $this->assertPurification(
            '<fieldset>  Foo<legend>Bar</legend></fieldset>',
            '<fieldset><legend>Bar</legend>  Foo</fieldset>'
        );
    }
}
