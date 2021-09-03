<?php

/**
 * Subresource Integrity metadata
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/Security/Subresource_Integrity
 * @see https://w3c.github.io/webappsec-subresource-integrity/#the-integrity-attribute
 * @see https://github.com/validator/validator/blob/master/src/nu/validator/datatype/IntegrityMetadata.java
 */
class HTMLPurifier_AttrDef_HTML5_IntegrityMetadata extends HTMLPurifier_AttrDef
{
    /**
     * @param string $value
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool|string
     */
    public function validate($value, $config, $context)
    {
        // An integrity value may contain multiple hashes separated by whitespace.
        $hashes = preg_split('/\s+/', $value);
        $valid = array();

        foreach ($hashes as $hash) {
            if (strpos($hash, '-') === false) {
                continue;
            }

            list($algo, $digest) = explode('-', $hash, 2);

            if (!in_array($algo, array('sha256', 'sha384', 'sha512'), true)) {
                // Values must start with sha256- or sha384- or sha512-
                continue;
            }

            if (!preg_match('/^[+\/0-9A-Za-z]+[=]{0,3}$/', $digest)) {
                // Invalid base64-value (characters are not in the base64-value grammar).
                continue;
            }

            // Strip padding
            $digest = rtrim($digest, '=');

            // Strip 'sha' prefix, to get expected bit length of the digest
            // In Base64 1 char encodes 6 bits, i.e. 512 bits (sha512 digest) require 86 characters
            $len = (int) ceil(substr($algo, 3) / 6);
            if (strlen($digest) !== $len) {
                continue;
            }

            // Add padding
            if (strlen($digest) % 4) {
                $digest .= str_repeat('=', 4 - strlen($digest) % 4);
            }

            $valid[] = $algo . '-' . $digest;
        }

        if (empty($valid)) {
            return false;
        }

        return implode(' ', $valid);
    }
}
