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
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        // https://html.spec.whatwg.org/dev/semantics.html#the-link-element
        $this->addElement('link', 'Flow', 'Empty', null, array(
            'rel*'  => new HTMLPurifier_AttrDef_HTML_LinkRel,
            'type'  => new HTMLPurifier_AttrDef_Enum(array('text/css')),
            'href*' => new HTMLPurifier_AttrDef_URI(true),
        ));
    }
}
