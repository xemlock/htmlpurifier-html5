<?php

class HTMLPurifier_ChildDef_Progress extends HTMLPurifier_ChildDef
{
    public $type = 'progress';

    public $elements = array();

    protected $allowedElements;

    public function getAllowedElements($config)
    {
        if (null === $this->allowedElements) {
            $def = $config->getHTMLDefinition();

            // Should be 'Phrasing', but since HTMLPurifier has no built-in support
            // for this category 'Inline' is the closest what we can use
            $this->allowedElements = $def->info_content_sets['Inline'];
        }
        return $this->allowedElements;
    }

    /**
     * @param HTMLPurifier_Node[] $children
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return HTMLPurifier_Node[]
     */
    public function validateChildren($children, $config, $context)
    {
        // Permitted content: Phrasing content, but there must be no
        // <progress> element among its descendants.
        // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/progress
        return $this->removeProgressElements($children);
    }

    /**
     * Helper method for recursive 'progress' element removal.
     *
     * @param HTMLPurifier_Node[] $children
     * @return HTMLPurifier_Node[]
     */
    protected function removeProgressElements($children)
    {
        $result = array();
        foreach ($children as $child) {
            if ($child instanceof HTMLPurifier_Node_Element) {
                $filteredChildren = $this->removeProgressElements($child->children);
                if ($child->name === 'progress') {
                    // don't add <progress> element, only its children
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
