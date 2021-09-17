<?php

/**
 * Test cases based on https://github.com/ezyang/htmlpurifier/blob/master/tests/HTMLPurifier/ChildDef/TableTest.php
 */
class HTMLPurifier_ChildDef_HTML5_TableTest extends ChildDefTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->childDef = new HTMLPurifier_ChildDef_HTML5_Table();
    }

    public function testEmptyInput()
    {
        $this->assertResult('');
    }

    public function testSingleRow()
    {
        $this->assertResult('<tr />');
    }

    public function testComplexContents()
    {
        $this->assertResult('<caption /><col /><thead /><tfoot /><tbody><tr><td>asdf</td></tr></tbody>');
        $this->assertResult('<col /><col /><col /><tr />');
    }

    public function testReorderContents()
    {
        $this->assertResult(
            '<col /><colgroup /><tbody /><tfoot /><thead /><tr>1</tr><caption /><tr />',
            '<caption /><col /><colgroup /><thead /><tfoot /><tbody /><tbody><tr>1</tr><tr /></tbody>'
        );
    }

    public function testWrapWithTbody()
    {
        $this->assertResult(
            '<thead><tr><th>a</th></tr></thead><tr><td>a</td></tr>',
            '<thead><tr><th>a</th></tr></thead><tbody><tr><td>a</td></tr></tbody>'
        );
    }

    public function testTheadOnlyNotRemoved()
    {
        $this->assertResult(
            '<thead><tr><th>a</th></tr></thead>',
            '<thead><tr><th>a</th></tr></thead>'
        );
    }

    public function testTbodyOnlyNotRemoved()
    {
        $this->assertResult(
            '<tbody><tr><th>a</th></tr></tbody>',
            '<tbody><tr><th>a</th></tr></tbody>'
        );
    }

    public function testTrOverflowAndClose()
    {
        $this->assertResult(
            '<tr><td>a</td></tr><tr><td>b</td></tr><tbody><tr><td>c</td></tr></tbody><tr><td>d</td></tr>',
            '<tbody><tr><td>a</td></tr><tr><td>b</td></tr></tbody><tbody><tr><td>c</td></tr></tbody><tbody><tr><td>d</td></tr></tbody>'
        );
    }

    public function testDuplicateProcessing()
    {
        $this->assertResult(
            '<caption>1</caption><caption /><tbody /><tbody /><tfoot>1</tfoot><tfoot />',
            '<caption>1</caption><tfoot>1</tfoot><tbody /><tbody /><tbody />'
        );
    }

    public function testRemoveText()
    {
        $this->assertResult('foo', '');
    }

    public function testStickyWhitespaceOnTr()
    {
        $this->config->set('Output.Newline', "\n");
        $this->assertResult("\n   <tr />\n  <tr />\n ");
    }

    public function testStickyWhitespaceOnTSection()
    {
        $this->config->set('Output.Newline', "\n");
        $this->assertResult(
            "\n\t<tbody />\n\t\t<tfoot />\n\t\t\t",
            "\n\t<tfoot />\n\t\t\t<tbody />\n\t\t"
        );
    }
}
