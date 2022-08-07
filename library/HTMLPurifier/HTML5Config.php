<?php

class HTMLPurifier_HTML5Config extends HTMLPurifier_Config
{
    const REVISION = 2022080702;

    /**
     * @param  string|array|HTMLPurifier_Config $config
     * @param  HTMLPurifier_ConfigSchema $schema OPTIONAL
     * @return HTMLPurifier_HTML5Config
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
        $configObj->set('HTML.DefinitionID', __CLASS__);
        $configObj->set('HTML.DefinitionRev', self::REVISION);

        $configObj->set('URI.DefinitionID', __CLASS__);
        $configObj->set('URI.DefinitionRev', self::REVISION);

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
     * @return HTMLPurifier_HTML5Config
     */
    public static function createDefault()
    {
        return self::create(null);
    }

    /**
     * Creates a new config object that inherits from a previous one
     *
     * @param  HTMLPurifier_Config $config
     * @return HTMLPurifier_HTML5Config
     */
    public static function inherit(HTMLPurifier_Config $config)
    {
        return new self($config->def, $config->plist);
    }

    /**
     * @param HTMLPurifier_ConfigSchema $schema
     * @param HTMLPurifier_PropertyList $parent OPTIONAL
     */
    public function __construct(HTMLPurifier_ConfigSchema $schema, HTMLPurifier_PropertyList $parent = null)
    {
        // ensure 'HTML5' is among allowed 'HTML.Doctype' values
        $doctypeConfig = $schema->info['HTML.Doctype'];

        if (empty($doctypeConfig->allowed['HTML5'])) {
            $allowed = array_merge($doctypeConfig->allowed, array('HTML5' => true));
            $schema->addAllowedValues('HTML.Doctype', $allowed);
        }

        if (empty($schema->info['HTML.IframeAllowFullscreen'])) {
            $schema->add('HTML.IframeAllowFullscreen', false, 'bool', false);
        }

        if (empty($schema->info['HTML.Forms'])) {
            $schema->add('HTML.Forms', false, 'bool', false);
        }

        if (empty($schema->info['HTML.Link'])) {
            $schema->add('HTML.Link', false, 'bool', false);
        }

        if (empty($schema->info['HTML.SafeLink'])) {
            $schema->add('HTML.SafeLink', false, 'bool', false);
        }

        if (empty($schema->info['URI.SafeLinkRegexp'])) {
            $schema->add('URI.SafeLinkRegexp', null, 'string', true);
        }

        if (empty($schema->info['Attr.AllowedInputTypes'])) {
            $schema->add('Attr.AllowedInputTypes', null, 'lookup', true);
        }

        // HTMLPurifier doesn't define %CSS.DefinitionID, but it's required for
        // customizing CSS definition object (in the future)
        if (empty($schema->info['CSS.DefinitionID'])) {
            $schema->add('CSS.DefinitionID', null, 'string', true);
        }

        parent::__construct($schema, $parent);

        // Set up defaults for AutoFormat.RemoveEmpty.Predicate to properly handle
        // empty video and audio elements.
        if (!$this->plist->has('AutoFormat.RemoveEmpty.Predicate')) {
            $this->set('AutoFormat.RemoveEmpty.Predicate', array_merge(
                $schema->defaults['AutoFormat.RemoveEmpty.Predicate'],
                array(
                    'video' => array(),
                    'audio' => array(),
                )
            ));
        }

        $this->set('HTML.Doctype', 'HTML5');
        $this->set('HTML.XHTML', false);
        $this->set('Attr.ID.HTML5', true);
        $this->set('Output.CommentScriptContents', false);
    }

    public function getDefinition($type, $raw = false, $optimized = false)
    {
        // Setting HTML.* keys removes any previously instantiated HTML
        // definition object, so set up HTML5 definition as late as possible
        if ($type === 'HTML' && empty($this->definitions[$type])) {
            if ($def = parent::getDefinition($type, true, true)) {
                /** @var HTMLPurifier_HTMLDefinition $def */
                HTMLPurifier_HTML5Definition::setupHTMLDefinition($def, $this);
            }
        }

        if ($type === 'URI' && empty($this->definitions[$type])) {
            if ($def = parent::getDefinition($type, true, true)) {
                /** @var HTMLPurifier_URIDefinition $def */
                HTMLPurifier_HTML5URIDefinition::setupDefinition($def, $this);
            }
        }

        return parent::getDefinition($type, $raw, $optimized);
    }

    public function set($key, $value, $a = null)
    {
        // Special case for HTML5 lexer, so that it can be specified as a string,
        // just like the other lexers ('DOMLex', 'DirectLex' and 'PH5P')
        if ($key === 'Core.LexerImpl' && $value === 'HTML5') {
            $value = new HTMLPurifier_Lexer_HTML5();
        }
        parent::set($key, $value, $a);
    }
}
