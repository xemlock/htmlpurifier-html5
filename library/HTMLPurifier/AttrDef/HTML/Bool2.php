<?php

/**
 * Validates a boolean attribute
 *
 * HTMLPurifier 4.6.0 has broken support for boolean attributes, as reported
 * in: http://htmlpurifier.org/phorum/read.php?3,7631,7631

 * This issue has (almost) been fixed in ezyang/htmlpurifier@c67e4c2f7e06f89c,
 * but so far it hasn't been merged into a stable version.
 */
class HTMLPurifier_AttrDef_HTML_Bool2 extends HTMLPurifier_AttrDef_HTML_Bool
{
    /**
     * @param string $string
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool|string
     */
    public function validate($string, $config, $context)
    {
        // boolean attribute validates if its value is either empty
        // or case-insensitively equal to attribute name
        return $string === '' || strcasecmp($this->name, $string) === 0;
    }

    /**
     * @param string $string Name of attribute
     * @return HTMLPurifier_AttrDef_HTML_Bool2
     */
    public function make($string)
    {
        return new self($string);
    }
}

// vim: et sw=4 sts=4
