<?php

class HTMLPurifier_HTML5URIDefinition
{
    public static function setupDefinition(HTMLPurifier_URIDefinition $def, HTMLPurifier_Config $config)
    {
        $def->registerFilter(new HTMLPurifier_URIFilter_SafeLink);

        return $def;
    }
}
