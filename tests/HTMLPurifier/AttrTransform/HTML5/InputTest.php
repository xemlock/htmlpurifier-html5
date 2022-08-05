<?php

/**
 * @property HTMLPurifier_AttrTransform_Input $transform
 */
class HTMLPurifier_AttrTransform_HTML5_InputTest extends AttrTransformTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->transform = new HTMLPurifier_AttrTransform_HTML5_Input();
    }

    public function testEmptyInput()
    {
        $this->assertResult(array());
    }

    public function testInvalidCheckedWithEmpty()
    {
        $this->assertResult(array('checked' => 'checked'), array());
    }

    public function testInvalidCheckedWithPassword()
    {
        $this->assertResult(array(
            'checked' => 'checked',
            'type' => 'password',
        ), array(
            'type' => 'password',
        ));
    }

    public function testValidCheckedWithUcCheckbox()
    {
        $this->assertResult(array(
            'checked' => 'checked',
            'type' => 'CHECKBOX',
            'value' => 'bar',
        ));
    }

    public function testInvalidMaxlength()
    {
        $this->assertResult(array(
            'maxlength' => '10',
            'type' => 'checkbox',
            'value' => 'foo',
        ), array(
            'type' => 'checkbox',
            'value' => 'foo',
        ));
    }

    public function testValidMaxLength()
    {
        $this->assertResult(array(
            'maxlength' => '10',
        ));
    }

    public function testSizeWithCheckbox()
    {
        $this->assertResult(array(
            'type' => 'checkbox',
            'value' => 'foo',
            'size' => '100',
        ), array(
            'type' => 'checkbox',
            'value' => 'foo',
        ));
    }

    public function testSizeWithPassword()
    {
        $this->assertResult(array(
            'type' => 'password',
            'size' => '100',
        ));
    }

    public function testInvalidSrc()
    {
        $this->assertResult(array(
            'src' => 'img.png',
        ), array());
    }

    public function testMissingValue()
    {
        $this->assertResult(array(
            'type' => 'checkbox',
        ), array(
            'type' => 'checkbox',
            'value' => '',
        ));
    }

    public function testTextInputTypeNotAllowed()
    {
        $this->config->set('Attr.AllowedInputTypes', array('password'));

        $this->assertResult(array('type' => 'text'), false);
        $this->assertResult(array('type' => 'password'));
    }

    public function testNullAllowedInputTypes()
    {
        $this->config->set('Attr.AllowedInputTypes', null);

        $this->assertResult(array('type' => 'text'));
        $this->assertResult(array('type' => 'password'));
    }

    public function testEmptyAllowedInputTypes()
    {
        $this->config->set('Attr.AllowedInputTypes', array());

        $this->assertResult(array('type' => 'text'), false);
        $this->assertResult(array('type' => 'password'), false);
    }

    public function testInvalidAllowedInputTypes()
    {
        $this->config->set('Attr.AllowedInputTypes', array('foo'));

        // 'foo' type is converted to 'text', and 'text' type is not allowed
        $this->assertResult(array('type' => 'foo'), false);
        $this->assertResult(array('type' => 'text'), false);
        $this->assertResult(array('type' => 'password'), false);
    }

    public function testInvalidOrEmptyInputType()
    {
        $this->assertResult(array('type' => 'foo'), array());
        $this->assertResult(array('type' => ''), array());
        $this->assertResult(array(), array());
    }
}
