<?php

/**
 * Validates key-label list type according to HTML5 spec:
 * An ordered set of unique space-separated tokens, each of which must be exactly one Unicode code point in length.
 *
 * Values of this type are used exclusively for 'accesskey' global attribute.
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/accesskey
 * @see https://html.spec.whatwg.org/multipage/interaction.html#the-accesskey-attribute
 * @see https://www.w3.org/TR/2012/WD-html-markup-20121025/datatypes.html#common.data.keylabellist
 * @see https://github.com/validator/validator/blob/v20.3.16/src/nu/validator/datatype/KeyLabelList.java
 */
class HTMLPurifier_AttrDef_HTML5_KeyLabelList extends HTMLPurifier_AttrDef
{
    /**
     * @param string $string
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return string|false
     */
    public function validate($string, $config, $context)
    {
        // Attribute value must be an ordered set of unique space-separated tokens
        // none of which are identical to another token and each of which must be
        // exactly one code point in length.
        $keys = array();

        foreach (preg_split('/\s+/', $string) as $token) {
            // Split token into UTF-8 characters.
            // All strings are internally converted to UTF-8 by HTMLPurifier_Encoder
            // prior to any processing, so we expect the input to be UTF-8 encoded as well.
            preg_match_all('/(*UTF8)./u', $token, $match);
            if (isset($match[0]) && count($match[0]) === 1) {
                $keys[$match[0][0]] = true;
            }
        }

        if (empty($keys)) {
            return false;
        }

        return implode(' ', array_keys($keys));
    }
}
