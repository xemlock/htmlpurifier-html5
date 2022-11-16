<?php

class HTMLPurifier_HTMLModule_HTML5_CommonAttributes extends HTMLPurifier_HTMLModule
{
    /**
     * @type string
     */
    public $name = 'HTML5_CommonAttributes';

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        $this->attr_collections = array(
            'Core' => array(
                0 => array('Style'),
                'class' => 'Class',
                'id'    => 'ID',
                'title' => 'CDATA',
                // tabindex attribute is supported on all elements (global attributes)
                // Built-in 'Number' type can't be used here, as it only allows positive integers.
                // Any integer is a valid tabindex value, also negative values are not dangerous
                // per se, although their presence may affect a11y.
                'tabindex' => new HTMLPurifier_AttrDef_Integer(),
                // Final spec for inputmode global attribute has been published on 15 Dec 2017
                // https://web.archive.org/web/20171215142138/https://html.spec.whatwg.org/#input-modalities:-the-inputmode-attribute
                // The 'none' value has been intentionally omitted from the list of
                // allowed values, as it effectively makes the element non-editable,
                // unless there is a script implementing a custom virtual keyboard.
                // It is worth noting that https://validator.nu/ is no longer up to
                // date with the WHATWG HTML5 spec (as of Aug 2020), and doesn't
                // recognize inputmode as a global attribute.
                'inputmode' => 'Enum#text,decimal,numeric,tel,search,email,url',
                'contenteditable' => new HTMLPurifier_AttrDef_HTML5_ContentEditable(),
            ),
            'Lang' => array(
                'lang' => 'LanguageCode',
                // Inherited from the XHTML specifications and deprecated,
                // but kept for compatibility purposes
                'xml:lang' => 'LanguageCode',
            ),
            'I18N' => array(
                0 => array('Lang'),
            ),
            'Common' => array(
                0 => array('Core', 'I18N'),
            ),
        );

        $this->info_attr_transform_post[] = new HTMLPurifier_AttrTransform_HTML5_Lang();
    }
}
