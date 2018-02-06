<?php

class HTMLPurifier_HTML5Config
{
    /**
     * @param  string|array|HTMLPurifier_Config $config
     * @param  HTMLPurifier_ConfigSchema $schema
     * @return HTMLPurifier_Config
     */
    public static function create($config = null, HTMLPurifier_ConfigSchema $schema = null)
    {
        if (!$schema instanceof HTMLPurifier_ConfigSchema) {
            $schema = HTMLPurifier_ConfigSchema::instance();
        }

        if ($config instanceof HTMLPurifier_Config) {
            $configObj = $config;

        } else {
            $configObj = new HTMLPurifier_Config($schema);
            $configObj->set('Core.Encoding', 'UTF-8');
            $configObj->set('HTML.Doctype', 'HTML 4.01 Transitional');

            if (is_string($config)) {
                $configObj->loadIni($config);

            } elseif (is_array($config)) {
                $configObj->loadArray($config);
            }
        }

        // Prevent auto-finalization of config when retrieving HTML definition
        $autoFinalize = $configObj->autoFinalize;
        $configObj->autoFinalize = false;

        $def = $configObj->getHTMLDefinition(true);
        HTMLPurifier_HTML5Definition::setup($def);

        $configObj->autoFinalize = $autoFinalize;

        return $configObj;
    }

    /**
     * Creates a configuration object using the default config schema instance
     *
     * @return HTMLPurifier_Config
     */
    public static function createDefault()
    {
        $schema = HTMLPurifier_ConfigSchema::instance();
        $config = self::create(null, $schema);
        return $config;
    }
}

// vim: et sw=4 sts=4
