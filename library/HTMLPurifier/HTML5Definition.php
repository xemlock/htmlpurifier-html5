<?php

class HTMLPurifier_HTML5Definition
{
    /**
     * Adds HTML5 element and attributes to a provided definition object.
     *
     * @param  HTMLPurifier_HTMLDefinition $def
     * @return HTMLPurifier_HTMLDefinition
     */
    public static function setup(HTMLPurifier_HTMLDefinition $def)
    {
        // use fixed implementation of Boolean attributes, instead of a buggy
        // one provided with 4.6.0
        $def->manager->attrTypes->set('Bool', new HTMLPurifier_AttrDef_HTML_Bool2());

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

        $mediaContent = new HTMLPurifier_ChildDef_Media();

        // https://html.spec.whatwg.org/dev/media.html#the-video-element
        $def->addElement('video', 'Flow', $mediaContent, 'Common', array(
            'controls' => 'Bool',
            'height'   => 'Length',
            'poster'   => 'URI',
            'preload'  => 'Enum#auto,metadata,none',
            'src'      => 'URI',
            'width'    => 'Length',
        ));
        $def->getAnonymousModule()->addElementToContentSet('video', 'Inline');

        // https://html.spec.whatwg.org/dev/media.html#the-audio-element
        $def->addElement('audio', 'Flow', $mediaContent, 'Common', array(
            'controls' => 'Bool',
            'preload'  => 'Enum#auto,metadata,none',
            'src'      => 'URI',
        ));
        $def->getAnonymousModule()->addElementToContentSet('audio', 'Inline');

        // https://html.spec.whatwg.org/dev/embedded-content.html#the-source-element
        $def->addElement('source', false, 'Empty', 'Common', array(
            'media'  => 'Text',
            'sizes'  => 'Text',
            'src'    => 'URI',
            'srcset' => 'Text',
            'type'   => 'Text',
        ));

        // https://html.spec.whatwg.org/dev/media.html#the-track-element
        $def->addElement('track', false, 'Empty', 'Common', array(
            'kind'    => 'Enum#captions,chapters,descriptions,metadata,subtitles',
            'src'     => 'URI',
            'srclang' => 'Text',
            'label'   => 'Text',
            'default' => 'Bool',
        ));

        // https://html.spec.whatwg.org/dev/embedded-content.html#the-picture-element
        $def->addElement('picture', 'Flow', new HTMLPurifier_ChildDef_Picture(), 'Common');
        $def->getAnonymousModule()->addElementToContentSet('picture', 'Inline');

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

        // IMG
        $def->addAttribute('img', 'srcset', 'Text');
        $def->addAttribute('img', 'sizes', 'Text');

        // IFRAME
        $def->addAttribute('iframe', 'allowfullscreen', 'Bool');

        // Interactive elements
        // https://html.spec.whatwg.org/dev/interactive-elements.html#the-details-element
        $def->addElement('details', 'Block', new HTMLPurifier_ChildDef_Details(), 'Common', array(
            'open' => 'Bool',
        ));
        $def->addElement('summary', false, 'Flow', 'Common');

        return $def;
    }
}
