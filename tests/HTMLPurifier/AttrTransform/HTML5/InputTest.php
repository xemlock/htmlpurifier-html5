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

    public function testImageAlt()
    {
        $this->assertResult(array(
            'type' => 'image',
            'alt' => 'foo',
        ));
        $this->assertResult(array(
            'type' => 'image',
        ), array(
            'type' => 'image',
            'alt' => 'image',
        ));
    }
}
