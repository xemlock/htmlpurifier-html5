<?php

/**
 * HTML5 compliant div content model
 *
 * In HTML5 divs can be nested directly under dl elements. When they are,
 * they are expected to have dt and dd children.
 */
class HTMLPurifier_ChildDef_HTML5_Div extends HTMLPurifier_ChildDef_Optional
{
    public $type = 'div';

    public $allow_empty = true;

    public $elements = array(
        '#PCDATA' => true,
        'Flow'    => true,
        'dt'      => true,
        'dd'      => true,
    );

    protected $init = false;

    public function __construct()
    {
        parent::__construct($this->elements);
    }

    /**
     * @param HTMLPurifier_Config $config
     * @return array
     */
    public function getAllowedElements($config)
    {
        $this->init($config);
        return $this->elements;
    }

    protected function init(HTMLPurifier_Config $config)
    {
        if ($this->init) {
            return;
        }
        $def = $config->getHTMLDefinition();
        $elements = array();
        foreach ($this->elements as $name => $_) {
            if (isset($def->info_content_sets[$name])) {
                $elements = array_merge($elements, $def->info_content_sets[$name]);
            } else {
                $elements[$name] = true;
            }
        }
        $this->elements = $elements;
        $this->init = true;
    }

    /**
     * @param HTMLPurifier_Node[] $children
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return array|bool
     */
    public function validateChildren($children, $config, $context)
    {
        $this->init($config);

        $currentNode = $context->get('CurrentNode', true);
        if (empty($currentNode->attr['DlDiv'])) {
            return $this->validateDivChildren($children, $config, $context);
        }

        return $this->validateDlDivChildren($children);
    }

    /**
     * @param HTMLPurifier_Node[] $children
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return array|bool
     */
    protected function validateDivChildren(array $children, HTMLPurifier_Config $config, HTMLPurifier_Context $context)
    {
        // Filter out dt and dd, but try to retain their contents (if any),
        // just as MakeWellFormed strategy would do to unrecognized elements
        $result = array();
        foreach ($children as $child) {
            if (isset($child->name) && ($child->name === 'dt' || $child->name === 'dd')) {
                foreach ($child->children as $c) {
                    $result[] = $c;
                }
            } else {
                $result[] = $child;
            }
        }
        return parent::validateChildren($result, $config, $context);
    }

    /**
     * @param HTMLPurifier_Node[] $children
     * @return array|bool
     */
    protected function validateDlDivChildren(array $children)
    {
        // div in dl is required to have (dt+, dd+) content
        // https://html.spec.whatwg.org/multipage/grouping-content.html#the-dl-element
        // Related discussion: https://github.com/whatwg/html/issues/1937

        $dt = null;
        $dd = null;
        $result = array();

        foreach ($children as $child) {
            if (!empty($child->is_whitespace)) {
                $result[] = $child;
                continue;
            }
            if ($child->name === 'dt' && !$dd) {
                $dt = $child;
                $result[] = $child;
            } elseif ($child->name === 'dd') {
                $dd = $child;
                $result[] = $dd;
            }
        }

        if (!$dd && !$dt) {
            return false;
        }

        if (!$dt) {
            array_unshift($result, new HTMLPurifier_Node_Element('dt'));
        }

        if (!$dd) {
            $result[] = new HTMLPurifier_Node_Element('dd');
        }

        return $result;
    }
}
