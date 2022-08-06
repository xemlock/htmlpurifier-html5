<?php

/**
 * HTML5 compliant definition for table contents.
 *
 * Content model: In this order: optionally a caption element, followed by zero or more
 * colgroup elements, followed optionally by a thead element, followed by either zero
 * or more tbody elements or one or more tr elements, followed optionally by a tfoot
 * element.
 *
 * @see https://html.spec.whatwg.org/multipage/tables.html#the-table-element
 */
class HTMLPurifier_ChildDef_HTML5_Table extends HTMLPurifier_ChildDef
{
    /**
     * @type bool
     */
    public $allow_empty = false;

    /**
     * @type string
     */
    public $type = 'table';

    /**
     * @type array
     */
    public $elements = array(
        'tr' => true,
        'tbody' => true,
        'thead' => true,
        'tfoot' => true,
        'caption' => true,
        'colgroup' => true,
        'col' => true,
    );

    /**
     * @param array $children
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return array
     */
    public function validateChildren($children, $config, $context)
    {
        if (empty($children)) {
            // Table children are optional
            return $children;
        }

        // At most one of each of these elements is allowed in a table
        $caption = array();
        $thead = array();
        $tfoot = array();

        // and as many of these as you want
        $cols = array(); // <col>, <colgroup> and following whitespace nodes
        $content = array(); // <tr> and <tbody>

        // Whitespace accumulators
        $initial_ws = array();
        $after_caption_ws = array();
        $after_thead_ws = array();
        $after_tfoot_ws = array();

        // Essentially, we have two modes: thead/tfoot/tbody mode, and tr mode.
        // If we encounter a thead, tfoot or tbody, we are placed in the former
        // mode, and we *must* wrap any stray tr segments with a tbody. But if
        // we don't run into any of them, just having tr tags is OK.
        $tbody_mode = false;

        $ws_accum =& $initial_ws;

        foreach ($children as $node) {
            if ($node instanceof HTMLPurifier_Node_Comment) {
                $ws_accum[] = $node;
                continue;
            }

            switch ($node->name) {
                case 'tbody':
                    $tbody_mode = true;
                    // no break

                case 'tr':
                    $content[] = $node;
                    $ws_accum =& $content;
                    break;

                case 'caption':
                    // there can only be one caption!
                    if (count($caption)) {
                        break;
                    }
                    $caption[] = $node;
                    $ws_accum =& $after_caption_ws;
                    break;

                case 'thead':
                    $tbody_mode = true;
                    if (empty($thead)) {
                        $thead[] = $node;
                        $ws_accum =& $after_thead_ws;
                    } else {
                        // Oops, there's a second one! What should we do? Current behavior
                        // is to mutate the first and last entries into <tbody> tags, and
                        // then put into content, same as in HTMLPurifier_ChildDef_Table.
                        $node->name = 'tbody';
                        $content[] = $node;
                        $ws_accum =& $content;
                    }
                    break;

                case 'tfoot':
                    $tbody_mode = true;
                    if (empty($tfoot)) {
                        $tfoot[] = $node;
                        $ws_accum =& $after_tfoot_ws;
                    } else {
                        $node->name = 'tbody';
                        $content[] = $node;
                        $ws_accum =& $content;
                    }
                    break;

                case 'colgroup':
                case 'col':
                    $cols[] = $node;
                    $ws_accum =& $cols;
                    break;

                case '#PCDATA':
                    // How is whitespace handled? We treat is as sticky to the *end* of
                    // the previous element. So all the nonsense we have worked on is to
                    // keep things together.
                    if (!empty($node->is_whitespace)) {
                        $ws_accum[] = $node;
                    }
                    break;
            }
        }

        $ret = array_merge(
            $initial_ws,
            $caption,
            $after_caption_ws,
            $cols,
            $thead,
            $after_thead_ws,
            $tfoot,
            $after_tfoot_ws
        );

        if ($tbody_mode) {
            // At least one of thead/tbody/tfoot children is present, we have to
            // shuffle any <tr> children into <tbody>
            $current_tr_tbody = null;

            foreach ($content as $node) {
                switch ($node->name) {
                    case 'tbody':
                        $current_tr_tbody = null;
                        $ret[] = $node;
                        break;

                    case 'tr':
                        if ($current_tr_tbody === null) {
                            $current_tr_tbody = new HTMLPurifier_Node_Element('tbody');
                            $ret[] = $current_tr_tbody;
                        }
                        $current_tr_tbody->children[] = $node;
                        break;

                    case '#PCDATA':
                        // The only text nodes present here are whitespace
                        if ($current_tr_tbody === null) {
                            $ret[] = $node;
                        } else {
                            $current_tr_tbody->children[] = $node;
                        }
                        break;
                }
            }
        } else {
            $ret = array_merge($ret, $content);
        }

        return $ret;
    }
}
