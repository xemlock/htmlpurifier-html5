<?php

/**
 * Post-transform that copies xml:lang's value to lang
 */
class HTMLPurifier_AttrTransform_HTML5_Lang extends HTMLPurifier_AttrTransform
{
    /**
     * @param array $attr
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return array
     */
    public function transform($attr, $config, $context)
    {
        $lang = isset($attr['lang']) ? $attr['lang'] : false;
        $xml_lang = isset($attr['xml:lang']) ? $attr['xml:lang'] : false;

        // 'xml:lang' may only be specified if a lang attribute in no namespace
        // is also specified, and both attributes must have the same value when
        // compared in an ASCII case-insensitive manner.
        // https://html.spec.whatwg.org/dev/dom.html#attr-xml-lang
        if ($lang === false && $xml_lang !== false) {
            $attr['lang'] = $lang = $xml_lang;
        }

        // If both lang and xml:lang are present, ensure they're in sync,
        // lang having priority over xml:lang
        if ($lang !== false && $xml_lang !== false && $xml_lang !== $lang) {
            $attr['xml:lang'] = $lang;
        }

        // xml:lang will be stripped out unless %HTML.XHTML is true

        return $attr;
    }
}
