<?php

class HTMLPurifier_HTMLModule_HTML5_ListTest extends BaseTestCase
{
    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider olInput
     */
    public function testOl($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function olInput()
    {
        return array(
            array(
                '<ol><li>Foo</li></ol>',
            ),
            array(
                '<ol start="2" type="i" reversed><li>Foo</li></ol>',
            ),
        );
    }

    public function testLi()
    {
        $this->assertPurification('<ul><li value="2">Foo</li></ul>');
        $this->assertPurification('<ul><li value="-2">Foo</li></ul>');
    }
}
