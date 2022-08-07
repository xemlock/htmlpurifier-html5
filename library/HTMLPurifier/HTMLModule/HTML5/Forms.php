<?php

/**
 * HTML5 additions to built-in Forms module
 */
class HTMLPurifier_HTMLModule_HTML5_Forms extends HTMLPurifier_HTMLModule_Forms
{
    public $name = 'HTML5_Forms';

    public $safe = false;

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setup($config)
    {
        if (isset($config->def->info['HTML.Forms']) && $config->get('HTML.Forms')) {
            $this->safe = true;
        }

        parent::setup($config);

        // legend element is declared in HTML5_SafeForms module
        unset($this->info['legend']);
        if (($pos = array_search('legend', $this->elements, true)) !== false) {
            array_splice($this->elements, $pos, 1);
        }

        // https://html.spec.whatwg.org/multipage/forms.html#the-form-element
        $form = $this->addElement(
            'form',
            'Form',
            'Flow',
            'Common',
            array(
                'accept-charset' => 'Charsets',
                'action'  => 'URI',
                'method'  => 'Enum#get,post',
                'enctype' => 'Enum#application/x-www-form-urlencoded,multipart/form-data,text/plain',
                'target'  => new HTMLPurifier_AttrDef_HTML_FrameTarget(),
                'rel'     => new HTMLPurifier_AttrDef_HTML5_FormRel(),
            )
        );
        $form->excludes = array('form' => true);

        $max = $config->get('HTML.MaxImgLength');
        $input = $this->addElement(
            'input',
            'Formctrl',
            'Empty',
            'Common',
            array(
                'accept' => 'ContentTypes',
                'accesskey' => 'Character',
                'alt' => 'Text',
                'checked' => 'Bool#checked',
                'dirname' => 'Text',
                'disabled' => 'Bool#disabled',
                // 'form' => 'IDREF', // IDREF not implemented, cannot allow
                'height' => 'Pixels#' . $max,
                // 'list' => 'IDREF', // IDREF not implemented, cannot allow
                'max' => 'Text',
                'maxlength' => 'Pixels',
                'min' => 'Text',
                'minlength' => 'Pixels',
                'multiple' => 'Bool#multiple',
                'name' => 'Text',
                'pattern' => 'Text',
                'placeholder' => 'Text',
                'readonly' => 'Bool#readonly',
                'required' => 'Bool#required',
                'size' => 'Pixels',
                'src' => 'URI#embedded',
                'step' => new HTMLPurifier_AttrDef_CSS_Composite(array(
                    new HTMLPurifier_AttrDef_HTML5_Float(array('min' => 0, 'minInclusive' => false)),
                    new HTMLPurifier_AttrDef_Enum(array('any')),
                )),
                'type' => new HTMLPurifier_AttrDef_HTML5_InputType(),
                'value' => 'Text',
                'width' => 'Pixels#' . $max,
            )
        );
        $input->attr_transform_post[] = new HTMLPurifier_AttrTransform_HTML5_Input();
    }
}
