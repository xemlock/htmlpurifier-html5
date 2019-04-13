<?php

class HTMLPurifier_HTMLModule_HTML5_InteractiveTest extends BaseTestCase
{
    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider detailsInputProvider
     */
    public function testDetails($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function detailsInputProvider()
    {
        return array(
            array(
                '<details><summary>Foo <strong>Bar</strong></summary>Baz <p>Qux</p></details>',
                '<details><summary>Foo <strong>Bar</strong></summary>Baz <p>Qux</p></details>',
            ),
            array(
                '<details open><summary>Foo</summary>Bar</details>',
                '<details open><summary>Foo</summary>Bar</details>',
            ),
            array(
                '<details>Foo</details>',
                '<details><summary></summary>Foo</details>',
            ),
            array(
                '<details><summary>Foo</summary><summary>Bar</summary></details>',
                '<details><summary>Foo</summary>Bar</details>',
            ),
            array(
                '<details>Foo<summary>Bar</summary>Baz</details>',
                '<details><summary>Bar</summary>FooBaz</details>',
            ),
            array(
                '<details class="foo"><summary>Foo</summary></details>',
            ),
            array(
                '<details></details>',
                '<details><summary></summary></details>',
            ),
            array(
                '<summary>Foo</summary>',
                'Foo',
            ),
        );
    }

    public function testDetailsWithForbiddenSummary()
    {
        $this->config->set('HTML.ForbiddenElements', array('summary'));

        $this->assertPurification('<details><summary>Foo</summary>Bar</summary>', '');
        $this->assertWarning('Cannot allow details without allowing summary');
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider dialogDataProvider
     */
    public function testDialog($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function dialogDataProvider()
    {
        return array(
            array(
                '<dialog></dialog>',
            ),
            array(
                '<dialog open class="foo"></dialog>',
            ),
            array(
                '<dialog><h1>Foo</h1><p>Bar</p></dialog>',
            ),
            array(
                '<dialog tabindex="1"><h1>Foo</h1></dialog>',
                '<dialog><h1>Foo</h1></dialog>',
            ),
        );
    }
}
