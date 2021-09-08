<?php

class HTMLPurifier_HTMLModule_HTML5_Text_DataTest extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    public function dataProvider()
    {
        return array(
            'data basic' => array(
                '<data value="foo">Foo</data>'
            ),
            'data in p' => array(
                '<p><data value="foo">Foo</data></p>'
            ),
            'data in inline' => array(
                '<span><data value="foo">Foo</data></span>'
            ),
            'data in block' => array(
                '<div><data value="foo">Foo</data></div>'
            ),
            'data in heading' => array(
                '<h1><data value="foo">Foo</data></h1>'
            ),
            'data nested' => array(
                '<data value="foo"><data value="bar">Foo</data></data>'
            ),

            'data can be empty' => array(
                '<data value="foo"></data>',
            ),
            'data can contain interactive' => array(
                '<p><data value="foo"><a>Foo</a></data></p>',
            ),
            'data cannot contain flow' => array(
                '<data value="foo"><ul><li>Foo</li></ul></data>',
                '<data value="foo"></data><ul><li>Foo</li></ul>',
            ),

            'data value is required' => array(
                '<data>Foo</data>',
                '<data value="">Foo</data>',
            ),
        );
    }
}
