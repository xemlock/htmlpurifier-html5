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
