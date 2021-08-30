<?php

/**
 * Shared validation logic for 'rel' attribute on <a>, <area>, <form> and <link> elements,
 * as defined by the HTML5 spec and the MicroFormats link type extensions tables.
 *
 * @see https://html.spec.whatwg.org/multipage/links.html#linkTypes
 */
abstract class HTMLPurifier_AttrDef_HTML5_Rel extends HTMLPurifier_AttrDef
{
    /**
     * Lookup table for valid rel values.
     * Stored as a static variable to minimize serialization footprint.
     * @var array
     */
    protected static $values = array();

    /**
     * Lazy loaded lookup for allowed rel values, based on provided config.
     * @var array
     */
    protected $allowed;

    /**
     * @param string $string
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool|string
     */
    public function validate($string, $config, $context)
    {
        if ($this->allowed === null) {
            $allowedRel = (array) $config->get('Attr.AllowedRel');
            if (empty($allowedRel)) {
                $allowed = array();
            } else {
                $allowed = array_intersect_key($allowedRel, static::$values);
            }
            $this->allowed = $allowed;
        }

        $string = $this->parseCDATA($string);
        $parts = explode(' ', $string);

        $result = array();
        foreach ($parts as $part) {
            // Link type keywords are always ASCII case-insensitive, and must be compared as such.
            // https://html.spec.whatwg.org/multipage/links.html#linkTypes
            $part = strtolower(trim($part));
            if (!isset($this->allowed[$part])) {
                continue;
            }
            $result[$part] = true;
        }

        if (empty($result)) {
            return false;
        }

        return implode(' ', array_keys($result));
    }
}
