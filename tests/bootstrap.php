<?php

require_once __DIR__ . '/../vendor/autoload.php';

// PHPUnit >= 6.0 compatibility
if (!class_exists('PHPUnit_Framework_TestSuite') && class_exists('PHPUnit\Framework\TestSuite')) {
    /** @noinspection PhpIgnoredClassAliasDeclaration */
    class_alias('PHPUnit\Framework\TestSuite', 'PHPUnit_Framework_TestSuite');
}

if (!class_exists('PHPUnit_Framework_TestCase') && class_exists('PHPUnit\Framework\TestCase')) {
    /** @noinspection PhpIgnoredClassAliasDeclaration */
    class_alias('PHPUnit\Framework\TestCase', 'PHPUnit_Framework_TestCase');
}

if (!class_exists('PHPUnit_Framework_Error_Error') && class_exists('PHPUnit\Framework\Error\Error')) {
    /** @noinspection PhpIgnoredClassAliasDeclaration */
    class_alias('PHPUnit\Framework\Error\Error', 'PHPUnit_Framework_Error_Error');
}

echo "HTMLPurifier version: ", HTMLPurifier::VERSION, "\n";
echo "libxml version:       ", constant('LIBXML_DOTTED_VERSION'), "\n";
echo "PHP version:          ", PHP_VERSION, "\n";
echo "PHP memory limit:     ", ini_get('memory_limit'), "\n";
echo "\n";

if (getenv('TRAVIS_PHP_VERSION')) {
    // Fixes /home/travis/.travis/functions: line 109:  4773 Segmentation fault (core dumped)
    gc_disable();
}

require_once __DIR__ . '/BaseTestCase.php';
require_once __DIR__ . '/AttrDefTestCase.php';
require_once __DIR__ . '/AttrTransformTestCase.php';
require_once __DIR__ . '/ChildDefTestCase.php';
