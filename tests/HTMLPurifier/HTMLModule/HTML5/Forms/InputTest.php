<?php

class HTMLPurifier_HTMLModule_HTML5_Forms_InputTest
    extends HTMLPurifier_HTMLModule_HTML5_Forms_BaseTest
{
    public function dataProvider()
    {
        return array(
            'input no type' => array(
                '<input>',
            ),
            'input empty type' => array(
                '<input type="">',
                '<input>',
            ),
            'input invalid type' => array(
                '<input type="foo">',
                '<input>',
            ),
            'input is structured inline' => array(
                '<p><input type="text"></p>',
            ),
            'input is strictly inline' => array(
                '<p><dfn><input type="text"></dfn></p>',
            ),
        );
    }

    public function testAllowedInputTypes()
    {
        $this->config->autoFinalize = false;

        $this->config->set('Attr.AllowedInputTypes', null);
        $this->assertPurification(
            '<input><input type="text"><input type="foo">',
            '<input><input type="text"><input>'
        );

        $this->config->set('Attr.AllowedInputTypes', array());
        $this->assertPurification(
            '<input><input type="text"><input type="foo">',
            '<input><input><input>'
        );

        $this->config->set('Attr.AllowedInputTypes', array('password'));
        $this->assertPurification(
            '<input type="text"><input type="password"><input type="foo">',
            '<input><input type="password"><input>'
        );

        $this->config->set('Attr.AllowedInputTypes', array('foo'));
        $this->assertPurification(
            '<input type="text"><input type="password"><input type="foo">',
            '<input><input><input>'
        );
    }
}
