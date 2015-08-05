<?php

class HTMLPurifier_AttrDef_Regexp extends HTMLPurifier_AttrDef
{
    /**
     * @var string
     */
    protected $pattern;

    /**
     * @param string $pattern
     */
    public function __construct($pattern = null)
    {
        if ($pattern !== null) {
            $pattern = (string) $pattern;
            if (false === @preg_match($pattern, 'Test')) {
                throw new HTMLPurifier_Exception('Invalid regular expression pattern provided');
            }
            $this->pattern = $pattern;
        }
    }

    /**
     * @param string $string
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool
     */
    public function validate($string, $config, $context)
    {
        if ($this->pattern) {
            return (bool) preg_match($this->pattern, $string);
        }
        return false;
    }

    /**
     * @param string $string
     * @return HTMLPurifier_AttrDef_Regexp
     */
    public function make($string)
    {
        return new self($string);
    }
}

// vim: et sw=4 sts=4
