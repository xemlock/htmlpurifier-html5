<?php

/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpUnhandledExceptionInspection */

class HTMLPurifier_ChildDef_HTML5Test extends BaseTestCase
{
    public function testValidateChildrenAllowEmpty()
    {
        $context = new HTMLPurifier_Context();

        $childDef = new HTMLPurifier_ChildDef_HTML5();
        $childDef->type = 'type';
        $childDef->allow_empty = true;

        $this->assertEquals(
            array(),
            $childDef->validateChildren(array(), $this->config, $context)
        );

        $childDef->allow_empty = false;
        $this->assertEquals(
            false,
            $childDef->validateChildren(array(), $this->config, $context)
        );
    }

    /**
     * @expectedException HTMLPurifier_Exception
     * @expectedExceptionMessage property is not initialized
     */
    public function testValidateChildrenNoType()
    {
        $context = new HTMLPurifier_Context();

        $childDef = new HTMLPurifier_ChildDef_HTML5();
        $childDef->validateChildren(array(), $this->config, $context);
    }

    public function testFilterOutElements()
    {
        $children = array(
            self::element('span', array(), array(
                self::text('Foo'),
            )),
            self::text('Bar'),
        );

        $this->assertEquals(
            $children,
            HTMLPurifier_ChildDef_HTML5::filterOutElements($children, array())
        );

        $this->assertEquals(
            array(
                $children[0]->children[0],
                $children[1],
            ),
            HTMLPurifier_ChildDef_HTML5::filterOutElements($children, array('span'))
        );

        $this->assertEquals(
            array(
                $children[0]->children[0],
                $children[1],
            ),
            HTMLPurifier_ChildDef_HTML5::filterOutElements($children, array('span' => true))
        );
    }

    /**
     * @param $name
     * @param array $attrs
     * @param array $children
     * @return HTMLPurifier_Node_Element
     */
    protected static function element($name, array $attrs, array $children)
    {
        $element = new HTMLPurifier_Node_Element($name);
        $element->attr = $attrs;
        $element->children = $children;

        return $element;
    }

    /**
     * @param string $text
     * @return HTMLPurifier_Node_Text
     */
    protected static function text($text)
    {
        return new HTMLPurifier_Node_Text((string) $text, trim($text) === '');
    }
}
