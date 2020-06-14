<?php

/**
 * Validates a URI as defined by RFC 3986, additionally ensuring it is absolute.
 * Validation logic was taken from {@link HTMLPurifier_AttrDef_URI::validate()}.
 */
class HTMLPurifier_AttrDef_HTML5_AbsoluteURI extends HTMLPurifier_AttrDef
{
    /**
     * @var HTMLPurifier_URIParser
     */
    protected $parser;

    /**
     * @var HTMLPurifier_URIFilter_MakeAbsolute
     */
    protected $filter;

    /**
     * @var string
     */
    protected $base;

    /**
     * @type bool
     */
    protected $embedsResource;

    /**
     * @param bool $embeds_resource Does the URI result in an extra HTTP request?
     */
    public function __construct($embeds_resource = false)
    {
        $this->parser = new HTMLPurifier_URIParser();
        $this->embedsResource = (bool) $embeds_resource;
    }

    /**
     * @param string $string
     * @return HTMLPurifier_AttrDef_HTML5_AbsoluteURI
     */
    public function make($string)
    {
        $embeds = ($string === 'embedded');
        return new self($embeds);
    }

    /**
     * @param string $uri
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool|string
     * @throws HTMLPurifier_Exception
     */
    public function validate($uri, $config, $context)
    {
        if ($config->get('URI.Disable')) {
            return false;
        }

        $uri = $this->parseCDATA($uri);

        // parse the URI
        $uri = $this->parser->parse($uri);
        if ($uri === false) {
            return false;
        }

        $uri = $this->validateURI($uri, $config, $context);
        if ($uri === false) {
            return false;
        }

        if (empty($uri->scheme) && !$this->makeAbsolute($uri, $config, $context)) {
            return false;
        }

        return $uri->toString();
    }

    /**
     * @param HTMLPurifier_URI $uri
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool|HTMLPurifier_URI
     * @throws HTMLPurifier_Exception
     */
    protected function validateURI(HTMLPurifier_URI $uri, HTMLPurifier_Config $config, HTMLPurifier_Context $context)
    {
        // add embedded flag to context for validators
        $context->register('EmbeddedURI', $this->embedsResource);

        $ok = false;
        do {
            // generic validation
            $result = $uri->validate($config, $context);
            if (!$result) {
                break;
            }

            // chained filtering
            $uri_def = $config->getDefinition('URI');
            $result = $uri_def->filter($uri, $config, $context);
            if (!$result) {
                break;
            }

            // scheme-specific validation
            $scheme_obj = $uri->getSchemeObj($config, $context);
            if (!$scheme_obj) {
                break;
            }
            if ($this->embedsResource && !$scheme_obj->browsable) {
                break;
            }
            $result = $scheme_obj->validate($uri, $config, $context);
            if (!$result) {
                break;
            }

            // Post chained filtering
            $result = $uri_def->postFilter($uri, $config, $context);
            if (!$result) {
                break;
            }

            $ok = true;

        } while (false);

        $context->destroy('EmbeddedURI');
        if (!$ok) {
            return false;
        }

        return $uri;
    }

    /**
     * @param HTMLPurifier_URI $uri
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool
     */
    protected function makeAbsolute(HTMLPurifier_URI $uri, HTMLPurifier_Config $config, HTMLPurifier_Context $context)
    {
        if (!$this->filter) {
            $this->filter = new HTMLPurifier_URIFilter_MakeAbsolute();
        }

        $base = $config->get('URI.Base');
        if ($this->base !== $base) {
            if (!$this->filter->prepare($config)) {
                return false;
            }
            $this->base = $base;
        }

        if ($this->filter->filter($uri, $config, $context) && $uri->scheme) {
            return true;
        }

        return false;
    }
}
