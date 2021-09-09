<?php

/**
 * Transforms FONT tags to the proper form (SPAN with CSS styling)
 *
 * This is a replacement implementation for {@link HTMLPurifier_TagTransform_Font},
 * because the original one wrongly computes font size increments relative to parent
 * element (via percent), instead of using increments relative to the document.
 *
 * In the example below both strings have the same font size:
 * <pre>
 * <font size="4"><font size="+2">Foo</font></font>
 * <font size="+2">Foo</font>
 * </pre>
 */
class HTMLPurifier_TagTransform_Font2 extends HTMLPurifier_TagTransform
{
    /**
     * @type string
     */
    public $transform_to = 'span';

    /**
     * Size conversion values, based on Chrome and Firefox
     * @var string[]
     */
    protected $fontSizes = array(
        1 => 'xx-small',
        2 => 'small',
        3 => 'medium',
        4 => 'large',
        5 => 'x-large',
        6 => 'xx-large',
        7 => '3rem', // xxx-large is added in CSS 4.0
    );

    /**
     * @param HTMLPurifier_Token_Tag $tag
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return HTMLPurifier_Token_End|string
     */
    public function transform($tag, $config, $context)
    {
        if ($tag instanceof HTMLPurifier_Token_End) {
            $new_tag = clone $tag;
            $new_tag->name = $this->transform_to;
            return $new_tag;
        }

        $attr = $tag->attr;
        $prepend_style = '';

        if (isset($attr['color'])) {
            $prepend_style .= 'color:' . $attr['color'] . ';';
            unset($attr['color']);
        }

        if (isset($attr['face'])) {
            $prepend_style .= 'font-family:' . $attr['face'] . ';';
            unset($attr['face']);
        }

        if (isset($attr['size'])) {
            $prepend_style .= $this->transformSize($attr['size']);
            unset($attr['size']);
        }

        if ($prepend_style) {
            $attr['style'] = $prepend_style . (isset($attr['style']) ? $attr['style'] : '');
        }

        $new_tag = clone $tag;
        $new_tag->name = $this->transform_to;
        $new_tag->attr = $attr;

        return $new_tag;
    }

    /**
     * @param string $size
     * @return string
     */
    protected function transformSize($size)
    {
        $size = trim($size);

        if (!strlen($size)) {
            return '';
        }

        $sign = substr($size, 0, 1);

        // values with +/- are computed relative to 3
        if ($sign === '+') {
            $value = 3 + (int) substr($size, 1);
        } elseif ($sign === '-') {
            $value = 3 - (int) substr($size, 1);
        } else {
            $value = (int) $size;
        }

        // Trim value to range defined in the spec
        // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/font#attr-size
        $value = min(7, max(1, $value));

        return 'font-size:' . $this->fontSizes[$value] . ';';
    }
}
