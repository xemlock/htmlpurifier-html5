<?php

/**
 * Post-transform performing validations for <progress> elements ensuring
 * that if value is present, it is within a valid range (0..1) or (0..max)
 */
class HTMLPurifier_AttrTransform_Progress extends HTMLPurifier_AttrTransform
{
    /**
     * @param array $attr
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return array
     */
    public function transform($attr, $config, $context)
    {
        if (isset($attr['value'])) {
            $max = isset($attr['max']) ? (float) $attr['max'] : 1;
            $value = (float) $attr['value'];

            if ($value < 0 || $value > $max) {
                $this->confiscateAttr($attr, 'value');
            }
        }

        return $attr;
    }
}
