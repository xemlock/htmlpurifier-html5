<?php

/**
 * Performs miscellaneous cross attribute validation and filtering for
 * HTML5 input elements. This is meant to be a post-transform.
 */
class HTMLPurifier_AttrTransform_HTML5_Input extends HTMLPurifier_AttrTransform
{
    /**
     * Allowed attributes vs input type lookup
     * @var array
     */
    protected static $attributes = array(
        'accept' => array(
            'file' => true,
        ),
        'alt' => array(
            'image' => true,
        ),
        'checked' => array(
            'checkbox' => true,
            'radio' => true,
        ),
        'maxlength' => array(
            'password' => true,
            'text' => true,
        ),
        'readonly' => array(
            'password' => true,
            'text' => true,
        ),
        'required' => array(
            'checkbox' => true,
            'file' => true,
            'password' => true,
            'radio' => true,
            'text' => true,
        ),
        'size' => array(
            'password' => true,
            'text' => true,
        ),
        'src' => array(
            'image' => true,
        ),
        'value' => array(
            'button' => true,
            'checkbox' => true,
            'hidden' => true,
            'password' => true,
            'radio' => true,
            'reset' => true,
            'submit' => true,
            'text' => true,
        ),
    );

    /**
     * Lookup for input types allowed in current configuration
     * @var array
     */
    protected $allowedInputTypes;

    protected $allowedInputTypesFromConfig;

    /**
     * @var HTMLPurifier_AttrDef_HTML5_InputType
     */
    protected $inputType;

    public function __construct()
    {
        $this->inputType = new HTMLPurifier_AttrDef_HTML5_InputType();
    }

    protected function setupAllowedInputTypes(HTMLPurifier_Config $config)
    {
        $allowedInputTypesFromConfig = isset($config->def->info['Attr.AllowedInputTypes'])
            ? $config->get('Attr.AllowedInputTypes')
            : null;

        // Check if current allowedInputTypes value is based on the latest value from config.
        if ($this->allowedInputTypes !== null && $this->allowedInputTypesFromConfig === $allowedInputTypesFromConfig) {
            return;
        }

        if (is_array($allowedInputTypesFromConfig)) {
            $allowedInputTypes = array_intersect_key(
                $allowedInputTypesFromConfig,
                HTMLPurifier_AttrDef_HTML5_InputType::values()
            );
        } else {
            $allowedInputTypes = HTMLPurifier_AttrDef_HTML5_InputType::values();
        }

        $this->allowedInputTypes = $allowedInputTypes;
        $this->allowedInputTypesFromConfig = $allowedInputTypesFromConfig;
    }

    /**
     * @param array $attr
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return array|bool
     */
    public function transform($attr, $config, $context)
    {
        if (isset($attr['type'])) {
            $t = $this->inputType->validate($attr['type'], $config, $context);
        } else {
            $t = 'text';
        }

        // If an unrecognized input type is provided, use 'text' value instead
        // and remove the 'type' attribute
        if ($t === false) {
            unset($attr['type']);
            $t = 'text';
        }

        // If type doesn't pass %Attr.AllowedInputTypes validation, remove the element
        // from the output
        $this->setupAllowedInputTypes($config);
        if (!isset($this->allowedInputTypes[$t])) {
            return false;
        }

        // Remove attributes not allowed for detected input type
        foreach (self::$attributes as $a => $types) {
            if (array_key_exists($a, $attr) && !isset($types[$t])) {
                unset($attr[$a]);
            }
        }

        // Non-empty 'alt' attribute is required for 'image' input
        if ($t === 'image' && !isset($attr['alt'])) {
            $alt = trim($config->get('Attr.DefaultImageAlt'));
            if ($alt === '') {
                $name = isset($attr['name']) ? trim($attr['name']) : '';
                $alt = $name !== '' ? $name : 'image';
            }
            $attr['alt'] = $alt;
        }

        // The value attribute is always optional, though should be considered
        // mandatory for checkbox, radio, and hidden.
        // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input#attr-value
        // Nu Validator diverges from the WHATWG spec, as it defines 'value'
        // attribute as required, where in fact it is optional, and may be an empty string:
        // https://html.spec.whatwg.org/multipage/input.html#button-state-(type=button)
        if (!isset($attr['value']) && ($t === 'checkbox' || $t === 'radio' || $t === 'hidden')) {
            $attr['value'] = '';
        }

        return $attr;
    }
}
