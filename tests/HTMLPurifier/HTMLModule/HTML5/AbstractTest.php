<?php

abstract class HTMLPurifier_HTMLModule_HTML5_AbstractTest extends BaseTestCase
{
    /**
     * @dataProvider dataProvider
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testDataProvider($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    abstract function dataProvider();
}
