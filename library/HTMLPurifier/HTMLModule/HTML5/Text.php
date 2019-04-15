<?php

/**
 * Extension to {@link HTMLPurifier_HTMLModule_Text} defining HTML5 text-level
 * and grouping elements.
 */
class HTMLPurifier_HTMLModule_HTML5_Text extends HTMLPurifier_HTMLModule_Text
{
    /**
     * @type string
     */
    public $name = 'HTML5_Text';

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        parent::setup($config);

        // http://developers.whatwg.org/sections.html
        $this->addElement('section', 'Block', 'Flow', 'Common');
        $this->addElement('nav', 'Block', 'Flow', 'Common');
        $this->addElement('article', 'Block', 'Flow', 'Common');
        $this->addElement('aside', 'Block', 'Flow', 'Common');
        $this->addElement('header', 'Block', 'Flow', 'Common');
        $this->addElement('footer', 'Block', 'Flow', 'Common');
        $this->addElement('main', 'Block', 'Flow', 'Common');

        // Content model actually excludes several tags, not modelled here
        $this->addElement('address', 'Block', 'Flow', 'Common');
        $this->addElement('hgroup', 'Block', 'Required: h1 | h2 | h3 | h4 | h5 | h6', 'Common');

        // https://html.spec.whatwg.org/dev/grouping-content.html#the-figure-element
        $this->addElement('figure', 'Block', new HTMLPurifier_ChildDef_HTML5_Figure(), 'Common');
        $this->addElement('figcaption', false, 'Flow', 'Common');

        // http://developers.whatwg.org/text-level-semantics.html
        $this->addElement('s', 'Inline', 'Inline', 'Common');
        $this->addElement('var', 'Inline', 'Inline', 'Common');
        $this->addElement('sub', 'Inline', 'Inline', 'Common');
        $this->addElement('sup', 'Inline', 'Inline', 'Common');
        $this->addElement('mark', 'Inline', 'Inline', 'Common');
        $this->addElement('wbr', 'Inline', 'Empty', 'Core');

        // https://html.spec.whatwg.org/dev/text-level-semantics.html#the-time-element
        $time = $this->addElement('time', 'Inline', 'Inline', 'Common', array(
            'datetime' => 'Text',
            'pubdate'  => 'Bool',
        ));
        $time->excludes = array('time' => true);
    }
}
