<?php

/**
 * HTML5 compliant definition for tables.
 *
 * @see https://html.spec.whatwg.org/multipage/tables.html#the-table-element
 */
class HTMLPurifier_HTMLModule_HTML5_Tables extends HTMLPurifier_HTMLModule
{
    /**
     * @type string
     */
    public $name = 'HTML5_Tables';

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        // https://html.spec.whatwg.org/multipage/tables.html#the-caption-element
        $caption = $this->addElement('caption', false, 'Flow', 'Common');
        $caption->excludes = $this->makeLookup('table');

        $this->addElement('table', 'Block', new HTMLPurifier_ChildDef_HTML5_Table(), 'Common');

        $this->addElement('tr', false, 'Required: td | th', 'Common');

        $this->addElement('th', false, 'Flow', 'Common', array(
            'colspan' => 'Number',
            'rowspan' => 'Number',
            // 'headers' => 'IDREFS', // IDREFS not implemented, cannot allow
            'scope' => 'Enum#row,col,rowgroup,colgroup',
            'abbr' => 'Text',
        ));

        $this->addElement('td', false, 'Flow', 'Common', array(
            'colspan' => 'Number',
            'rowspan' => 'Number',
            // 'headers' => 'IDREFS', // IDREFS not implemented, cannot allow
        ));

        $this->addElement('col', false, 'Empty', 'Common', array(
            'span' => 'Number',
        ));

        $this->addElement('colgroup', false, 'Optional: col', 'Common', array(
            'span' => 'Number',
        ));

        $this->addElement('tbody', false, 'Required: tr', 'Common');
        $this->addElement('thead', false, 'Required: tr', 'Common');
        $this->addElement('tfoot', false, 'Required: tr', 'Common');
    }
}
