<?php

/**
 * Validates 'rel' attribute on <link> elements, as defined by the HTML5 spec.
 *
 * Keywords that are body-ok affect whether link elements are allowed in the body.
 * @see https://html.spec.whatwg.org/multipage/links.html#body-ok
 * @see https://html.spec.whatwg.org/multipage/links.html#linkTypes
 */
class HTMLPurifier_AttrDef_HTML5_LinkRel extends HTMLPurifier_AttrDef_HTML5_Rel
{
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
}
