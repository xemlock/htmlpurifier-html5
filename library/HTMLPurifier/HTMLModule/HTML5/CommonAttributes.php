<?php

class HTMLPurifier_HTMLModule_HTML5_CommonAttributes extends HTMLPurifier_HTMLModule
{
    /**
     * @type string
     */
    public $name = 'HTML5_CommonAttributes';

    /**
     * @type array
     */
    public $attr_collections = array(
        'Core' => array(
            0 => array('Style'),
            'class' => 'Class',
            'id'    => 'ID',
            'title' => 'CDATA',
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
        )
    );

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        $this->info_attr_transform_post[] = new HTMLPurifier_AttrTransform_HTML5_Lang();
    }
}
