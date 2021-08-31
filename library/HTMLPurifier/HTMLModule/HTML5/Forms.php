<?php

/**
 * HTML5 additions to built-in Forms module
 */
class HTMLPurifier_HTMLModule_HTML5_Forms extends HTMLPurifier_HTMLModule_Forms
{
    public $name = 'HTML5_Forms';

    public $safe = false;

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        if (isset($config->def->info['HTML.Forms']) && $config->get('HTML.Forms')) {
            $this->safe = true;
        }

        parent::setup($config);

        // legend element is declared in HTML5_SafeForms module
        unset($this->info['legend']);
        if (($pos = array_search('legend', $this->elements, true)) !== false) {
            array_splice($this->elements, $pos, 1);
        }

        // https://html.spec.whatwg.org/multipage/forms.html#the-form-element
        $form = $this->addElement(
            'form',
            'Form',
            'Flow',
            'Common',
            array(
                'accept-charset' => 'Charsets',
                'action'  => 'URI',
                'method'  => 'Enum#get,post',
                'enctype' => 'Enum#application/x-www-form-urlencoded,multipart/form-data,text/plain',
                'target'  => new HTMLPurifier_AttrDef_HTML_FrameTarget(),
                'rel'     => new HTMLPurifier_AttrDef_HTML5_FormRel(),
            )
        );
        $form->excludes = array('form' => true);
    }
}
