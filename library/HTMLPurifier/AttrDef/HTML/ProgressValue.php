<?php

class HTMLPurifier_AttrDef_HTML_ProgressValue extends HTMLPurifier_AttrDef_Float
{
    public function __construct()
    {
        parent::__construct(array('min' => 0));
    }

    /**
     * @param string $string
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool
     */
    public function validate($string, $config, $context)
    {
        $node = $context->get('CurrentToken');

        // Value must be greater than or equal to 0.0 and less than or equal
        // to 1.0 or the value of the max attribute (if present)
        $this->max = $node instanceof HTMLPurifier_Token_Tag && isset($node->attr['max'])
            ? $node->attr['max']
            : 1;

        return parent::validate($string, $config, $context);
    }

    /**
     * Factory function
     *
     * @param string $string
     * @return HTMLPurifier_AttrDef_HTML_ProgressValue
     */
    public function make($string)
    {
        // This validator doesn't hold much state besides min=0
        // so there is no need for creating additional instances
        return $this;
    }
}
