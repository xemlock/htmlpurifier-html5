<?php

class HTMLPurifier_ChildDef_HTML5_Progress extends HTMLPurifier_ChildDef
{
    public $type = 'progress';

    public $elements = array();

    protected $allowedElements;

    /**
     * @param HTMLPurifier_Config $config
     * @return array
     */
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
        return HTMLPurifier_ChildDef_HTML5::filterOutElements($children, 'progress');
    }
}
