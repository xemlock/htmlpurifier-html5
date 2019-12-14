<?php

class Html5LexTest extends BaseTestCase
{
    /**
     * @var HTMLPurifier_Context
     */
    protected $context;

    /**
     * This method is called before each test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->context = new HTMLPurifier_Context;
    }

    /**
     * http://htmlpurifier.org/live/configdoc/plain.html#Core.LexerImpl states that object usage of Core.LexerImpl
     * is "super-advanced" and may be removed. We don't want it removing, hence the test...
     *
     * @throws HTMLPurifier_Exception
     */
    public function test_create_objectLexerImpl()
    {
        $this->config->set('Core.LexerImpl', new HTMLPurifier_Lexer_Html5Lex);

        $lexer = HTMLPurifier_Lexer::create($this->config);

        $this->assertInstanceOf(HTMLPurifier_Lexer_Html5Lex::class, $lexer);
    }

    /**
     * Tokenize an empty input.
     *
     * @return void
     */
    public function test_tokenizeHTML_emptyInput()
    {
        $this->assertTokenization('', array());
    }

    /**
     * Tokenize plain text input.
     *
     * @return void
     */
    public function test_tokenizeHTML_plainText()
    {
        $this->assertTokenization(
            'This is regular text.',
            array(
                new HTMLPurifier_Token_Text('This is regular text.')
            )
        );
    }

    /**
     * Tokenize a mix of plain text and HTML.
     *
     * @return void
     */
    public function test_tokenizeHTML_textAndTags()
    {
        $this->assertTokenization(
            'This is <b>bold</b> text',
            array(
                new HTMLPurifier_Token_Text('This is '),
                new HTMLPurifier_Token_Start('b', array()),
                new HTMLPurifier_Token_Text('bold'),
                new HTMLPurifier_Token_End('b'),
                new HTMLPurifier_Token_Text(' text'),
            )
        );
    }

    /**
     * Tokenize mixed case HTML tags.
     *
     * @return void
     */
    public function test_tokenizeHTML_normalizeCase()
    {
        $this->assertTokenization(
            '<DIV>Totally rad dude. <b>asdf</b></div>',
            array(
                new HTMLPurifier_Token_Start('DIV', array()),
                new HTMLPurifier_Token_Text('Totally rad dude. '),
                new HTMLPurifier_Token_Start('b', array()),
                new HTMLPurifier_Token_Text('asdf'),
                new HTMLPurifier_Token_End('b'),
                new HTMLPurifier_Token_End('div'),
            )
        );
    }

    /**
     * Tokenize malformed HTML.
     *
     * @return void
     */
    public function test_tokenizeHTML_notWellFormed()
    {
        $this->assertTokenization(
            '<asdf></asdf><d></d><poOloka><poolasdf><ds></asdf></ASDF>',
            array(
                new HTMLPurifier_Token_Empty('asdf'),
                new HTMLPurifier_Token_Empty('d'),
                new HTMLPurifier_Token_Start('pooloka'),
                new HTMLPurifier_Token_Start('poolasdf'),
                new HTMLPurifier_Token_Empty('ds'),
                new HTMLPurifier_Token_End('poolasdf'),
                new HTMLPurifier_Token_End('pooloka'),
            )
        );
    }

    /**
     * Tokenize whitespace in a HTML tag.
     *
     * @return void
     */
    public function test_tokenizeHTML_whitespaceInTag()
    {
        $this->assertTokenization(
            '<a' . "\t" . 'href="foobar.php"' . "\n" . 'title="foo!">Link to <b id="asdf">foobar</b></a>',
            array(
                new HTMLPurifier_Token_Start('a', array('href' => 'foobar.php', 'title' => 'foo!')),
                new HTMLPurifier_Token_Text('Link to '),
                new HTMLPurifier_Token_Start('b', array('id' => 'asdf')),
                new HTMLPurifier_Token_Text('foobar'),
                new HTMLPurifier_Token_End('b'),
                new HTMLPurifier_Token_End('a'),
            )
        );
    }

    /**
     * Tokenize a single attribute.
     *
     * @return void
     */
    public function test_tokenizeHTML_singleAttribute()
    {
        $this->assertTokenization(
            '<br style="&amp;" />',
            array(
                new HTMLPurifier_Token_Empty('br', array('style' => '&'))
            )
        );
    }

    /**
     * Tokenize an empty tag.
     *
     * @return void
     */
    public function test_tokenizeHTML_emptyTag()
    {
        $this->assertTokenization(
            '<br />',
            array(new HTMLPurifier_Token_Empty('br'))
        );
    }

    /**
     * Tokenize a HTML comment.
     *
     * @return void
     */
    public function test_tokenizeHTML_comment()
    {
        $this->assertTokenization(
            '<!-- Comment -->',
            array(new HTMLPurifier_Token_Comment(' Comment '))
        );
    }

    /**
     * Tokenize a malformed comment.
     *
     * @return void
     */
    public function test_tokenizeHTML_malformedComment()
    {
        $this->assertTokenization(
            '<!-- not so well formed --->',
            array(new HTMLPurifier_Token_Comment(' not so well formed -'))
        );
    }

    /**
     * Tokenize an unterminated tag.
     *
     * @return void
     */
    public function test_tokenizeHTML_unterminatedTag()
    {
        $this->assertTokenization(
            '<a href=""',
            array(new HTMLPurifier_Token_Empty('a', array('href' => '')))
        );
    }

    /**
     * Tokenize HTML entities.
     *
     * @return void
     */
    public function test_tokenizeHTML_specialEntities()
    {
        $this->assertTokenization(
            '&lt;b&gt;',
            array(new HTMLPurifier_Token_Text('<b>'))
        );
    }

    /**
     * Tokenize an invalid anchor tag containing an premature double quote.
     *
     * @return void
     */
    public function test_tokenizeHTML_earlyQuote()
    {
        $this->assertTokenization(
            '<a "=>',
            array(new HTMLPurifier_Token_Empty('a'))
        );
    }

    /**
     * Tokenize an unescaped double quote.
     *
     * @return void
     */
    public function test_tokenizeHTML_unescapedQuote()
    {
        $this->assertTokenization(
            '"',
            array(new HTMLPurifier_Token_Text('"'))
        );
    }

    /**
     * Tokenize a double quote converted to HTML entities.
     *
     * @return void
     */
    public function test_tokenizeHTML_escapedQuote()
    {
        $this->assertTokenization(
            '&quot;',
            array(new HTMLPurifier_Token_Text('"'))
        );
    }

    /**
     * Tokenize CDATA.
     *
     * @return void
     */
    public function test_tokenizeHTML_cdata()
    {
        $this->assertTokenization(
            '<![CDATA[You <b>can&#39;t</b> get me!]]>',
            array(new HTMLPurifier_Token_Text('You <b>can&#39;t</b> get me!'))
        );
    }

    /**
     * Tokenize character entities.
     *
     * @return void
     */
    public function test_tokenizeHTML_characterEntity()
    {
        $this->assertTokenization(
            '&theta;',
            array(new HTMLPurifier_Token_Text("\xCE\xB8"))
        );
    }

    /**
     * Tokenize character entities inside CDATA.
     *
     * @return void
     */
    public function test_tokenizeHTML_characterEntityInCDATA()
    {
        $this->assertTokenization(
            '<![CDATA[&rarr;]]>',
            array(new HTMLPurifier_Token_Text("&rarr;"))
        );
    }

    /**
     * Tokenize HTML entities in an anchor href attribute.
     *
     * @return void
     */
    public function test_tokenizeHTML_entityInAttribute()
    {
        $this->assertTokenization(
            '<a href="index.php?title=foo&amp;id=bar">Link</a>',
            array(
                new HTMLPurifier_Token_Start('a', array('href' => 'index.php?title=foo&id=bar')),
                new HTMLPurifier_Token_Text('Link'),
                new HTMLPurifier_Token_End('a'),
            )
        );
    }

    /**
     * Tokenize UTF-8 characters.
     *
     * @return void
     */
    public function test_tokenizeHTML_preserveUTF8()
    {
        $this->assertTokenization(
            "\xCE\xB8",
            array(new HTMLPurifier_Token_Text("\xCE\xB8"))
        );
    }

    /**
     * Tokenize HTML entities in a malformed attribute.
     *
     * @return void
     */
    public function test_tokenizeHTML_specialEntityInAttribute()
    {
        $this->assertTokenization(
            '<br test="x &lt; 6" />',
            array(new HTMLPurifier_Token_Empty('br', array('test' => 'x < 6')))
        );
    }

    /**
     * Tokenize an emoticon.
     *
     * @return void
     */
    public function test_tokenizeHTML_emoticonProtection()
    {
        $this->assertTokenization(
            '<b>Whoa! <3 That\'s not good >.></b>',
            array(
                new HTMLPurifier_Token_Start('b'),
                new HTMLPurifier_Token_Text('Whoa! <3 That\'s not good >.>'),
                new HTMLPurifier_Token_End('b'),
            )
        );
    }

    /**
     * Tokenize a HTML comment containing special characters.
     *
     * @return void
     */
    public function test_tokenizeHTML_commentWithFunkyChars()
    {
        $this->assertTokenization(
            '<!-- This >< comment --><br />',
            array(
                new HTMLPurifier_Token_Comment(' This >< comment '),
                new HTMLPurifier_Token_Empty('br'),
            )
        );
    }

    /**
     * Tokenize a scripts CDATA content.
     *
     * @return void
     */
    public function test_tokenizeHTML_scriptCDATAContents()
    {
        $this->config->set('HTML.Trusted', true);

        $this->assertTokenization(
            'Foo: <script>alert("<foo>");</script>',
            array(
                new HTMLPurifier_Token_Text('Foo: '),
                new HTMLPurifier_Token_Start('script'),
                new HTMLPurifier_Token_Text('alert("<foo>");'),
                new HTMLPurifier_Token_End('script'),
            )
        );
    }

    /**
     * Tokenize HTML entities in a comment.
     *
     * @return void
     */
    public function test_tokenizeHTML_entitiesInComment()
    {
        $this->assertTokenization(
            '<!-- This comment < &lt; & -->',
            array(new HTMLPurifier_Token_Comment(' This comment < &lt; & '))
        );
    }

    /**
     * Tokenize special characters inside an attribute.
     *
     * @return void
     */
    public function test_tokenizeHTML_attributeWithSpecialCharacters()
    {
        $this->assertTokenization(
            '<a href="><>">',
            array(new HTMLPurifier_Token_Empty('a', array('href' => '><>')))
        );
    }

    /**
     * Tokenize a self closing tag with a forward slash in an attribute value.
     *
     * @return void
     */
    public function test_tokenizeHTML_emptyTagWithSlashInAttribute()
    {
        $this->assertTokenization(
            '<param name="src" value="http://example.com/video.wmv" />',
            array(new HTMLPurifier_Token_Empty('param', array('name' => 'src', 'value' => 'http://example.com/video.wmv')))
        );
    }

    /**
     * Tokenize a style tag.
     *
     * @return void
     */
    public function test_tokenizeHTML_style()
    {
        $this->assertTokenization(
            '<style type="text/css"><!--
div {}
--></style>',
            array(
                new HTMLPurifier_Token_Start('style', array('type' => 'text/css')),
                new HTMLPurifier_Token_Text("<!--\ndiv {}\n-->"),
                new HTMLPurifier_Token_End('style'),
            )
        );
    }

    /**
     * Tokenize a malformed tag containing @ and > characters.
     *
     * @return void
     */
    public function test_tokenizeHTML_tagWithAtSignAndExtraGt()
    {
        $this->assertTokenization(
            '<a@>>',
            array(
                new HTMLPurifier_Token_Start('a'),
                new HTMLPurifier_Token_Text('>'),
                new HTMLPurifier_Token_End('a'),
            )
        );
    }

    /**
     * Tokenize the heart emoticon.
     *
     * @return void
     */
    public function test_tokenizeHTML_emoticonHeart()
    {
        $this->assertTokenization(
            '<br /><3<br />',
            array(
                new HTMLPurifier_Token_Empty('br'),
                new HTMLPurifier_Token_Text('<3'),
                new HTMLPurifier_Token_Empty('br'),
            )
        );
    }

    /**
     * Tokenize shifty eyes emoticon.
     *
     * @return void
     */
    public function test_tokenizeHTML_emoticonShiftyEyes()
    {
        $this->assertTokenization(
            '<b><<</b>',
            array(
                new HTMLPurifier_Token_Start('b'),
                new HTMLPurifier_Token_Text('<<'),
                new HTMLPurifier_Token_End('b'),
            )
        );
    }

    /**
     * Tokenize eon1996.
     *
     * @return void
     */
    public function test_tokenizeHTML_eon1996()
    {
        $this->assertTokenization(
            '< <b>test</b>',
            array(
                new HTMLPurifier_Token_Text('< '),
                new HTMLPurifier_Token_Start('b'),
                new HTMLPurifier_Token_Text('test'),
                new HTMLPurifier_Token_End('b'),
            )
        );
    }

    /**
     * Tokenize a body tag inside CDATA.
     *
     * @return void
     */
    public function test_tokenizeHTML_bodyInCDATA()
    {
        $this->assertTokenization(
            '<![CDATA[<body>Foo</body>]]>',
            array(
                new HTMLPurifier_Token_Text('<body>Foo</body>'),
            )
        );
    }

    /**
     * Tokenize a valid HTML segment.
     *
     * @return void
     */
    public function test_tokenizeHTML_()
    {
        $this->assertTokenization(
            '<a><img /></a>',
            array(
                new HTMLPurifier_Token_Start('a'),
                new HTMLPurifier_Token_Empty('img'),
                new HTMLPurifier_Token_End('a'),
            )
        );
    }

    /**
     * Tokenize a HTML conditional comment.
     *
     * @return void
     */
    public function test_tokenizeHTML_ignoreIECondComment()
    {
        $this->assertTokenization(
            '<!--[if IE]>foo<a>bar<!-- baz --><![endif]-->',
            array()
        );
    }

    /**
     * Tokenize an XML processing instruction.
     *
     * @return void
     */
    public function test_tokenizeHTML_removeProcessingInstruction()
    {
        $this->config->set('Core.RemoveProcessingInstructions', true);

        $this->assertTokenization(
            '<?xml blah blah ?>',
            array()
        );
    }

    /**
     * Tokenize plain text with a mixture of new line characters (CR / LF).
     *
     * @return void
     */
    public function test_tokenizeHTML_removeNewline()
    {
        $this->config->set('Core.NormalizeNewlines', true);
        $this->assertTokenization(
            "plain\rtext\r\n",
            array(
                new HTMLPurifier_Token_Text("plain\ntext\n")
            )
        );
    }

    /**
     * Tokenize plain text with a mixture of new line characters (CR / LF).
     *
     * @return void
     */
    public function test_tokenizeHTML_noRemoveNewline()
    {
        $this->config->set('Core.NormalizeNewlines', false);

        $this->assertTokenization(
            "plain\rtext\r\n",
            array(
                new HTMLPurifier_Token_Text("plain\rtext\r\n")
            )
        );
    }

    /**
     * Tokenize a conditional comment.
     *
     * @return void
     */
    public function test_tokenizeHTML_conditionalCommentUngreedy()
    {
        $this->assertTokenization(
            '<!--[if gte mso 9]>a<![endif]-->b<!--[if gte mso 9]>c<![endif]-->',
            array(
                new HTMLPurifier_Token_Text("b")
            )
        );
    }

    /**
     * Tokenize an image tag.
     *
     * @return void
     */
    public function test_tokenizeHTML_imgTag()
    {
        $this->assertTokenization(
            '<img src="img_11775.jpg" alt="[Img #11775]" id="EMBEDDED_IMG_11775" >',
            array(
                new HTMLPurifier_Token_Empty('img',
                    array(
                        'src' => 'img_11775.jpg',
                        'alt' => '[Img #11775]',
                        'id' => 'EMBEDDED_IMG_11775',
                    )
                )
            )
        );
    }

    /**
     * Tokenize a premature closing div tag.
     *
     * @return void
     */
    public function test_tokenizeHTML_prematureDivClose()
    {
        $this->assertTokenization(
            '</div>dont<b>die</b>',
            array(
                new HTMLPurifier_Token_Text('dont'),
                new HTMLPurifier_Token_Start('b'),
                new HTMLPurifier_Token_Text('die'),
                new HTMLPurifier_Token_End('b')
            )
        );
    }

    /**
     * Assert tokenization generates an expected output.
     *
     * @param  string  $input
     * @param  array  $expect
     * @return void
     */
    protected function assertTokenization($input, $expect)
    {
        $lexer = new HTMLPurifier_Lexer_Html5Lex;

        $result = $lexer->tokenizeHTML($input, $this->config, $this->context);

        $t_expect = $expect;
        $this->assertEquals($expect, $result);

        if ($t_expect != $result) {
            $this->printTokens($result);
        }
    }

    /**
     * Print an array of HTMLPurifier_Token's to console.
     *
     * @param  array  $tokens
     * @param  int    $index
     * @return void
     */
    protected function printTokens($tokens, $index = null)
    {
        $string = '<pre>';

        $generator = new HTMLPurifier_Generator(HTMLPurifier_Config::createDefault(), new HTMLPurifier_Context);
        foreach ($tokens as $i => $token) {
            $string .= $this->printToken($generator, $token, $i, $index == $i);
        }

        $string .= '</pre>';

        echo $string;
    }

    /**
     * Convert a HTMLPurifier_Token to a string.
     *
     * @param  HTMLPurifier_Generator  $generator
     * @param  HTMLPurifier_Token      $token
     * @param  int                     $i
     * @param  bool                    $isCursor
     * @return string
     */
    protected function printToken($generator, $token, $i, $isCursor)
    {
        $string = "";
        if ($isCursor) $string .= '[<strong>';
        $string .= "<sup>$i</sup>";
        $string .= $generator->escape($generator->generateFromToken($token));
        if ($isCursor) $string .= '</strong>]';

        return $string;
    }
}
