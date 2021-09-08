<?php

/**
 * HTML5 compliant module defining text-level, sectioning and grouping elements.
 */
class HTMLPurifier_HTMLModule_HTML5_Text extends HTMLPurifier_HTMLModule
{
    /**
     * @type string
     */
    public $name = 'HTML5_Text';

    public $content_sets = array(
        'Flow' => 'Heading | Block | Inline | Sectioning'
    );

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        // http://developers.whatwg.org/sections.html
        $this->addElement('section', 'Sectioning', 'Flow', 'Common');
        $this->addElement('nav', 'Sectioning', 'Flow', 'Common');
        $this->addElement('article', 'Sectioning', 'Flow', 'Common');
        $this->addElement('aside', 'Sectioning', 'Flow', 'Common');

        // https://html.spec.whatwg.org/dev/sections.html#the-header-element
        $header = $this->addElement('header', 'Block', 'Flow', 'Common');
        $header->excludes = $this->makeLookup('header', 'footer', 'main');

        // https://html.spec.whatwg.org/dev/sections.html#the-footer-element
        $footer = $this->addElement('footer', 'Block', 'Flow', 'Common');
        $footer->excludes = $this->makeLookup('header', 'footer', 'main');

        // https://html.spec.whatwg.org/dev/sections.html#the-address-element
        $address = $this->addElement('address', 'Block', 'Flow', 'Common');
        $address->excludes = $this->makeLookup(
            // no heading content
            // https://html.spec.whatwg.org/dev/dom.html#heading-content
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hgroup',
            // no sectioning content
            // https://html.spec.whatwg.org/dev/dom.html#sectioning-content
            'article', 'aside', 'nav', 'section',
            // no header, footer and address
            'address', 'footer', 'header'
        );

        // https://html.spec.whatwg.org/dev/sections.html#the-hgroup-element
        $this->addElement('hgroup', 'Heading', 'Required: h1 | h2 | h3 | h4 | h5 | h6', 'Common');

        $this->addElement('h1', 'Heading', 'Inline', 'Common');
        $this->addElement('h2', 'Heading', 'Inline', 'Common');
        $this->addElement('h3', 'Heading', 'Inline', 'Common');
        $this->addElement('h4', 'Heading', 'Inline', 'Common');
        $this->addElement('h5', 'Heading', 'Inline', 'Common');
        $this->addElement('h6', 'Heading', 'Inline', 'Common');

        // https://html.spec.whatwg.org/dev/grouping-content.html#the-p-element
        $p = $this->addElement('p', 'Block', 'Inline', 'Common');
        $p->autoclose = array_flip(
            array('address', 'blockquote', 'center', 'dir', 'div', 'dl', 'fieldset', 'ol', 'p', 'ul')
        );

        // https://html.spec.whatwg.org/dev/grouping-content.html#the-pre-element
        // Content model: phrasing content
        $pre = $this->addElement('pre', 'Block', 'Inline', 'Common');
        $pre->excludes = $this->makeLookup(
            'object',
            'applet'
        );

        // https://html.spec.whatwg.org/dev/grouping-content.html#the-div-element
        $this->addElement('div', 'Block', new HTMLPurifier_ChildDef_HTML5_Div(), 'Common');

        // https://html.spec.whatwg.org/dev/grouping-content.html#the-main-element
        $this->addElement('main', 'Block', 'Flow', 'Common');

        // https://html.spec.whatwg.org/dev/grouping-content.html#the-figure-element
        $this->addElement('figure', 'Block', new HTMLPurifier_ChildDef_HTML5_Figure(), 'Common');
        $this->addElement('figcaption', false, 'Flow', 'Common');

        // https://html.spec.whatwg.org/dev/grouping-content.html#the-blockquote-element
        $this->addElement('blockquote', 'Block', 'Flow', 'Common', array(
            'cite' => 'URI',
        ));

        // https://html.spec.whatwg.org/dev/grouping-content.html#the-hr-element
        $this->addElement('hr', 'Block', 'Empty', 'Common');

        // http://developers.whatwg.org/text-level-semantics.html
        // Don't set formatting to true - because the "Active Formatting Elements" algorithm
        // (during MakeWellFormed step) may mess up the markup. See:
        // https://github.com/ezyang/htmlpurifier/issues/258
        $this->addElement('b', 'Inline', 'Inline', 'Common');
        $this->addElement('i', 'Inline', 'Inline', 'Common');
        $this->addElement('u', 'Inline', 'Inline', 'Common');
        $this->addElement('s', 'Inline', 'Inline', 'Common');

        $this->addElement('em', 'Inline', 'Inline', 'Common');
        $this->addElement('small', 'Inline', 'Inline', 'Common');
        $this->addElement('strong', 'Inline', 'Inline', 'Common');
        $this->addElement('code', 'Inline', 'Inline', 'Common');

        $this->addElement('var', 'Inline', 'Inline', 'Common');
        $this->addElement('sub', 'Inline', 'Inline', 'Common');
        $this->addElement('sup', 'Inline', 'Inline', 'Common');
        $this->addElement('mark', 'Inline', 'Inline', 'Common');
        $this->addElement('wbr', 'Inline', 'Empty', 'Common');

        $this->addElement('abbr', 'Inline', 'Inline', 'Common');
        $this->addElement('cite', 'Inline', 'Inline', 'Common');
        $this->addElement('dfn', 'Inline', 'Inline', 'Common');
        $this->addElement('kbd', 'Inline', 'Inline', 'Common');
        $this->addElement('q', 'Inline', 'Inline', 'Common', array('cite' => 'URI'));
        $this->addElement('samp', 'Inline', 'Inline', 'Common');

        // https://html.spec.whatwg.org/dev/text-level-semantics.html#the-span-element
        $this->addElement('span', 'Inline', 'Inline', 'Common');

        // https://html.spec.whatwg.org/dev/text-level-semantics.html#the-br-element
        $this->addElement('br', 'Inline', 'Empty', 'Common');

        // https://html.spec.whatwg.org/dev/text-level-semantics.html#the-time-element
        // https://w3c.github.io/html-reference/datatypes.html#common.data.time-datetime-def
        // Composite attr def is sufficiently general to be used in non-CSS contexts
        $timeDatetime = new HTMLPurifier_AttrDef_CSS_Composite(array(
            new HTMLPurifier_AttrDef_HTML5_Datetime(),
            new HTMLPurifier_AttrDef_HTML5_YearlessDate(),
            new HTMLPurifier_AttrDef_HTML5_Week(),
            new HTMLPurifier_AttrDef_HTML5_Duration(),
        ));
        $timeContents = new HTMLPurifier_ChildDef_HTML5_Time();
        $this->addElement('time', 'Inline', $timeContents, 'Common', array(
            'datetime' => $timeDatetime,
        ));

        // https://html.spec.whatwg.org/multipage/text-level-semantics.html#the-data-element
        $data = $this->addElement('data', 'Inline', 'Inline', 'Common', array(
            'value' => 'Text',
        ));
        $data->attr_transform_post[] = new HTMLPurifier_AttrTransform_HTML5_Data();

        $this->info_injector[] = new HTMLPurifier_Injector_HTML5_DlDiv();
    }
}
