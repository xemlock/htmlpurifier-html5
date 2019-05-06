<?php

abstract class AttrDefTestCase extends BaseTestCase
{
    /**
     * @var HTMLPurifier_Context
     */
    protected $context;

    /**
     * @var HTMLPurifier_AttrDef
     */
    protected $attr;

    protected function setUp()
    {
        parent::setUp();

        $this->context = new HTMLPurifier_Context();
    }

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
