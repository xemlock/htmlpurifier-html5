<?php

class HTMLPurifier_HTMLModule_HTML5_FormsTest extends BaseTestCase
{
    /**
     * Data provider for {@link testForm()}
     * @return array
     */
    public function formInput()
    {
        return array(
            array(
                '<form>Foo</form>',
            ),
            array(
                '<form target="_blank" enctype="text/plain">Foo</form>',
            ),
            array(
                '<form><section><h1>Foo</h1></section></form>',
            ),
            array(
                '<form><nav>Foo</nav></form>'
            ),
            array(
                '<form><form>Foo</form></form>',
                // DOMLex output, DirectLex outputs '<form></form>'
                '<form></form><form>Foo</form>',
            ),
            array(
                '<form action="foo"><fieldset><legend>Foo</legend>Bar</fieldset></form>',
            ),
            array(
                '<dialog><form method="dialog"></form></dialog>',
            ),
        );
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider formInput
     */
    public function testForm($input, $expected = null)
    {
        $this->config->set('HTML.Trusted', true);
        $this->config->set('Attr.AllowedFrameTargets', array('_blank'));
        $this->assertPurification($input, $expected);
    }

    public function testFormWhitespace()
    {
        $this->config->set('HTML.Trusted', true);
        $this->config->set('Core.LexerImpl', 'DirectLex');

        $this->assertPurification('
            <form action="foo">
                <fieldset disabled name="bar">
                    <legend>Personal Information</legend>
                    Last Name: <input name="personal_lastname" type="text" tabindex="1">
                    First Name: <input name="personal_firstname" type="text" tabindex="2">
                    Address: <input name="personal_address" type="text" tabindex="3">
                </fieldset>
            </form>
        ');
    }

    public function testHTMLFormsConfigDirective()
    {
        $this->config->set('HTML.Trusted', false);
        $this->config->set('HTML.Forms', true);

        $this->assertPurification(
            '<form action="..." method="post"><input type="text"><textarea cols="20" rows="3"></textarea></form>'
        );
    }
}
