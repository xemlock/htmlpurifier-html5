<?php

class HTMLPurifier_HTMLModule_HTML5_IframeTest extends BaseTestCase
{
    public function testSafeIframe()
    {
        $this->config->set('HTML.SafeIframe', true);
        $this->config->set('URI.SafeIframeRegexp', '/^foo$/');

        $this->assertPurification(
            '<iframe width="640" height="360" src="foo"></iframe>'
        );

        $this->assertPurification(
            '<iframe width="640" height="360" src="foo" allowfullscreen></iframe>',
            '<iframe width="640" height="360" src="foo"></iframe>'
        );

        // Error: Text not allowed in element iframe in this context.
        // Content model for element iframe: Nothing.
        $this->assertPurification(
            '<iframe>Foo</iframe>',
            '<iframe></iframe>'
        );

        $this->assertPurification('<h1><iframe></iframe></h1>');
        $this->assertPurification('<section><iframe></iframe></section>');
        $this->assertPurification('<div><iframe></iframe></div>');
        $this->assertPurification('<span><iframe></iframe></span>');
        $this->assertPurification('<p><iframe></iframe></p>');
    }

    public function testIframeAllowFullscreen()
    {
        $this->config->set('HTML.SafeIframe', true);
        $this->config->set('URI.SafeIframeRegexp', '/^foo$/');
        $this->config->set('HTML.IframeAllowFullscreen', true);

        $this->assertPurification('<iframe src="foo" allowfullscreen></iframe>');
    }

    public function testIframeInTrustedMode()
    {
        $this->config->set('HTML.Trusted', true);

        $this->assertPurification(
            '<iframe width="640" height="360" src="foobar" allowfullscreen></iframe>'
        );
    }
}
