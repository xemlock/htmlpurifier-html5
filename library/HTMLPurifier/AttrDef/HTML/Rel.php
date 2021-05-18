<?php

abstract class HTMLPurifier_AttrDef_HTML_Rel extends HTMLPurifier_AttrDef
{
    /**
     * Lookup table for valid values
     * @var array
     */
    protected static $values = array();

    /** @var array<string, bool>|null */
    protected $allowed;

    /**
     * Return lookup table for valid 'rel' values
     *
     * @return array
     * @codeCoverageIgnore
     */
    public static function values()
    {
        return self::$values;
    }

    /**
     * @param string $string
     * @return bool|string
     */
    protected function validateAttribute($string, HTMLPurifier_Config $config)
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
            $part = strtolower(trim($part));
            if (! isset($this->allowed[$part])) {
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
