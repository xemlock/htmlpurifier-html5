<?php

/**
 * HTML5 Interactive elements module
 * https://html.spec.whatwg.org/dev/interactive-elements.html
 */
class HTMLPurifier_HTMLModule_HTML5_Interactive extends HTMLPurifier_HTMLModule
{
    /**
     * @type string
     */
    public $name = 'HTML5_Interactive';

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        // https://html.spec.whatwg.org/dev/interactive-elements.html#the-details-element
        // Content model: One summary element followed by flow content.
        $this->addElement('details', 'Flow', new HTMLPurifier_ChildDef_HTML5_Details(), 'Common', array(
            'open' => 'Bool#open',
        ));

        // https://html.spec.whatwg.org/dev/interactive-elements.html#the-summary-element
        // Content model: Phrasing content, optionally intermixed with heading content.
        // This is where WHATWG spec differs from the W3C spec, because the latter allows
        // either phrasing content, or a single heading element, see:
        // https://www.w3.org/TR/html51/interactive-elements.html#the-summary-element
        $this->addElement('summary', false, 'Optional: #PCDATA | Inline | Heading', 'Common');

        // https://html.spec.whatwg.org/dev/interactive-elements.html#the-dialog-element
        // Content model: Flow content.
        $dialog = $this->addElement('dialog', 'Flow', 'Flow', 'Common', array(
            'open' => 'Bool#open',
        ));

        $dialog->attr_transform_pre[] = new HTMLPurifier_AttrTransform_HTML5_Dialog();
    }
}
