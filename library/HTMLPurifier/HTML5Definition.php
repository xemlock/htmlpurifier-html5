<?php

class HTMLPurifier_HTML5Definition
{
    /**
     * Adds HTML5 element and attributes to a provided definition object.
     *
     * @param  HTMLPurifier_HTMLDefinition $def
     * @return HTMLPurifier_HTMLDefinition
     */
    public static function setupDefinition(HTMLPurifier_HTMLDefinition $def)
    {
        // Register 'HTML5' doctype, use 'HTML 4.01 Transitional' as base
        $common = array(
            'CommonAttributes', 'Text', 'Hypertext', 'List',
            'Presentation', 'Edit', 'Bdo', 'Tables', 'Image',
            'StyleAttribute', 'HTML5_Media',
            // Unsafe:
            'HTML5_Scripting', 'HTML5_Interactive', 'Object', 'Forms',
            // Sorta legacy, but present in strict:
            'Name',
        );
        $transitional = array('Legacy', 'Target', 'Iframe');
        $non_xml = array('NonXMLCommonAttributes');

        $def->manager->doctypes->register(
            'HTML5',
            false,
            array_merge($common, $transitional, $non_xml),
            array('Tidy_Transitional', 'Tidy_Proprietary'),
            array()
        );

        // override default SafeScripting module
        // Because how the built-in SafeScripting module is enabled in ModuleManager,
        // to override it exactly the same name must be provided (without HTML5_ prefix)
        $safeScripting = new HTMLPurifier_HTMLModule_HTML5_SafeScripting();
        $safeScripting->name = 'SafeScripting';
        $def->manager->registerModule($safeScripting);

        // use fixed implementation of Boolean attributes, instead of a buggy
        // one provided with 4.6.0
        $def->manager->attrTypes->set('Bool', new HTMLPurifier_AttrDef_HTML_Bool2());

        // add support for Floating point number attributes
        $def->manager->attrTypes->set('Float', new HTMLPurifier_AttrDef_Float());

        // add support for Ruby markup
        $def->manager->addModule('HTML5_Ruby');

        // http://developers.whatwg.org/sections.html
        $def->addElement('section', 'Block', 'Flow', 'Common');
        $def->addElement('nav', 'Block', 'Flow', 'Common');
        $def->addElement('article', 'Block', 'Flow', 'Common');
        $def->addElement('aside', 'Block', 'Flow', 'Common');
        $def->addElement('header', 'Block', 'Flow', 'Common');
        $def->addElement('footer', 'Block', 'Flow', 'Common');
        $def->addElement('main', 'Block', 'Flow', 'Common');

        // Content model actually excludes several tags, not modelled here
        $def->addElement('address', 'Block', 'Flow', 'Common');
        $def->addElement('hgroup', 'Block', 'Required: h1 | h2 | h3 | h4 | h5 | h6', 'Common');

        // https://html.spec.whatwg.org/dev/grouping-content.html#the-figure-element
        $def->addElement('figure', 'Block', new HTMLPurifier_ChildDef_Figure(), 'Common');
        $def->addElement('figcaption', false, 'Flow', 'Common');

        // http://developers.whatwg.org/text-level-semantics.html
        $def->addElement('s', 'Inline', 'Inline', 'Common');
        $def->addElement('var', 'Inline', 'Inline', 'Common');
        $def->addElement('sub', 'Inline', 'Inline', 'Common');
        $def->addElement('sup', 'Inline', 'Inline', 'Common');
        $def->addElement('mark', 'Inline', 'Inline', 'Common');
        $def->addElement('wbr', 'Inline', 'Empty', 'Core');

        // http://developers.whatwg.org/edits.html
        $def->addElement('ins', 'Block', 'Flow', 'Common', array('cite' => 'URI', 'datetime' => 'Text'));
        $def->addElement('del', 'Block', 'Flow', 'Common', array('cite' => 'URI', 'datetime' => 'Text'));

        // TIME
        $time = $def->addElement('time', 'Inline', 'Inline', 'Common', array('datetime' => 'Text', 'pubdate' => 'Bool'));
        $time->excludes = array('time' => true);

        // https://html.spec.whatwg.org/dev/text-level-semantics.html#the-a-element
        $def->addElement('a', 'Flow', 'Flow', 'Common', array(
            'download' => 'Text',
            'hreflang' => 'Text',
            'rel'      => 'Text',
            'target'   => new HTMLPurifier_AttrDef_HTML_FrameTarget(),
            'type'     => 'Text',
        ));

        // IFRAME
        $def->addAttribute('iframe', 'allowfullscreen', 'Bool');

        // https://html.spec.whatwg.org/dev/form-elements.html#the-progress-element
        $progress = $def->addElement('progress', 'Flow', new HTMLPurifier_ChildDef_Progress(), 'Common', array(
            'value' => 'Float#min:0',
            'max'   => 'Float#min:0',
        ));
        $progress->attr_transform_post[] = new HTMLPurifier_AttrTransform_Progress();
        $def->getAnonymousModule()->addElementToContentSet('progress', 'Inline');

        return $def;
    }

    /**
     * @codeCoverageIgnore
     * @deprecated Use {@link setupDefinition()} instead
     * @param  HTMLPurifier_HTMLDefinition $def
     * @return HTMLPurifier_HTMLDefinition
     */
    public static function setup(HTMLPurifier_HTMLDefinition $def)
    {
        return self::setupDefinition($def);
    }
}
