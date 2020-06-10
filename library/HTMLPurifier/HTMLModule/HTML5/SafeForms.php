<?php


/**
 * Safe HTML5 form elements
 */
class HTMLPurifier_HTMLModule_HTML5_SafeForms extends HTMLPurifier_HTMLModule
{
    public $name = 'HTML5_SafeForms';

    public $safe = true;

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        $this->addElement(
            'fieldset',
            'Form',
            new HTMLPurifier_ChildDef_HTML5_Fieldset(),
            'Common',
            array(
                'name' => 'CDATA',
                'disabled' => 'Bool#disabled',
                // 'form' => 'IDREF', // IDREF not implemented, potentially unsafe, cannot allow
            )
        );

        // https://html.spec.whatwg.org/dev/form-elements.html#the-legend-element
        // Content model: Phrasing content, optionally intermixed with heading content.
        $this->addElement(
            'legend',
            false,
            'Optional: #PCDATA | Inline | Heading',
            'Common',
            array(
                'accesskey' => 'Character',
            )
        );

        // https://html.spec.whatwg.org/dev/form-elements.html#the-progress-element
        $progress = $this->addElement(
            'progress',
            'Flow',
            'Inline',
            'Common',
            array(
                'value' => 'Float#min:0',
                'max' => 'Float#min:0',
            )
        );
        $progress->excludes = array('progress' => true);
        $this->addElementToContentSet('progress', 'Inline');

        $progress->attr_transform_post[] = new HTMLPurifier_AttrTransform_HTML5_Progress();
    }
}
