<?php

/*
 * Keywords that are body-ok affect whether link elements are allowed in the body.
 * The body-ok keywords are dns-prefetch, modulepreload, pingback, preconnect, prefetch, preload, prerender,
 * and stylesheet.
 *
 * https://html.spec.whatwg.org/multipage/links.html#body-ok
 *
 * @note We cannot use Enum because multiple values are allowed.
 */
class HTMLPurifier_AttrDef_HTML_LinkRel extends HTMLPurifier_AttrDef_HTML_Rel
{
    /**
     * Lookup table for valid values
     * @var array
     */
    protected static $values = array(
        'dns-prefetch' => true,
        'modulepreload' => true,
        'pingback' => true,
        'preconnect' => true,
        'prefetch' => true,
        'preload' => true,
        'prerender' => true,
        'stylesheet' => true,
    );

    /**
     * @param string $string
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool|string
     */
    public function validate($string, $config, $context)
    {
        return $this->validateAttribute($string, $config);
    }
}
