<?php

class HTMLPurifier_ChildDef_Details extends HTMLPurifier_ChildDef
{
    public $type = 'details';

    public $elements = array(
        'summary' => true,
    );

    protected $allowedElements;

    /**
     * @param HTMLPurifier_Config $config
     * @return array
     */
    public function getAllowedElements($config)
    {
        if (null === $this->allowedElements) {
            // Add Flow content to allowed elements to prevent MakeWellFormed
            // strategy moving them outside details element
            $def = $config->getHTMLDefinition();

            $this->allowedElements = array_merge(
                $def->info_content_sets['Flow'],
                $this->elements
            );
        }
        return $this->allowedElements;
    }

    /**
     * @param array $children
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return array
     */
    public function validateChildren($children, $config, $context)
    {
        if (empty($children)) {
            return false;
        }

        if (!isset($config->getHTMLDefinition()->info['summary'])) {
            trigger_error("Cannot allow details without allowing summary", E_USER_WARNING);
            return false;
        }

        $summary = null;
        $result = array();

        // Content model:
        // One summary element followed by flow content
        foreach ($children as $node) {
            if (!$summary && $node->name === 'summary') {
                $summary = $node;
                continue;
            }
            if ($node->name === 'summary') {
                // duplicated summary, add only its children
                $result = array_merge($result, (array) $node->children);
            } else {
                $result[] = $node;
            }
        }

        $whitespaceOnly = true;
        foreach ($result as $node) {
            $whitespaceOnly = $whitespaceOnly && !empty($node->is_whitespace);
        }

        if (!$summary) {
            // remove parent node if there are no children or all children are whitespace-only
            if ($whitespaceOnly) {
                return false;
            }
            $summary = new HTMLPurifier_Node_Element('summary');
        }

        array_unshift($result, $summary);

        return $result;
    }
}
