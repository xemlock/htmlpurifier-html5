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
class HTMLPurifier_AttrDef_HTML5_LinkRel extends HTMLPurifier_AttrDef_HTML5_ARel
{
    /**
     * Lookup table for valid values
     * @var array
     */
    protected static $values = array(
        'stylesheet' => true,
    );
}
