<?php

/*
 * https://html.spec.whatwg.org/dev/semantics.html#the-link-element
 */
class HTMLPurifier_HTMLModule_HTML5_SafeExternalStylesheets extends HTMLPurifier_HTMLModule
{
    /**
     * @type string
     */
    public $name = 'HTML5_SafeExternalStylesheets';

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        $allowed = $config->get('HTML.SafeExternalStylesheet');

        // https://html.spec.whatwg.org/dev/semantics.html#the-link-element
        $this->addElement('link', 'Flow', 'Empty', null, array(
            'rel*'  => new HTMLPurifier_AttrDef_Enum(array('stylesheet')),
            'type'  => new HTMLPurifier_AttrDef_Enum(array('text/css')),
            'href*' => new HTMLPurifier_AttrDef_Enum($allowed, true),
        ));
    }
}
