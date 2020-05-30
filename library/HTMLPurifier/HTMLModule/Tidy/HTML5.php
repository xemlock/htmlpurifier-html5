<?php

class HTMLPurifier_HTMLModule_Tidy_HTML5 extends HTMLPurifier_HTMLModule_Tidy_XHTMLAndHTML4
{
    public $name = 'Tidy_HTML5';

    /**
     * This is the lenient level. If a tag or attribute is about to be removed
     * because it isn't supported by the doctype, Tidy will step in and change
     * into an alternative that is supported.
     * @var string
     */
    public $defaultLevel = 'light';

    /**
     * @return array
     */
    public function makeFixes()
    {
        $fixes = parent::makeFixes();

        // Remove transforms for valid HTML5 elements
        unset(
            $fixes['u'],
            $fixes['s'],
            $fixes['ol@type']
        );

        $fixes['font'] = new HTMLPurifier_TagTransform_Font2();
        $fixes['strike'] = new HTMLPurifier_TagTransform_Simple('s');

        $fixes['iframe@frameborder'] = new HTMLPurifier_AttrTransform_HTML5_FrameBorder();

        return $fixes;
    }
}
