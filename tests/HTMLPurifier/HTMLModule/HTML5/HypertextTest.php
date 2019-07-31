<?php

class HTMLPurifier_HTMLModule_HTML5_HypertextTest extends BaseTestCase
{
    /**
     * Data provider for {@link testAnchor()}
     * @return array
     */
    public function anchorInput()
    {
        return array(
            array(
                '<a href="foo" type="video/mp4" hreflang="en"><h1>Heading</h1><p>Description</p></a>',
            ),
            array(
                '<a href="foo" target="_blank" rel="nofollow">Visit</a>',
                '<a href="foo" target="_blank" rel="nofollow noreferrer noopener">Visit</a>',
            ),
            array(
                '<a href="foo" download>Download</a>',
                '<a href="foo" download="">Download</a>',
            ),
            array(
                '<a href="foo" download="bar">Download</a>',
            ),
            array(
                '<p>Foo <a href="foo">foo</a> bar</p>'
            ),
            array(
                '<a href="foo"><p>Foo <a href="foo">foo</a> FOO</p></a>',
                '<a href="foo"><p>Foo foo FOO</p></a>',
            ),
            array(
                '<a href="foo"><div>Foo <div><a href="foo">foo</a></div> FOO</div></a>',
                '<a href="foo"><div>Foo <div>foo</div> FOO</div></a>',
            ),
            array(
                '<a href="foo"></a>',
            ),
            array(
                // Autoclosing of the first <a> is done automatically by lexers,
                // tested with DOMLex and PH5P. It's also exactly how browsers do this.
                '<a href="foo">Foo<a href="bar">Bar</a></a>',
                '<a href="foo">Foo</a><a href="bar">Bar</a>',
            ),
            array(
                '<span><a href="foo">foo</a></span>',
            ),
            array(
                '<div><a href="foo">foo</a></div>',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider anchorInput
     */
    public function testAnchor($input, $expected = null)
    {
        $this->config->set('Attr.AllowedFrameTargets', array('_blank'));
        $this->config->set('Attr.AllowedRel', 'nofollow');
        $this->config->autoFinalize = false;

        $this->assertPurification($input, $expected);
    }
}
