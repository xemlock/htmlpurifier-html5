<?php

abstract class AttrDefTestCase extends BaseTestCase
{
    /**
     * @var HTMLPurifier_AttrDef
     */
    protected $attr;

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function assertValidate($input, $expected = null)
    {
        $this->assertSame(
            $expected === null ? $input : $expected,
            $this->attr->validate($input, $this->config, $this->context)
        );
    }
}
