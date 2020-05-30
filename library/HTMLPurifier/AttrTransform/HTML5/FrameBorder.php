<?php

/**
 * Pre-transform that changes deprecated IFRAME frameborder attribute to CSS.
 */
class HTMLPurifier_AttrTransform_HTML5_FrameBorder extends HTMLPurifier_AttrTransform
{
    /**
     * @param array $attr
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return array
     */
    public function transform($attr, $config, $context)
    {
        if (!isset($attr['frameborder'])) {
            return $attr;
        }

        $frameBorder = (int) $this->confiscateAttr($attr, 'frameborder');

        if ($frameBorder === 0) {
            $this->prependCSS($attr, 'border:0;');
        }

        return $attr;
    }
}
