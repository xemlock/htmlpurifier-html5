<?php

/**
 * Validates 'size' attribute of deprecated FONT tag
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/font#attr-size
 */
class HTMLPurifier_AttrDef_HTML_FontSize extends HTMLPurifier_AttrDef_CSS_Number
{
    /**
     * @param string $string
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool|string
     */
    public function validate($string, $config, $context)
    {
        $string = trim($string);

        switch (substr($string, 0, 1)) {
            case '+':
                $sign = 1;
                break;

            case '-':
                $sign = -1;
                break;

            default:
                $sign = 0;
                break;
        }

        if ($sign) {
            $string = substr($string, 1);
        }

        if (($string = parent::validate($string, $config, $context)) === false) {
            return false;
        }

        // Browsers truncate float 'size' values to integers, so we do the same
        $value = (int) $string;

        // Size values range from 1 to 7 with 1 being the smallest and 3 the
        // default. It can be defined using a relative value, like +2 or -3,
        // which set it relative to the default value.
        // This means that the relative values are between -2 and +4 (inclusive).

        if ($sign) {
            $value = max(-2, min(4, $sign * $value));
            $value = $value >= 0 ? '+' . $value : $value;
        } else {
            $value = max(1, min(7, $value));
        }

        return (string) $value;
    }
}
