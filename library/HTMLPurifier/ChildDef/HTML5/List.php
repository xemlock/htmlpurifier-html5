<?php

/**
 * HTML5 compliant content definition for ul and ol elements.
 *
 * The only difference between this and {@link HTMLPurifier_ChildDef_List}
 * is that HTML5 spec allows empty lists.
 */
class HTMLPurifier_ChildDef_HTML5_List extends HTMLPurifier_ChildDef
{
    public $type = 'list';

    public $elements = array(
        'li' => true,
        'ul' => true,
        'ol' => true,
    );

    /**
     * @param HTMLPurifier_Node[] $children
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return array|bool
     */
    public function validateChildren($children, $config, $context)
    {
        // if li is not allowed, delete parent node
        if (!isset($config->getHTMLDefinition()->info['li'])) {
            trigger_error("Cannot allow ul/ol without allowing li", E_USER_WARNING);
            return false;
        }

        $result = array();
        $li = null;

        foreach ($children as $node) {
            if (!empty($node->is_whitespace)) {
                $result[] = $node;
                continue;
            }
            if ($node->name === 'li') {
                $li = $node;
                $result[] = $node;
            } else {
                // tuck this element into the previous li
                if ($li === null) {
                    $li = new HTMLPurifier_Node_Element('li');
                    $result[] = $li;
                }
                $li->children[] = $node;
                $li->empty = false;
            }
        }

        return $result;
    }
}
