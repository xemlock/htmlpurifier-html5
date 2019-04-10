<?php

/**
 * Utility class for HTML5 ChildDef classes
 */
abstract class HTMLPurifier_ChildDef_HTML5 extends HTMLPurifier_ChildDef
{
    /**
     * Helper method for recursive elements removal
     *
     * @param HTMLPurifier_Node[] $children
     * @param string|string[] $elements
     * @return HTMLPurifier_Node[]
     */
    public static function filterOutElements($children, $elements)
    {
        if (!is_array($elements)) {
            $elements = array($elements);
        }
        $result = array();
        foreach ((array) $children as $child) {
            if ($child instanceof HTMLPurifier_Node_Element) {
                $filteredChildren = self::filterOutElements($child->children, $elements);
                if (in_array($child->name, $elements, true)) {
                    // don't add removed element, only its children
                    foreach ($filteredChildren as $c) {
                        $result[] = $c;
                    }
                    continue;
                }
                $child->children = $filteredChildren;
            }
            $result[] = $child;
        }
        return $result;
    }
}
