<?php

class HTMLPurifier_HTMLModule_HTML5_CommonAttributesTest extends BaseTestCase
{
    public function testLang()
    {
        $this->assertPurification('<p lang="en">text</p>');
        $this->assertPurification('<p xml:lang="en">text</p>',  '<p lang="en">text</p>');
        $this->assertPurification('<p lang="en" xml:lang="en">text</p>',  '<p lang="en">text</p>');
        $this->assertPurification('<p lang="en" xml:lang="pl">text</p>',  '<p lang="en">text</p>');

        $this->assertPurification('<hr xml:lang="en">', '<hr lang="en">');
    }

    public function testXmlLang()
    {
        $this->config->set('HTML.XHTML', true);

        $this->assertPurification('<p lang="en">text</p>');

        // When the attribute xml:lang in no namespace is specified, the element must also have the attribute lang present with the same value.
        $this->assertPurification('<p xml:lang="en">text</p>', '<p xml:lang="en" lang="en">text</p>');

        // When the attribute xml:lang in no namespace is specified, the element must also have the attribute lang present with the same value.
        $this->assertPurification('<p lang="en" xml:lang="pl">text</p>', '<p lang="en" xml:lang="en">text</p>');

        $this->assertPurification('<hr xml:lang="en">', '<hr xml:lang="en" lang="en" />');
    }
}
