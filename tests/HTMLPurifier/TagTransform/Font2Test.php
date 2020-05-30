<?php

class HTMLPurifier_TagTransform_Font2Test extends BaseTestCase
{
    /**
     * @var HTMLPurifier_Context
     */
    protected $context;

    /**
     * @var HTMLPurifier_TagTransform
     */
    protected $transform;

    protected function setUp()
    {
        parent::setUp();

        $this->context = new HTMLPurifier_Context();
        $this->transform = new HTMLPurifier_TagTransform_Font2();
    }

    public function testTransform()
    {
        $tag = new HTMLPurifier_Token_Start('font', array(
            'color' => '#000',
            'face'  => 'monospace',
            'size'  => '7',
        ));

        $result = $this->transform->transform($tag, $this->config, $this->context);

        $this->assertEquals('span', $result->name);
        $this->assertEquals(array(
            'style' => "color:#000;font-family:monospace;font-size:3rem;",
        ), $result->attr);
    }

    public function testSizePlus()
    {
        $tag = new HTMLPurifier_Token_Start('font', array(
            'color' => '#666',
            'face'  => 'sans-serif',
            'size'  => '+4',
        ));

        $result = $this->transform->transform($tag, $this->config, $this->context);

        $this->assertEquals('span', $result->name);
        $this->assertEquals(array(
            'style' => "color:#666;font-family:sans-serif;font-size:3rem;",
        ), $result->attr);
    }

    public function testSizeMinus()
    {
        $tag = new HTMLPurifier_Token_Start('font', array(
            'color' => '#666',
            'face'  => 'sans-serif',
            'size'  => '-2',
        ));

        $result = $this->transform->transform($tag, $this->config, $this->context);

        $this->assertEquals('span', $result->name);
        $this->assertEquals(array(
            'style' => "color:#666;font-family:sans-serif;font-size:xx-small;",
        ), $result->attr);
    }

    public function testSizeEmpty()
    {
        $tag = new HTMLPurifier_Token_Start('font', array('size' => ''));

        $result = $this->transform->transform($tag, $this->config, $this->context);
        $this->assertEquals('span', $result->name);
        $this->assertEquals(array(), $result->attr);
    }
}
