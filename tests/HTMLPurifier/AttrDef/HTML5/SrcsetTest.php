<?php

/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpUnhandledExceptionInspection */

/**
 * @property HTMLPurifier_AttrDef_HTML5_Srcset $attr
 */
class HTMLPurifier_AttrDef_HTML5_SrcsetTest extends AttrDefTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->attr = new HTMLPurifier_AttrDef_HTML5_Srcset();
    }

    /**
     * @dataProvider srcsetData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testSrcset($input, $expected = null)
    {
        $this->assertValidate($input, $expected);
    }

    public function srcsetData()
    {
        return array(
            // valid values
            array('image.png', 'image.png'),
            array('image.png 2x', 'image.png 2x'),
            array('image.png 100w', 'image.png 100w'),
            array('image.png 2x, image2.png 4x', 'image.png 2x, image2.png 4x'),
            array('ima,ge.png 2x, image2.png 4x', 'ima,ge.png 2x, image2.png 4x'),
            // Empty state
            array('', false),
            // Whitespace cleanup
            array('image.png        ', 'image.png'),
            array('image.png              5x', 'image.png 5x'),
            array('image.png 5x         ', 'image.png 5x'),
            // Comma cleanup
            array('image.png 5x,, cat.png 5w,', 'image.png 5x, cat.png 5w'),
            // Invalid descriptor
            array('image.png 5p,', false),
            array('image.png 2x, cat.png 5p', 'image.png 2x'),
        );
    }

    /**
     * @dataProvider srcsetUriRuleData
     * @param string $input
     * @param string $expected OPTIONAL
     */
    public function testSrcsetUriFollowsUriRules($input, $expected = null)
    {
        $this->config->set('URI.AllowedSchemes', array(
            'http' => true,
            'https' => true,
            'tel' => true,
        ));
        $this->config->set('URI.OverrideAllowedSchemes', false);
        $this->config->set('URI.Base', 'https://example.com');
        $this->config->set('URI.MakeAbsolute', true);

        $this->assertValidate($input, $expected);
    }

    public function srcsetUriRuleData()
    {
        return array(
            // Allowed URIs
            array('http://image.png 2x', 'http://image.png 2x'),
            array('https://image.png 2x', 'https://image.png 2x'),
            // Allowed, made absolute
            array('image.png', 'https://example.com/image.png'),
            array('image.png 2x', 'https://example.com/image.png 2x'),
            // Non-allowed
            array('file://image.png 2x', false),
            array('ftp://image.png 2x', false),
            // Allowed but non-browsable
            array('tel:0133432424234 2x', false),
            // Mixed
            array('https://image.png 2x, tel://image.png 4x, ftp://cat.png 5x', 'https://image.png 2x'),
            array('https://image.png 2x, file://image.png 3x, ftp://cat.png 5x', 'https://image.png 2x'),
            array('file://image.png, https://image.png 2x', 'https://image.png 2x'),
        );
    }

    public function testSrcsetWithDisabledUris()
    {
        $this->config->set('URI.Disable', true);

        $this->assertValidate('http://image.png 2x', false);
        $this->assertValidate('image.png', false);
        $this->assertValidate('image.png 5w', false);
    }
}
