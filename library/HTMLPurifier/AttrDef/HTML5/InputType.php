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
     * Lookup for input types allowed in current configuration
     * @var array
     */
    protected $allowed;

    protected $allowedFromConfig;

    protected function setupAllowed(HTMLPurifier_Config $config)
    {
        $allowedFromConfig = isset($config->def->info['Attr.AllowedInputTypes'])
            ? $config->get('Attr.AllowedInputTypes')
            : null;

        // Check if current allowed value is based on the latest value from config.
        // Comparing with '===' shouldn't be a performance bottleneck, because the
        // value retrieved from the config is never changed after being stored.
        // PHP's copy-on-write mechanism prevents making unnecessary array copies,
        // allowing this particular array comparison to be made in O(1) time, when
        // the corresponding value in config hasn't changed, and in O(n) time after
        // each change.
        if ($this->allowed !== null && $this->allowedFromConfig === $allowedFromConfig) {
            return;
        }

        if (is_array($allowedFromConfig)) {
            $allowed = array_intersect_key($allowedFromConfig, self::$values);
        } else {
            $allowed = self::$values;
        }

        $this->allowed = $allowed;
        $this->allowedFromConfig = $allowedFromConfig;
    }

    /**
     * @param string $string
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool|string
     */
    public function validate($string, $config, $context)
    {
        $this->setupAllowed($config);
        $value = strtolower($this->parseCDATA($string));

        if (!isset(self::$values[$value])) {
            return false;
        }

        if (!isset($this->allowed[$value])) {
            return false;
        }

        return $value;
    }
}
