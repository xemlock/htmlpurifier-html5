<?php

class HTMLPurifier_AttrTransform_HTML5_Script extends HTMLPurifier_AttrTransform
{
    /**
     * @param array $attr
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return array
     */
    public function transform($attr, $config, $context)
    {
        // If 'src' is specified, it must be a valid non-empty URL potentially
        // surrounded by spaces.
        // If 'src' is present, regardless it's empty or not, script text is
        // ignored by browsers.
        if (isset($attr['src']) && trim($attr['src']) === '') {
            unset($attr['src']);
        }

        // https://html.spec.whatwg.org/multipage/scripting.html#the-script-element
        if (empty($attr['src'])) {
            // The charset attribute must not be specified if the src attribute is not present
            // https://web.archive.org/web/20171005001148/https://html.spec.whatwg.org/multipage/scripting.html#the-script-element
            unset($attr['charset']);

            // The integrity attribute must not be specified when the src attribute is not specified.
            unset($attr['integrity']);
        }

        return $attr;
    }
}
