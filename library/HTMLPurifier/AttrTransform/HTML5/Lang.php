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

        // If lang and xml:lang are both present, ensure that their values are
        // equal. The precedence depends on document mode used, determined by
        // %HTML.XHTML config value: xml:lang has precedence in XHTML mode, and
        // lang in HTML mode.
        // Lang attribute in the XML namespace is not allowed on HTML
        // elements, and non-namespaced attribute with the literal localname
        // 'xml:lang' has no effect on language processing.
        // https://html.spec.whatwg.org/#the-lang-and-xml:lang-attributes
        if ($lang !== false && $xml_lang !== false && $xml_lang !== $lang) {
            if ($config->get('HTML.XHTML')) {
                $attr['lang'] = $xml_lang;
            } else {
                $attr['xml:lang'] = $lang;
            }
        }

        // xml:lang will be stripped out later unless %HTML.XHTML is true

        return $attr;
    }
}
