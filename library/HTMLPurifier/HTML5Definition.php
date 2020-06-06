<?php

abstract class HTMLPurifier_HTML5Definition
{
    /**
     * Adds HTML5 element and attributes to a provided definition object.
     *
     * @param  HTMLPurifier_HTMLDefinition $def
     * @param  HTMLPurifier_Config $config
     * @return HTMLPurifier_HTMLDefinition
     * @internal
     */
    public static function setupHTMLDefinition(HTMLPurifier_HTMLDefinition $def, HTMLPurifier_Config $config)
    {
        $def->manager->doctypes->register(
            'HTML5',
            false,
            // Order of modules is important - the latter ones override the former.
            // Place common HTML5 modules at the end of the list
            array(
                'CommonAttributes', 'HTML5_Text', 'HTML5_Hypertext', 'HTML5_List',
                'HTML5_Edit', 'HTML5_Bdo', 'Tables', 'Image',
                'StyleAttribute', 'HTML5_Media', 'HTML5_Ruby', 'Name',
                'NonXMLCommonAttributes',
                // Unsafe:
                'HTML5_Scripting', 'HTML5_Interactive', 'Object', 'HTML5_Forms',
                'HTML5_Iframe',
                // Transitional:
                'HTML5_Legacy',
            ),
            array('Tidy_HTML5'),
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
        $def->manager->attrTypes->set('Float', new HTMLPurifier_AttrDef_HTML5_Float());

        $def->manager->attrTypes->set('Datetime', new HTMLPurifier_AttrDef_HTML5_Datetime());

        $def->info_injector[] = new HTMLPurifier_Injector_HTML5_DlDiv();

        return $def;
    }
}
