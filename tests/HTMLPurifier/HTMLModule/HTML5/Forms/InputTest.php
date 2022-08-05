<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_InputTest extends BaseTestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->config->set('HTML.Forms', true);
    }

    public function testAllowedInputTypes()
    {
        $this->config->autoFinalize = false;

        $this->config->set('Attr.AllowedInputTypes', null);
        $this->assertPurification('<input type="text">');

        $this->config->set('Attr.AllowedInputTypes', array());
        $this->assertPurification('<input type="text">', '');

        $this->config->set('Attr.AllowedInputTypes', array('password'));
        $this->assertPurification(
            '<input type="text"><input type="password">',
            '<input type="password">'
        );

        // input type is obligatory in XHTML1.0
        // $this->config->set('Attr.AllowedInputTypes', null);
        // $this->assertPurification(
        //    '<input><input type="foo">',
        //    '<input><input>'
        // );

        $this->config->set('Attr.AllowedInputTypes', array('password'));
        $this->assertPurification('<input><input type="text">', '');
    }

    // public function testEmptyType()
    // {
    //    $this->assertPurification('<input>');
    //    $this->assertPurification('<input type="">', '<input>');
    // }
}
