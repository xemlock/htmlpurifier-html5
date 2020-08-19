<?php

class HTMLPurifier_HTMLModule_HTML5_CommonAttributesTest extends BaseTestCase
{
    public function testLang()
    {
        $this->assertPurification('<p lang="en">text</p>');
        $this->assertPurification('<p xml:lang="en">text</p>',  '<p lang="en">text</p>');
        $this->assertPurification('<p lang="en" xml:lang="en">text</p>',  '<p lang="en">text</p>');

        // When there is a conflict between xml:lang and lang values, lang takes precedence in HTML mode
        $this->assertPurification('<p lang="en" xml:lang="pl">text</p>',  '<p lang="en">text</p>');

        $this->assertPurification('<hr xml:lang="en">', '<hr lang="en">');
    }

    public function testXmlLang()
    {
        $this->config->set('HTML.XHTML', true);

        $this->assertPurification('<p lang="en">text</p>');

        // When the attribute xml:lang in no namespace is specified, the element must also have the attribute lang present with the same value.
        $this->assertPurification('<p xml:lang="en">text</p>', '<p xml:lang="en" lang="en">text</p>');

        // When there is a conflict between xml:lang and lang values, xml:lang takes precedence in XHTML mode
        $this->assertPurification('<p lang="en" xml:lang="pl">text</p>', '<p lang="pl" xml:lang="pl">text</p>');

        $this->assertPurification('<hr xml:lang="en">', '<hr xml:lang="en" lang="en" />');
    }

    public function testTabindex()
    {
        $this->config->autoFinalize = false;

        $this->assertPurification('<div tabindex="0">Foo</div>');
        $this->assertPurification('<span tabindex="-1">Foo</span>');

        $this->config->set('HTML.Trusted', true);
        $this->assertPurification('<button tabindex="1">Foo</button>');
    }

    public function testInputmode()
    {
        $this->config->autoFinalize = false;

        $this->assertPurification('<div inputmode="text">Foo</div>');
        $this->assertPurification('<span inputmode="search">Foo</span>');
        $this->assertPurification('<p inputmode="decimal">123</p>');
        $this->assertPurification('<section inputmode="numeric">123</section>');
        $this->assertPurification('<h1 inputmode="email">foo@example.com</h1>');
        $this->assertPurification('<main inputmode="url">http://www.example.com</main>');
        $this->assertPurification('<hr inputmode="text">');

        $this->assertPurification('<div inputmode="none">Foo</div>', '<div>Foo</div>');
        $this->assertPurification('<div inputmode="foo">foo</div>', '<div>foo</div>');

        $this->config->set('HTML.Trusted', true);
        $this->assertPurification('<input type="text" inputmode="text" value="foo">');
        $this->assertPurification('<button inputmode="search">foo</button>');
        $this->assertPurification('<textarea inputmode="decimal" cols="10" rows="2">123</textarea>');

        $this->assertPurification('<input type="text" inputmode="none" value="foo">', '<input type="text" value="foo">');
        $this->assertPurification('<input type="text" inputmode="foo" value="foo">', '<input type="text" value="foo">');
    }
}
