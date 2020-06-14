<?php

/**
 * @property HTMLPurifier_AttrDef_HTML5_Email $attr
 */
class HTMLPurifier_AttrDef_HTML5_EmailTest extends AttrDefTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->attr = new HTMLPurifier_AttrDef_HTML5_Email();
    }

    public function testDefault()
    {
        $this->assertValidate('user@example.com');
        $this->assertValidate("user@example.com\n", 'user@example.com');
        $this->assertValidate("user@example.com\r", 'user@example.com');
        $this->assertValidate('user+test@example.com');

        $this->assertValidate('', false);
        $this->assertValidate('example.com', false);
    }

    public function testMultiple()
    {
        $currentToken = new HTMLPurifier_Token_Empty('input', array('multiple' => ''));
        $this->context->register('CurrentToken', $currentToken);

        $this->assertValidate('user@example.com,user2@example.com');
        $this->assertValidate('  user@example.com  , user2@example.com  ', 'user@example.com,user2@example.com');

        $this->assertValidate('u,user@example.com,user2@example.com', 'user@example.com,user2@example.com');
    }
}
