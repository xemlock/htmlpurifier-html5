<?php

abstract class HTMLPurifier_HTMLModule_HTML5_Forms_BaseTest
    extends HTMLPurifier_HTMLModule_HTML5_AbstractTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->config->set('HTML.Forms', true);
    }
}
