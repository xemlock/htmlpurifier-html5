<?php

abstract class AttrTransformTestCase extends BaseTestCase
{
    /**
     * @var HTMLPurifier_AttrTransform
     */
    protected $transform;

    public function assertResult($input, $expected = null)
    {
        if (func_num_args() < 2) {
            $expected = $input;
        }
        $this->assertEquals($expected, $this->transform->transform($input, $this->config, $this->context));
    }
}
