<?php

/**
 * HTML5 additions to built-in Forms module
 *
 * This module is marked as safe to support static elements like <progress>
 * out of the box. Only elements inherited from parent module are unsafe,
 * and enabled conditionally with 'HTML.Trusted' config flag.
 */
class HTMLPurifier_HTMLModule_HTML5_Forms extends HTMLPurifier_HTMLModule_Forms
{
    public $name = 'HTML5_Forms';

    public $safe = true;

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        if ($config->get('HTML.Trusted')) {
            parent::setup($config);

            $this->addElement(
                'fieldset',
                'Form',
                new HTMLPurifier_ChildDef_HTML5_Fieldset(),
                'Common',
                array(
                    'name'     => 'CDATA',
                    'disabled' => 'Bool#disabled',
                    // 'form' => 'IDREF', // IDREF not implemented, cannot allow
                )
            );
        }

        // https://html.spec.whatwg.org/dev/form-elements.html#the-progress-element
        $progress = $this->addElement(
            'progress',
            'Flow',
            new HTMLPurifier_ChildDef_HTML5_Progress(),
            'Common',
            array(
                'value' => 'Float#min:0',
                'max'   => 'Float#min:0',
            )
        );
        $this->addElementToContentSet('progress', 'Inline');

        $progress->attr_transform_post[] = new HTMLPurifier_AttrTransform_HTML5_Progress();
    }
}
