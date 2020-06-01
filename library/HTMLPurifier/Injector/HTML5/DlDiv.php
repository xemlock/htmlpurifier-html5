<?php

/**
 * Injects special attribute to div start token with information whether the token
 * is a direct child of dl. This is done during MakeWellFormed stage.
 *
 * The value of the attribute is used in {@link HTMLPurifier_ChildDef_HTML5_Div}
 * for determining whether dt and dd should be allowed.
 *
 * This additional attribute will be removed in the ValidateAttributes stage,
 * which is performed as the last step of purification.
 */
class HTMLPurifier_Injector_HTML5_DlDiv extends HTMLPurifier_Injector
{
    public $name = __CLASS__;

    public $needed = array('dl');

    /**
     * @param HTMLPurifier_Token $token
     */
    public function handleElement(&$token)
    {
        if (empty($token->name) || $token->name !== 'div') {
            return;
        }

        /** @var HTMLPurifier_Token[] $stack */
        $stack = $this->currentNesting;
        $parent = is_array($stack) && count($stack) ? $stack[count($stack) - 1] : null;

        if (isset($parent->name) && $parent->name === 'dl') {
            $token->attr['DlDiv'] = true;
        }
    }
}
