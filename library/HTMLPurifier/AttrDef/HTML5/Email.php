<?php

/**
 * Validates email address or email address list according to WHATWG HTML5 spec,
 * https://html.spec.whatwg.org/multipage/input.html#valid-e-mail-address
 */
class HTMLPurifier_AttrDef_HTML5_Email extends HTMLPurifier_AttrDef
{
    /**
     * @internal
     */
    const EMAIL_REGEX = '/^
        [a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+
        @
        [a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*
    $/x';

    /**
     * @param string $string
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool|string
     */
    public function validate($string, $config, $context)
    {
        $string = trim($string);
        if ($string === '') {
            return false;
        }

        /** @var HTMLPurifier_Token $currentToken */
        $currentToken = $context->get('CurrentToken', true);
        $multiple = $currentToken instanceof HTMLPurifier_Token_Tag && isset($currentToken->attr['multiple']);

        if ($multiple) {
            // A valid e-mail address list is a set of comma-separated tokens,
            // where each token is itself a valid e-mail address.
            // https://html.spec.whatwg.org/multipage/input.html#valid-e-mail-address-list
            $parts = explode(',', $string);
        } else {
            $parts = array($string);
        }

        $result = array();
        foreach ($parts as $part) {
            $part = trim($part);
            if (preg_match(self::EMAIL_REGEX, $part)) {
                $result[] = $part;
            }
        }
        return $result ? implode(',', $result) : false;
    }
}
