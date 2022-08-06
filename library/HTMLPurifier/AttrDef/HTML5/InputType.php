<?php

class HTMLPurifier_AttrDef_HTML5_InputType extends HTMLPurifier_AttrDef
{
    /**
     * Lookup table for valid values
     * @var array
     * @see https://www.w3.org/TR/xhtml-modularization/abstract_modules.html#s_extformsmodule
     */
    protected static $values = array(
        'button' => true,
        'checkbox' => true,
        'file' => true,
        'hidden' => true,
        'image' => true,
        'password' => true,
        'radio' => true,
        'reset' => true,
        'submit' => true,
        'text' => true,
    );

    /**
     * @return array
     */
    public static function values()
    {
        return self::$values;
    }

    /**
     * @param string $string
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool|string
     */
    public function validate($string, $config, $context)
    {
        $value = strtolower($this->parseCDATA($string));

        if (!isset(self::$values[$value])) {
            return false;
        }

        return $value;
    }
}
