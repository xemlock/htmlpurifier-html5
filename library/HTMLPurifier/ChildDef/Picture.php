<?php

class HTMLPurifier_ChildDef_Picture extends HTMLPurifier_ChildDef
{
    public $type = 'picture';

    public $elements = array(
        'img'    => true,
        'source' => true,
    );

    /**
     * @param array $children
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return array
     */
    public function validateChildren($children, $config, $context)
    {
        // if there are no tokens, delete parent node
        if (empty($children)) {
            return false;
        }

        if (!isset($config->getHTMLDefinition()->info['img'])) {
            trigger_error("Cannot allow picture without allowing img", E_USER_WARNING);
            return false;
        }

        $allowSource = isset($config->getHTMLDefinition()->info['source']);
        $hasImg = false;

        $result = array();

        // Content model:
        // Zero or more source elements, followed by one img element, optionally intermixed with script-supporting elements.
        // https://html.spec.whatwg.org/multipage/embedded-content.html#the-picture-element
        foreach ($children as $node) {
            if (($allowSource && $node->name === 'source') || $node->name === 'img') {
                $result[] = $node;
            }
            if ($node->name === 'img') {
                $hasImg = true;
                break;
            }
        }

        if (!$hasImg || empty($result)) {
            return false;
        }

        return $result;
    }
}
