<?php

class HTMLPurifier_HTMLModule_HTML5_ListTest extends BaseTestCase
{
    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider olProvider
     */
    public function testOl($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function olProvider()
    {
        return array(
            'ol empty' => array(
                '<ol></ol>',
            ),
            'ol simple' => array(
                '<ol><li>Foo</li></ol>',
            ),
            'ol attrs' => array(
                '<ol start="2" type="i" reversed><li>Foo</li></ol>',
            ),
            'ol auto-closing' => array(
                '<ol><li>Foo<li>Bar<li>Baz</ol>',
                '<ol><li>Foo</li><li>Bar</li><li>Baz</li></ol>',
            ),
            'ol wrap text in li' => array(
                '<ol>Foo</ol>',
                '<ol><li>Foo</li></ol>',
            ),
            'ol append text to previous li' => array(
                '<ol><li>Foo</li>Bar<li>Baz</li></ol>',
                '<ol><li>FooBar</li><li>Baz</li></ol>',
            ),
        );
    }

    public function testOlWithForbiddenLi()
    {
        $this->config->set('HTML.ForbiddenElements', array('li'));

        $this->assertPurification('<ol><li>Foo</li></ol>', '');
        $this->assertWarning('Cannot allow ul/ol without allowing li');
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider ulProvider
     */
    public function testUl($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function ulProvider()
    {
        return array(
            'ul empty' => array(
                '<ul></ul>',
            ),
            'ul simple' => array(
                '<ul><li>Foo</li></ul>',
            ),
            'ul li auto-closing' => array(
                '<ul><li>Foo<li>Bar<li>Baz</ul>',
                '<ul><li>Foo</li><li>Bar</li><li>Baz</li></ul>',
            ),
            'ul wrap text in li' => array(
                '<ul>Foo</ul>',
                '<ul><li>Foo</li></ul>',
            ),
            'ul append text to previous li' => array(
                '<ul><li>Foo</li>Bar<li>Baz</li></ul>',
                '<ul><li>FooBar</li><li>Baz</li></ul>',
            ),
        );
    }

    public function testUlWithForbiddenLi()
    {
        $this->config->set('HTML.ForbiddenElements', array('li'));

        $this->assertPurification('<ul><li>Foo</li></ul>', '');
        $this->assertWarning('Cannot allow ul/ol without allowing li');
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider dlProvider
     */
    public function testDl($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function dlProvider()
    {
        return array(
            // Test cases (with tiny adjustments) taken from:
            // https://github.com/web-platform-tests/wpt/blob/master/conformance-checkers/tools/dl.py
            // valid ----------------------------------------------------------
            'dl basic' => array(
                '<dl><dt>text<dd>text</dl>',
                '<dl><dt>text</dt><dd>text</dd></dl>',
            ),
            'dl empty' => array(
                '<dl></dl>',
            ),
            'dl empty-dt-dd' => array(
                '<dl><dt><dd></dl>',
                '<dl><dt></dt><dd></dd></dl>',
            ),
            'dl multiple-groups' => array(
                '<dl><dt>1<dd>a<dt>2<dd>a<dd>b<dt>3<dt>4<dt>5<dd>a</dl>',
                '<dl><dt>1</dt><dd>a</dd><dt>2</dt><dd>a</dd><dd>b</dd><dt>3</dt><dt>4</dt><dt>5</dt><dd>a</dd></dl>',
            ),
            'dl header-in-dd' => array(
                '<dl><dt>text<dd><header>text</header></dl>',
                '<dl><dt>text</dt><dd><header>text</header></dd></dl>',
            ),
            'dl footer-in-dd' => array(
                '<dl><dt>text<dd><footer>text</footer></dl>',
                '<dl><dt>text</dt><dd><footer>text</footer></dd></dl>',
            ),
            'dl article-in-dd' => array(
                '<dl><dt>text<dd><article><h2>text</h2></article></dl>',
                '<dl><dt>text</dt><dd><article><h2>text</h2></article></dd></dl>',
            ),
            'dl aside-in-dd' => array(
                '<dl><dt>text<dd><aside><h2>text</h2></aside></dl>',
                '<dl><dt>text</dt><dd><aside><h2>text</h2></aside></dd></dl>',
            ),
            'dl nav-in-dd' => array(
                '<dl><dt>text<dd><nav><h2>text</h2></nav></dl>',
                '<dl><dt>text</dt><dd><nav><h2>text</h2></nav></dd></dl>',
            ),
            'dl section-in-dd' => array(
                '<dl><dt>text<dd><section><h2>text</h2></section></dl>',
                '<dl><dt>text</dt><dd><section><h2>text</h2></section></dd></dl>',
            ),
            'dl h1-in-dd' => array(
                '<dl><dt>text<dd><h1>text</h1></dl>',
                '<dl><dt>text</dt><dd><h1>text</h1></dd></dl>',
            ),
            'dl h2-in-dd' => array(
                '<dl><dt>text<dd><h2>text</h2></dl>',
                '<dl><dt>text</dt><dd><h2>text</h2></dd></dl>',
            ),
            'dl h3-in-dd' => array(
                '<dl><dt>text<dd><h3>text</h3></dl>',
                '<dl><dt>text</dt><dd><h3>text</h3></dd></dl>',
            ),
            'dl h4-in-dd' => array(
                '<dl><dt>text<dd><h4>text</h4></dl>',
                '<dl><dt>text</dt><dd><h4>text</h4></dd></dl>',
            ),
            'dl h5-in-dd' => array(
                '<dl><dt>text<dd><h5>text</h5></dl>',
                '<dl><dt>text</dt><dd><h5>text</h5></dd></dl>',
            ),
            'dl h6-in-dd' => array(
                '<dl><dt>text<dd><h6>text</h6></dl>',
                '<dl><dt>text</dt><dd><h6>text</h6></dd></dl>',
            ),
            'dl div-in-dt' => array(
                '<dl><dt><div>text</div><dd>text</dl>',
                '<dl><dt><div>text</div></dt><dd>text</dd></dl>',
            ),
            'dl p-in-dt' => array(
                '<dl><dt><p>1<p>1<dd>a</dl>',
                '<dl><dt><p>1</p><p>1</p></dt><dd>a</dd></dl>',
            ),
            /** @see testDlInDt() */
            // 'dl dl-in-dt' => array(
            //    '<dl><dt><dl><dt>1<dd>a</dl><dd>b</dl>',
            //    '<dl><dt><dl><dt>1</dt><dd>a</dd></dl></dt><dd>b</dd></dl>',
            // ),
            'dl dl-in-dd' => array(
                '<dl><dt>1<dd><dl><dt>2<dd>a</dl></dl>',
                '<dl><dt>1</dt><dd><dl><dt>2</dt><dd>a</dd></dl></dd></dl>',
            ),
            'dl interactive' => array(
                '<dl><dt><a href="#">1</a><dd><a href="#">a</a></dl>',
                '<dl><dt><a href="#">1</a></dt><dd><a href="#">a</a></dd></dl>',
            ),
            'dl div-basic' => array(
                '<dl><div><dt>1<dd>a</div></dl>',
                '<dl><div><dt>1</dt><dd>a</dd></div></dl>',
            ),
            'dl multiple-divs' => array(
                '<dl><div><dt>1<dd>a</div><div><dt>2<dd>a<dd>b</div><div><dt>3<dt>4<dt>5<dd>a</div></dl>',
                '<dl><div><dt>1</dt><dd>a</dd></div><div><dt>2</dt><dd>a</dd><dd>b</dd></div><div><dt>3</dt><dt>4</dt><dt>5</dt><dd>a</dd></div></dl>',
            ),

            // invalid --------------------------------------------------------
            'dl dl-in-p' => array(
                '<p><dl><dt>text<dd>text</dl></p>',
                '<p></p><dl><dt>text</dt><dd>text</dd></dl>',
            ),
            'dl header-in-dt' => array(
                '<dl><dt><div><header>text</header></div><dd>text</dl>',
                '<dl><dt><div></div></dt><dd>text</dd></dl>',
            ),
            'dl footer-in-dt' => array(
                '<dl><dt><footer>text</footer><dd>text</dl>',
                '<dl><dt></dt><dd>text</dd></dl>',
            ),
            'dl article-in-dt' => array(
                '<dl><dt><article><h2>text</h2></article><dd>text</dl>',
                '<dl><dt></dt><dd>text</dd></dl>',
            ),
            'dl aside-in-dt' => array(
                '<dl><dt><aside><h2>text</h2></aside><dd>text</dl>',
                '<dl><dt></dt><dd>text</dd></dl>',
            ),
            'dl nav-in-dt' => array(
                '<dl><dt><nav><h2>text</h2></nav><dd>text</dl>',
                '<dl><dt></dt><dd>text</dd></dl>',
            ),
            'dl section-in-dt' => array(
                '<dl><dt><section><h2>text</h2></section><dd>text</dl>',
                '<dl><dt></dt><dd>text</dd></dl>',
            ),
            'dl h1-in-dt' => array(
                '<dl><dt><h1>text</h1><dd>text</dl>',
                '<dl><dt></dt><dd>text</dd></dl>',
            ),
            'dl h2-in-dt' => array(
                '<dl><dt><h2>text</h2><dd>text</dl>',
                '<dl><dt></dt><dd>text</dd></dl>',
            ),
            'dl h3-in-dt' => array(
                '<dl><dt><h3>text</h3><dd>text</dl>',
                '<dl><dt></dt><dd>text</dd></dl>',
            ),
            'dl h4-in-dt' => array(
                '<dl><dt><h4>text</h4><dd>text</dl>',
                '<dl><dt></dt><dd>text</dd></dl>',
            ),
            'dl h5-in-dt' => array(
                '<dl><dt><h5>text</h5><dd>text</dl>',
                '<dl><dt></dt><dd>text</dd></dl>',
            ),
            'dl h6-in-dt' => array(
                '<dl><dt><h6>text</h6><dd>text</dl>',
                '<dl><dt></dt><dd>text</dd></dl>',
            ),
            'dl hgroup-in-dt' => array(
                '<dl><dt><hgroup><h1>text</h1></hgroup><dd>text</dl>',
                '<dl><dt></dt><dd>text</dd></dl>',
            ),
            'dl hgroup-in-dd' => array(
                '<dl><dt>text<dd><hgroup><h1>text</h1></hgroup></dl>',
                '<dl><dt>text</dt><dd><hgroup><h1>text</h1></hgroup></dd></dl>',
            ),
            'dl only-dt' => array(
                '<dl><dt>1</dl>',
                '<dl><dt>1</dt><dd></dd></dl>',
            ),
            'dl only-dd' => array(
                '<dl><dd>a</dl>',
                '<dl><dt></dt><dd>a</dd></dl>',
            ),
            'dl first-dd' => array(
                '<dl><dd>a<dt>2<dd>b</dl>',
                '<dl><dt></dt><dd>a</dd><dt>2</dt><dd>b</dd></dl>',
            ),
            'dl last-dt' => array(
                '<dl><dt>1<dd>a<dt>2</dl>',
                '<dl><dt>1</dt><dd>a</dd><dt>2</dt><dd></dd></dl>',
            ),
            'dl contains-text' => array(
                '<dl><dt>1</dt>x</dl>',
                '<dl><dt>1</dt><dd></dd></dl>',
            ),
            'dl contains-text-2' => array(
                '<dl><dt>1<dd>a</dd>x</dl>',
                '<dl><dt>1</dt><dd>a</dd></dl>',
            ),
            'dl contains-dl' => array(
                '<dl><dt>1<dd>a</dd><dl></dl></dl>',
                '<dl><dt>1</dt><dd>a</dd></dl><dl></dl>',
            ),
            'dl empty-div' => array(
                '<dl><div></div></dl>',
                '<dl></dl>',
            ),
            'dl empty-div-2' => array(
                '<dl><div></div><div><dt>2<dd>b</div></dl>',
                '<dl><div><dt>2</dt><dd>b</dd></div></dl>',
            ),
            'dl mixed-dt-dd-div' => array(
                '<dl><dt>1<dd>a</dd><div><dt>2<dd>b</div></dl>',
                '<dl><dt>1</dt><dd>a</dd></dl>',
            ),
            'dl mixed-div-dt-dd' => array(
                '<dl><div><dt>1<dd>a</div><dt>2<dd>b</dd></dl>',
                '<dl><div><dt>1</dt><dd>a</dd></div></dl>',
            ),
            'dl nested-divs' => array(
                '<dl><div><div><dt>1<dd>a</div></div></dl>',
                '<dl></dl>',
            ),
            'dl div-splitting-groups' => array(
                '<dl><div><dt>1</div><div><dd>a</div></dl>',
                '<dl><div><dt>1</dt><dd></dd></div><div><dt></dt><dd>a</dd></div></dl>',
            ),
            'dl div-splitting-groups-2' => array(
                '<dl><div><dt>1<dd>a</div><div><dd>b</div></dl>',
                '<dl><div><dt>1</dt><dd>a</dd></div><div><dt></dt><dd>b</dd></div></dl>',
            ),
            'dl div-splitting-groups-3' => array(
                '<dl><div><dt>1</div><div><dt>2<dd>b</div></dl>',
                '<dl><div><dt>1</dt><dd></dd></div><div><dt>2</dt><dd>b</dd></div></dl>',
            ),
            'dl div-contains-text' => array(
                '<dl><div>x<dt>2<dd>b</div></dl>',
                '<dl><div><dt>2</dt><dd>b</dd></div></dl>',
            ),
            'dl div-contains-dl' => array(
                '<dl><div><dl></dl><dt>2<dd>b</div></dl>',
                '<dl><div><dt>2</dt><dd>b</dd></div></dl>',
            ),
            'dl div-multiple-groups' => array(
                '<dl><div><dt>1<dd>a<dt>2<dd>a<dd>b<dt>3<dt>4<dt>5<dd>a</div></dl>',
                // TODO: Should a new div be started if a dt is found after dd?
                '<dl><div><dt>1</dt><dd>a</dd><dd>a</dd><dd>b</dd><dd>a</dd></div></dl>',
            ),
        );
    }

    public function testDlInDt()
    {
        // DOMLex lexer auto-closes dt whenever dl is encountered. So in order to test
        // this we have to switch to a lexer that does not mess up the DOM.
        $this->config->set('Core.LexerImpl', 'DirectLex');
        $this->assertPurification(
            '<dl><dt><dl><dt>1<dd>a</dl><dd>b</dl>',
            '<dl><dt><dl><dt>1</dt><dd>a</dd></dl></dt><dd>b</dd></dl>'
        );
    }

    public function testDlWithForbiddenDt()
    {
        $this->config->set('HTML.ForbiddenElements', array('dt'));

        $this->assertPurification('<dl><dt>foo</dt><dd>bar</dd></dl>', '');
        $this->assertWarning('Cannot allow dl without allowing dt');
    }

    public function testDlWithForbiddenDd()
    {
        $this->config->set('HTML.ForbiddenElements', array('dd'));

        $this->assertPurification('<dl><dt>foo</dt><dd>bar</dd></dl>', '');
        $this->assertWarning('Cannot allow dl without allowing dd');
    }

    /**
     * @param string $input
     * @param string $expected OPTIONAL
     * @dataProvider liProvider
     */
    public function testLi($input, $expected = null)
    {
        $this->assertPurification($input, $expected);
    }

    public function liProvider()
    {
        return array(
            'li value positive' => array(
                '<ul><li value="2">Foo</li></ul>',
            ),
            'li value negative' => array(
                '<ul><li value="-2">Foo</li></ul>',
            ),
        );
    }

    public function testWhitespaces()
    {
        // depending on libxml version present whitespace handling by DOMLex
        // lexer may differ, so for testing input with whitespaces we switch
        // to more reliable lexer implementation
        $this->config->set('Core.LexerImpl', 'DirectLex');

        $this->assertPurification('<dl> </dl>');
        $this->assertPurification('<dl> <dt> </dt> <dd> </dd> </dl>');
        $this->assertPurification('<dl> <div><dt> </dt> <dd> </dd></div> </dl>');

        $this->assertPurification('<ol> </ol>');
        $this->assertPurification('<ol> <li> </li> </ol>');

        $this->assertPurification('<ul> </ul>');
        $this->assertPurification('<ul> <li> </li> </ul>');
    }
}
