<?php

class HTMLPurifier_AttrDef_HTML_LinkHref extends HTMLPurifier_AttrDef_Enum
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

        $result = parent::validate($string, $config, $context);
        if ($result !== false) {
            return $result;
        }

        $regexp = $config->get('URI.SafeLinkRegexp');
        if ($regexp && preg_match($regexp, $string)) {
            return true;
        }

        return false;
    }
}
