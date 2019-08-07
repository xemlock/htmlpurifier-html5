<?php

class HTMLPurifier_AttrTransform_ProgressTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var HTMLPurifier_HTML5Config
     */
    protected $config;

    /**
     * @var HTMLPurifier_Context
     */
    protected $context;

    /**
     * @var HTMLPurifier_AttrTransform_HTML5_Progress
     */
    protected $progress;

    public function setUp()
    {
        $this->config = HTMLPurifier_HTML5Config::createDefault();
        $this->context = new HTMLPurifier_Context();
        $this->progress = new HTMLPurifier_AttrTransform_HTML5_Progress();
    }

    public function transformInput()
    {
        return array(
            array(
                array(),
                array(),
            ),
            array(
                array('value' => 0),
                array('value' => 0),
            ),
            array(
                array('value' => 1),
                array('value' => 1),
            ),
            array(
                array('value' => 10),
                array('value' => 1),
            ),
            array(
                array('value' => '.1'),
                array('value' => '.1'),
            ),
            array(
                array('value' => -1),
                array(),
            ),
            array(
                array('value' => 10, 'max' => 10),
                array('value' => 10, 'max' => 10),
            ),
            array(
                array('value' => 100, 'max' => 10),
                array('value' => 10, 'max' => 10),
            ),
            array(
                array('max' => 0),
                array(),
            ),
        );
    }

    /**
     * @param array $input
     * @param array $expected
     * @dataProvider transformInput
     */
    public function testTransform($input, $expected)
    {
        $this->assertEquals($expected, $this->progress->transform($input, $this->config, $this->context));
    }
}
