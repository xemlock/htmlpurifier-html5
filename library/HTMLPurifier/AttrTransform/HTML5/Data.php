<?php

/**
 * Post-transform ensuring that 'value' attribute exists on <data> element.
 *
 * Declaring 'value' as a required attribute in element definition would cause
 * <data> element to be removed and its content unwrapped, whenever the attribute
 * was missing. By using filter however, the markup is only slightly modified
 * ('value' attr is added), which IMHO is a better approach.
 */
class HTMLPurifier_AttrTransform_HTML5_Data extends HTMLPurifier_AttrTransform
{
    /**
     * @param array $attr
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return array
     */
    public function transform($attr, $config, $context)
    {
        // The value attribute must be specified on data elements.
        // https://html.spec.whatwg.org/multipage/text-level-semantics.html#the-data-element
        $attr['value'] = isset($attr['value']) ? $attr['value'] : '';

        return $attr;
    }
}
