<?php

/**
 * HTML5 compliant dl content model
 *
 * @see https://html.spec.whatwg.org/multipage/grouping-content.html#the-dl-element
 */
class HTMLPurifier_ChildDef_HTML5_Dl extends HTMLPurifier_ChildDef
{
    public $type = 'dl';

    public $elements = array(
        'dt'  => true,
        'dd'  => true,
        'div' => true,
    );

    /**
     * @param HTMLPurifier_Node[] $children
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return array|bool|void
     */
    public function validateChildren($children, $config, $context)
    {
        // if dt or dd is not allowed, delete parent node
        if (!isset($config->getHTMLDefinition()->info['dt'])) {
            trigger_error("Cannot allow dl without allowing dt", E_USER_WARNING);
            return false;
        }
        if (!isset($config->getHTMLDefinition()->info['dd'])) {
            trigger_error("Cannot allow dl without allowing dd", E_USER_WARNING);
            return false;
        }

        // Content model:
        // The dl element represents a description list of zero or more term-description
        // groups. Each term-description group consists of one or more terms (represented
        // by dt elements) possibly as children of a div element child, and one or more
        // descriptions (represented by dd elements possibly as children of a div element
        // child), ignoring any nodes other than dt and dd element children, and dt and dd
        // elements that are children of div element children within a single dl element.
        // https://html.spec.whatwg.org/multipage/grouping-content.html#the-dl-element

        // Related discussion: https://github.com/whatwg/html/issues/1937

        // Detect if the first child element is a div, if yes, then all
        // children are expected to be divs
        foreach ($children as $node) {
            if (!empty($node->is_whitespace)) {
                continue;
            }
            if ($node->name === 'div') {
                $result = $this->validateDivChildren($children);
                return $result;
            }
            break;
        }

        return $this->validateDtDdChildren($children);
    }

    /**
     * @param HTMLPurifier_Node[] $children
     * @return HTMLPurifier_Node[]
     */
    protected function validateDivChildren(array $children)
    {
        $result = array();
        foreach ($children as $node) {
            if (!empty($node->is_whitespace)) {
                $result[] = $node;
                continue;
            }
            if ($node->name === 'div') {
                $result[] = $node;
            }
        }
        return $result;
    }

    /**
     * @param HTMLPurifier_Node[] $children
     * @return HTMLPurifier_Node[]
     */
    protected function validateDtDdChildren(array $children)
    {
        $result = array();

        $dt = null;
        $dd = null;

        foreach ($children as $node) {
            if (!empty($node->is_whitespace)) {
                $result[] = $node;
                continue;
            }
            if ($node->name === 'dt') {
                $dt = $node;
                $dd = null;
                $result[] = $node;
            } elseif ($node->name === 'dd') {
                if ($dt === null) {
                    $dt = new HTMLPurifier_Node_Element('dt');
                    $result[] = $dt;
                }
                $dd = $node;
                $result[] = $node;
            }
        }

        // There must be at least one dd after dt
        if ($dt && !$dd) {
            $result[] = new HTMLPurifier_Node_Element('dd');
        }

        return $result;
    }
}
