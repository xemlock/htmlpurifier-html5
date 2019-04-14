<?php

/**
 * HTML5 extension to Edit Module
 * http://developers.whatwg.org/edits.html
 *
 * @property HTMLPurifier_ElementDef[] $info
 */
class HTMLPurifier_HTMLModule_HTML5_Edit extends HTMLPurifier_HTMLModule_Edit
{
    /**
     * @type string
     */
    public $name = 'HTML5_Edit';

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        parent::setup($config);

        // https://html.spec.whatwg.org/dev/edits.html#the-ins-element
        $this->info['ins']->attr['datetime'] = 'Text';

        // https://html.spec.whatwg.org/dev/edits.html#the-del-element
        $this->info['del']->attr['datetime'] = 'Text';
    }
}
