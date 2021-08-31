<?php

/**
 * Validates 'rel' attribute on <form> elements, as defined by the HTML5 spec.
 *
 * @see https://html.spec.whatwg.org/multipage/links.html#linkTypes
 */
class HTMLPurifier_AttrDef_HTML5_FormRel extends HTMLPurifier_AttrDef_HTML5_Rel
{
    protected static $values = array(
        'external' => true,
        'help' => true,
        'license' => true,
        'next' => true,
        'nofollow' => true,
        'noopener' => true,
        'noreferrer' => true,
        'opener' => true,
        'prev' => true,
        'search' => true,
    );
}
