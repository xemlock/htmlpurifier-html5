<?php

/**
 * HTML5 compliant replacement for {@link HTMLPurifier_HTMLModule_Hypertext},
 * defining block-level hypertext links.
 */
class HTMLPurifier_HTMLModule_HTML5_Hypertext extends HTMLPurifier_HTMLModule
{
    /**
     * @type string
     */
    public $name = 'HTML5_Hypertext';

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        $aContents = new HTMLPurifier_ChildDef_HTML5();
        $aContents->excludes = array('a' => true);
        $aContents->content_sets = array('Flow');

        // https://html.spec.whatwg.org/dev/text-level-semantics.html#the-a-element
        $this->addElement('a', 'Flow', $aContents, 'Common', array(
            'download' => 'Text',
            'href'     => 'URI',
            'hreflang' => 'Text', // 'LanguageCode',
            'rel'      => new HTMLPurifier_AttrDef_HTML5_ARel(),
            'target'   => new HTMLPurifier_AttrDef_HTML_FrameTarget(),
            'type'     => 'Text',
        ));
        $this->addElementToContentSet('a', 'Inline');
    }
}
