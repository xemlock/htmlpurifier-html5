<?php

/**
 * Experimental HTML5-compliant parser using masterminds/html5 library.
 */
class HTMLPurifier_Lexer_HTML5 extends HTMLPurifier_Lexer_DOMLex
{
    /**
     * @throws HTMLPurifier_Exception
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        if (!class_exists('\Masterminds\HTML5')) {
            throw new HTMLPurifier_Exception('Cannot instantiate HTML5 lexer. \Masterminds\HTML5 class is not available');
        }
        parent::__construct();
    }

    /**
     * Transforms an HTML string into tokens.
     *
     * @param  string                $html
     * @param  HTMLPurifier_Config   $config
     * @param  HTMLPurifier_Context  $context
     * @return HTMLPurifier_Token[]
     */
    public function tokenizeHTML($html, $config, $context)
    {
        $html = $this->normalize($html, $config, $context);
        $html = $this->armor($html, $config);

        // masterminds/html5 requires <html>, <head> and <body> tags
        $html = $this->wrapHTML($html, $config, $context, false);

        // Parse the document. $dom is a DOMDocument.
        $html5 = new \Masterminds\HTML5(array('disable_html_ns' => true));
        $doc = $html5->loadHTML($html);

        $body = $doc->getElementsByTagName('html')->item(0)  // <html>
                    ->getElementsByTagName('body')->item(0); // <body>

        $tokens = array();
        $this->tokenizeDOM($body, $tokens, $config);

        return $tokens;
    }

    /**
     * Attempt to armor stray angled brackets that cannot possibly
     * form tags and thus are probably being used as emoticons
     *
     * @param  string               $html
     * @param  HTMLPurifier_Config  $config
     * @return string
     */
    protected function armor($html, HTMLPurifier_Config $config)
    {
        if ($config->get('Core.AggressivelyFixLt')) {
            $char = '[^a-z!\/]';
            $comment = "/<!--(.*?)(-->|\z)/is";
            $html = preg_replace_callback($comment, array($this, 'callbackArmorCommentEntities'), $html);

            do {
                $old = $html;
                $html = preg_replace("/<($char)/i", '&lt;\\1', $html);
            } while ($html !== $old);

            $html = preg_replace_callback($comment, array($this, 'callbackUndoCommentSubst'), $html); // fix comments
        }

        return $html;
    }
}
