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
            $config->get('HTML.XHTML'),
            // Order of modules is important - the latter ones override the former.
            // Place common HTML5 modules at the end of the list
            array(
                'HTML5_CommonAttributes', 'HTML5_Text', 'HTML5_Hypertext', 'HTML5_List',
                'HTML5_Edit', 'HTML5_Bdo', 'HTML5_Tables', 'Image',
                'StyleAttribute', 'HTML5_Media', 'HTML5_Ruby', 'Name',
                'HTML5_SafeForms',
                // Unsafe:
                'HTML5_Scripting', 'HTML5_Interactive', 'Object', 'HTML5_Forms',
                'HTML5_Iframe', 'HTML5_Link',
                // Transitional:
                'HTML5_Legacy',
            ),
            array('Tidy_HTML5'),
            array()
        );

        // Override default SafeScripting module if HTML5 doctype is used.
        // Because of how the built-in SafeScripting module is enabled in the ModuleManager,
        // in order to override it the same name must be provided (without HTML5_ prefix)
        if (stripos($config->get('HTML.Doctype'), 'HTML5') !== false) {
            $safeScripting = new HTMLPurifier_HTMLModule_HTML5_SafeScripting();
            $safeScripting->name = 'SafeScripting';
            $def->manager->registerModule($safeScripting);
        }

        // Use fixed implementation of Boolean attributes, instead of a buggy
        // one provided with 4.6.0
        $def->manager->attrTypes->set('Bool', new HTMLPurifier_AttrDef_HTML_Bool2());

        // Add missing definition for Integer, required by tabindex
        $def->manager->attrTypes->set('Integer', new HTMLPurifier_AttrDef_Integer());

        // Add support for Floating point number attributes
        $def->manager->attrTypes->set('Float', new HTMLPurifier_AttrDef_HTML5_Float());

        $def->manager->attrTypes->set('Datetime', new HTMLPurifier_AttrDef_HTML5_Datetime());

        return $def;
    }
}
