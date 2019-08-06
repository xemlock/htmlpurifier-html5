<?php

class HTMLPurifier_HTML5Definition
{
    /**
     * Adds HTML5 element and attributes to a provided definition object.
     *
     * @param  HTMLPurifier_HTMLDefinition $def
     * @return HTMLPurifier_HTMLDefinition
     * @throws HTMLPurifier_Exception
     */
    public static function setupDefinition(HTMLPurifier_HTMLDefinition $def)
    {
        // Register 'HTML5' doctype, use 'HTML 4.01 Transitional' as base
        $common = array(
            'CommonAttributes', 'HTML5_Text', 'HTML5_Hypertext', 'List',
            'Presentation', 'HTML5_Edit', 'HTML5_Bdo', 'Tables', 'Image',
            'StyleAttribute', 'HTML5_Media', 'HTML5_Ruby',
            // Unsafe:
            'HTML5_Scripting', 'HTML5_Interactive', 'Object', 'HTML5_Forms',
            // Sorta legacy, but present in strict:
            'Name',
        );
        $transitional = array('Legacy', 'Target', 'HTML5_Iframe');
        $non_xml = array('NonXMLCommonAttributes');

        $def->manager->doctypes->register(
            'HTML5',
            false,
            // Order of modules is important - the latter ones override the former.
            // Place common HTML5 modules at the end of the list
            array_merge($non_xml, $transitional, $common),
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

        $def->manager->attrTypes->set('Datetime', new HTMLPurifier_AttrDef_HTML5_Datetime());

        return $def;
    }
}
