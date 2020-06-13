<?php

/**
 * Legacy module defines elements that were obsoleted / deprecated in HTML5
 * but are still supported by browsers.
 *
 * This module requires Tidy module to be enabled to avoid invalid HTML5 output.
 * It provides definitions for obsolete attributes and elements that have fixes
 * defined in Tidy_HTML5 module.
 */
class HTMLPurifier_HTMLModule_HTML5_Legacy extends HTMLPurifier_HTMLModule
{
    /**
     * @type string
     */
    public $name = 'HTML5_Legacy';

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        // Setup additional obsolete / deprecated elements
        $this->addElement('center', 'Block', 'Flow', 'Common');

        $this->addElement('dir', 'Block', 'Required: li', 'Common');

        $this->addElement('font', 'Inline', 'Inline', 'Common', array(
            'color' => 'Color',
            'face'  => new HTMLPurifier_AttrDef_CSS_FontFamily(),
            'size'  => new HTMLPurifier_AttrDef_HTML_FontSize(),
        ));

        $this->addElement('menu', 'Block', 'Required: li', 'Common');

        // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/strike
        $this->addElement('strike', 'Inline', 'Inline', 'Common');

        // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/big
        $this->addElement('big', 'Inline', 'Inline', 'Common');

        // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/tt
        $this->addElement('tt', 'Inline', 'Inline', 'Common');

        // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/acronym
        $this->addElement('acronym', 'Inline', 'Inline', 'Common');

        // Setup modifications to old elements

        $align = 'Enum#left,right,center,justify';

        $br = $this->addBlankElement('br');
        $br->attr['clear'] = 'Enum#all,left,right,none';

        $caption = $this->addBlankElement('caption');
        $caption->attr['align'] = 'Enum#top,bottom,left,right';

        $div = $this->addBlankElement('div');
        $div->attr['align'] = $align;

        for ($i = 1; $i <= 6; $i++) {
            $h = $this->addBlankElement("h$i");
            $h->attr['align'] = $align;
        }

        $hr = $this->addBlankElement('hr');
        $hr->attr['align'] = $align;
        $hr->attr['noshade'] = 'Bool#noshade';
        $hr->attr['size'] = 'Pixels';
        $hr->attr['width'] = 'Length';

        $img = $this->addBlankElement('img');
        $img->attr['align'] = 'IAlign';
        $img->attr['border'] = 'Pixels';
        $img->attr['hspace'] = 'Pixels';
        $img->attr['vspace'] = 'Pixels';

        $li = $this->addBlankElement('li');
        $li->attr['value'] = new HTMLPurifier_AttrDef_Integer();
        $li->attr['type'] = 'Enum#s:1,i,I,a,A,circle,disc,square';

        $p = $this->addBlankElement('p');
        $p->attr['align'] = $align;

        $pre = $this->addBlankElement('pre');
        $pre->attr['width'] = 'Number';

        $table = $this->addBlankElement('table');
        $table->attr['align'] = 'Enum#left,center,right';
        $table->attr['bgcolor'] = 'Color';
        $table->attr['height'] = 'Length';

        $tr = $this->addBlankElement('tr');
        $tr->attr['bgcolor'] = 'Color';

        $th = $this->addBlankElement('th');
        $th->attr['bgcolor'] = 'Color';
        $th->attr['height'] = 'Length';
        $th->attr['nowrap'] = 'Bool#nowrap';
        $th->attr['width'] = 'Length';

        $td = $this->addBlankElement('td');
        $td->attr['bgcolor'] = 'Color';
        $td->attr['height'] = 'Length';
        $td->attr['nowrap'] = 'Bool#nowrap';
        $td->attr['width'] = 'Length';

        $ul = $this->addBlankElement('ul');
        $ul->attr['type'] = 'Enum#circle,disc,square';

        // Setup modifications to "unsafe" elements

        $iframe = $this->addBlankElement('iframe');
        $iframe->attr['frameborder'] = 'Enum#0,1';

        $input = $this->addBlankElement('input');
        $input->attr['align'] = 'IAlign';

        $legend = $this->addBlankElement('legend');
        $legend->attr['align'] = 'LAlign';
    }
}
