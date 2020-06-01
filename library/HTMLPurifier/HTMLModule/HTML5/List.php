<?php

/**
 * HTML5 compliant list module
 *
 * Differences between this module and {@link HTMLPurifier_HTMLModule_List}:
 * - defines additional attributes for ol and li
 * - allows empty ul, ol and dl
 * - allows divs as direct children of dl
 * - allows flow content in dt
 *
 * @see https://html.spec.whatwg.org/multipage/grouping-content.html
 */
class HTMLPurifier_HTMLModule_HTML5_List extends HTMLPurifier_HTMLModule
{
    /**
     * @type string
     */
    public $name = 'HTML5_List';

    /**
     * @type array
     */
    public $content_sets = array(
        'Flow' => 'List',
    );

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        // https://html.spec.whatwg.org/multipage/grouping-content.html#the-ol-element
        $ol = $this->addElement('ol', 'List', new HTMLPurifier_ChildDef_HTML5_List(), 'Common', array(
            'reversed' => 'Bool#reversed',
            // Attributes that were deprecated in HTML4, but reintroduced in HTML5
            'start' => new HTMLPurifier_AttrDef_Integer(),
            'type'  => 'Enum#s:1,a,A,i,I',
        ));

        $ul = $this->addElement('ul', 'List', new HTMLPurifier_ChildDef_HTML5_List(), 'Common');

        // The wrap attribute is handled by MakeWellFormed strategy, and is present
        // in order for auto-closing to work properly.
        $ol->wrap = 'li';
        $ul->wrap = 'li';

        $this->addElement('li', false, 'Flow', 'Common', array(
            'value' => new HTMLPurifier_AttrDef_Integer(),
        ));

        $this->addElement('dl', 'List', new HTMLPurifier_ChildDef_HTML5_Dl(), 'Common');

        // https://html.spec.whatwg.org/multipage/grouping-content.html#the-dl-element
        // Content model:
        // Flow content, but with no header, footer, sectioning content, or heading content descendants.
        $dt = $this->addElement('dt', false, 'Flow', 'Common');
        $dt->excludes = $this->makeLookup(
            'header', 'footer',
            // sectioning content
            'article', 'aside', 'nav', 'section',
            // heading content
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hgroup'
        );

        $this->addElement('dd', false, 'Flow', 'Common');
    }
}
