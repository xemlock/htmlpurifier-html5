<?php

/*
 * https://html.spec.whatwg.org/dev/semantics.html#the-link-element
 */
class HTMLPurifier_HTMLModule_HTML5_Link extends HTMLPurifier_HTMLModule
{
    /**
     * @type string
     */
    public $name = 'HTML5_Link';

    /**
     * @type bool
     */
    public $safe = false;

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        if ($config->get('HTML.Link') || $config->get('HTML.SafeLink')) {
            $this->safe = true;
        }

        // https://html.spec.whatwg.org/dev/semantics.html#the-link-element
        $this->addElement('link', 'Flow', 'Empty', null, array(
            'rel*'  => new HTMLPurifier_AttrDef_HTML5_LinkRel(),
            'href*' => new HTMLPurifier_AttrDef_URI(true),
            'type'  => 'Text',
            'crossorigin' => 'Enum#anonymous',
            'integrity' => new HTMLPurifier_AttrDef_HTML5_IntegrityMetadata(),
        ));
        $this->addElementToContentSet('link', 'Inline');
    }
}
