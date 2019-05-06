<?php

class HTMLPurifier_ChildDef_HTML5 extends HTMLPurifier_ChildDef
{
    /**
     * Whether element with no children should be accepted
     * @var bool
     */
    public $allow_empty = true;

    /**
     * Lookup table with content sets to be included in allowed elements
     * @var array
     */
    public $content_sets = array();

    /**
     * Lookup table with excluded of excluded descendant tags
     * @var array
     */
    public $excludes = array();

    /**
     * @var array
     */
    protected $allowedElements = array();

    /**
     * @var boolean
     */
    protected $init = false;

    /**
     * @param HTMLPurifier_Config $config
     * @return array
     * @throws HTMLPurifier_Exception
     */
    public function getAllowedElements($config)
    {
        $this->init($config);
        return $this->allowedElements;
    }

    /**
     * @param HTMLPurifier_Node[] $children
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return HTMLPurifier_Node[]|bool
     * @throws HTMLPurifier_Exception
     */
    public function validateChildren($children, $config, $context)
    {
        $this->init($config);

        if ($this->excludes) {
            $children = self::filterOutElements($children, $this->excludes);
        }

        if (empty($children) && !$this->allow_empty) {
            return false;
        }

        return $children;
    }

    /**
     * @param HTMLPurifier_Config $config
     * @throws HTMLPurifier_Exception
     */
    protected function init(HTMLPurifier_Config $config)
    {
        if ($this->init) {
            return;
        }

        // Ensure that the type property is not empty, otherwise the element
        // will be treated as having an Empty content model (closing tag will
        // be omitted) if no children are present.
        if (empty($this->type)) {
            throw new HTMLPurifier_Exception("The 'type' property is not initialized");
        }

        if ($this->content_sets) {
            $def = $config->getHTMLDefinition();

            $this->allowedElements = $this->elements;
            foreach ($this->content_sets as $name) {
                if (isset($def->info_content_sets[$name])) {
                    $this->allowedElements = array_merge($this->allowedElements, $def->info_content_sets[$name]);
                }
            }
        }

        $this->init = true;
    }

    /**
     * Helper method for recursive elements removal
     *
     * @param HTMLPurifier_Node[] $children
     * @param string|string[] $lookup
     * @return HTMLPurifier_Node[]
     */
    public static function filterOutElements($children, $lookup)
    {
        if (!is_array($lookup)) {
            $lookup = array($lookup => true);
        }

        // backward compatibility - ensure provided array is a lookup
        foreach ($lookup as $key => $value) {
            if (!is_string($key)) {
                unset($lookup[$key]);
                $lookup[$value] = true;
            }
        }

        $result = array();
        foreach ((array) $children as $child) {
            if ($child instanceof HTMLPurifier_Node_Element) {
                $filteredChildren = self::filterOutElements($child->children, $lookup);
                if (isset($lookup[$child->name])) {
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
