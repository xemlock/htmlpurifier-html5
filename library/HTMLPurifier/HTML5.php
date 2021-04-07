<?php

/**
 * This class provides easy integration with
 * {@link https://github.com/Exercise/HTMLPurifierBundle Exercise/HTMLPurifierBundle}
 * for Symfony-based apps.
 *
 * Because {@see \Exercise\HTMLPurifierBundle\HTMLPurifierConfigFactory} does not support
 * ustom config classes ({@link https://github.com/Exercise/HTMLPurifierBundle/issues/60 related issue}),
 * the injection of HTML5 config instance must be done inside the Purifier service itself.
 *
 * This class is not intended for direct use or outside Symfony apps, as it adds extra overhead
 * related to config instantiation, required to overcome limitations of the HTMLPurifierBundle.
 *
 * To use HTML5 purifier as a default profile add the following to <code>services.yaml</code>:
 *
 * <pre>
 * services:
 *     exercise_html_purifier.default:
 *         class: HTMLPurifier_HTML5
 *         tags:
 *             - name: exercise.html_purifier
 *               profile: default
 * </pre>
 *
 * To use it as any other profile please consult
 * {@link https://github.com/Exercise/HTMLPurifierBundle/blob/master/README.md HTMLPurifierBundle documentation}.
 */
class HTMLPurifier_HTML5 extends HTMLPurifier
{
    /**
     * {@inheritDoc}
     */
    public function __construct($config = null)
    {
        parent::__construct(HTMLPurifier_HTML5Config::create($config));
    }

    public function purify($html, $config = null)
    {
        $config = $config ? HTMLPurifier_HTML5Config::create($config) : $this->config;
        return parent::purify($html, $config);
    }

    public function purifyArray($array_of_html, $config = null)
    {
        $config = $config ? HTMLPurifier_HTML5Config::create($config) : $this->config;
        return parent::purifyArray($array_of_html, $config);
    }
}
