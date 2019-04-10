<?php

class HTMLPurifier_ChildDef_HTML5_Noscript extends HTMLPurifier_ChildDef
{
    public $type = 'noscript';

    protected $allowedElements;

    /**
     * @param HTMLPurifier_Config $config
     * @return array
     */
    public function getAllowedElements($config)
    {
        if ($this->allowedElements === null) {
            $def = $config->getHTMLDefinition();

            // According to spec <noscript> cannot be nested.
            // Match browsers' behavior by autoclosing tag whenever a child
            // <noscript> is encountered.
            $this->allowedElements = $def->info_content_sets['Flow'];
            unset($this->allowedElements['noscript']);
        }
        return $this->allowedElements;
    }

    /**
     * @param HTMLPurifier_Node[] $children
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return HTMLPurifier_Node[]|bool
     */
    public function validateChildren($children, $config, $context)
    {
        // Permitted content: flow content or phrasing content, but
        // no <noscript> element must be among its descendants.
        $children = HTMLPurifier_ChildDef_HTML5::filterOutElements($children, 'noscript');

        // Remove empty <noscript> element
        if (empty($children)) {
            return false;
        }

        return $children;
    }
}
