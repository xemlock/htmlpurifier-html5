<?php

class ChildDefTestCase extends BaseTestCase
{
    /**
     * @var HTMLPurifier_ChildDef
     */
    protected $childDef;

    /**
     * Instance of an HTMLPurifier_Lexer implementation.
     * @type HTMLPurifier_Lexer
     */
    protected $lexer;

    protected function setUp()
    {
        parent::setUp();

        // Use DirectLex for tokenization, as its results are not dependent on libxml
        // version available.
        $this->lexer = new HTMLPurifier_Lexer_DirectLex();

        // nodes-tokens serialization works best in XML mode, because it makes the tree
        // structure unambiguous and clearly visible. When not in XML mode empty elements
        // won't have a closing tag.
        $this->config->set('HTML.XHTML', true);
    }

    /**
     * Asserts children validation result
     *
     * @param string $input
     * @param string $expect
     */
    protected function assertResult($input, $expect = null)
    {
        $expect = func_num_args() > 1 ? $expect : (string) $input;

        /** @var HTMLPurifier_Node[] $input_nodes */
        $input_nodes = HTMLPurifier_Arborize::arborize($this->tokenize($input), $this->config, $this->context)->children;

        /** @var HTMLPurifier_Node[]|bool $result_nodes */
        $result_nodes = $this->childDef->validateChildren($input_nodes, $this->config, $this->context);

        if (is_bool($result_nodes)) {
            $this->assertSame($expect, $result_nodes);
            return;
        }

        $result_tokens = $this->generateTokens($result_nodes);
        $result = $this->generate($result_tokens);

        $this->assertSame($expect, $result);
    }

    /**
     * Tokenize HTML into tokens, uses member variables for common variables
     *
     * @param string $html
     * @return HTMLPurifier_Token[]
     */
    protected function tokenize($html)
    {
        return $this->lexer->tokenizeHTML($html, $this->config, $this->context);
    }

    /**
     * Generate textual HTML from tokens
     *
     * @param HTMLPurifier_Token[] $tokens
     * @return string
     */
    protected function generate($tokens)
    {
        $generator = new HTMLPurifier_Generator($this->config, $this->context);
        return $generator->generateFromTokens($tokens);
    }

    /**
     * Generate tokens from node list
     *
     * @param HTMLPurifier_Node[] $children
     * @return HTMLPurifier_Token[]
     */
    protected function generateTokens($children)
    {
        $dummy = new HTMLPurifier_Node_Element('dummy');
        $dummy->children = $children;
        return HTMLPurifier_Arborize::flatten($dummy, $this->context, $this->config);
    }
}
