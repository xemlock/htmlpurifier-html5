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
     * @var HTMLPurifier_AttrTransform_Progress
     */
    protected $progress;

    public function setUp()
    {
        $this->config = HTMLPurifier_HTML5Config::createDefault();
        $this->context = new HTMLPurifier_Context();
        $this->progress = new HTMLPurifier_AttrTransform_Progress();
    }

    protected function assertTransform($expected, array $input)
    {
        $this->assertEquals($expected, $this->progress->transform($input, $this->config, $this->context));
    }

    public function testTransform()
    {
        $this->assertTransform(array(), array());
        $this->assertTransform(array('value' => 0), array('value' => 0));
        $this->assertTransform(array('value' => 1), array('value' => 1));
        $this->assertTransform(array(), array('value' => 10));
        $this->assertTransform(array(), array('value' => -1));

        $this->assertTransform(array('value' => 10, 'max' => 10), array('value' => 10, 'max' => 10));
        $this->assertTransform(array('max' => 10), array('value' => 100, 'max' => 10));
    }
}
