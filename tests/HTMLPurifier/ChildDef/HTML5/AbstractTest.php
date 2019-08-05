<?php

/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpUnhandledExceptionInspection */

class HTMLPurifier_ChildDef_HTML5_AbstractTest extends BaseTestCase
{
    public function testGetAllowedElements()
    {
        $elementContents = new HTMLPurifier_ChildDef_HTML5_AbstractTest_Element('element');
        $elementContents->elements = array(
            'div' => true,
            'Inline',
        );

        $this->assertEquals(
            array_merge(
                array('div'),
                array_keys($this->config->getHTMLDefinition()->info_content_sets['Inline'])
            ),
            array_keys($elementContents->getAllowedElements($this->config))
        );

        $this->assertSame(
            $elementContents->getAllowedElements($this->config),
            $elementContents->getAllowedElements($this->config)
        );
    }

    /**
     * @expectedException HTMLPurifier_Exception
     * @expectedExceptionMessage property is not initialized
     */
    public function testEmptyType()
    {
        new HTMLPurifier_ChildDef_HTML5_AbstractTest_Element();
    }
}

class HTMLPurifier_ChildDef_HTML5_AbstractTest_Element extends HTMLPurifier_ChildDef_HTML5_Abstract
{
    public function validateChildren($children, $config, $context)
    {
        return $children;
    }
}
