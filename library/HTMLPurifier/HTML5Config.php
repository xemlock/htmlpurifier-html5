<?php

class HTMLPurifier_HTML5Config extends HTMLPurifier_Config
{
    const REVISION = 2018061701;

    /**
     * @param  string|array|HTMLPurifier_Config $config
     * @param  HTMLPurifier_ConfigSchema $schema
     * @return HTMLPurifier_Config
     */
    public static function create($config, $schema = null)
    {
        if ($config instanceof HTMLPurifier_Config) {
            $schema = $config->def;
            $config = null;
        }

        if (!$schema instanceof HTMLPurifier_ConfigSchema) {
            $schema = HTMLPurifier_ConfigSchema::instance();
        }

        $configObj = new self($schema);
        $configObj->set('Core.Encoding', 'UTF-8');
        $configObj->set('HTML.Doctype', 'HTML 4.01 Transitional');

        $configObj->set('HTML.DefinitionID', __CLASS__);
        $configObj->set('HTML.DefinitionRev', self::REVISION);

        if (is_string($config)) {
            $configObj->loadIni($config);

        } elseif (is_array($config)) {
            $configObj->loadArray($config);
        }

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

    /**
     * Creates a new config object that inherits from a previous one
     *
     * @param  HTMLPurifier_Config $config
     * @return HTMLPurifier_Config
     */
    public static function inherit(HTMLPurifier_Config $config)
    {
        return new self($config->def, $config->plist);
    }

    public function getDefinition($type, $raw = false, $optimized = false)
    {
        // Setting HTML.* keys removes any previously instantiated HTML
        // definition object, so set up HTML5 definition as late as possible
        $needSetup = $type === 'HTML' && !isset($this->definitions[$type]);
        if ($needSetup) {
            if ($def = parent::getDefinition($type, true, true)) {
                HTMLPurifier_HTML5Definition::setup($def);
            }
        }
        return parent::getDefinition($type, $raw, $optimized);
    }
}
