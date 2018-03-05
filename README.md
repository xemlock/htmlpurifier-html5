# HTML5 Definitions for HTML Purifier

[![Build Status](https://travis-ci.org/xemlock/htmlpurifier-html5.svg?branch=master)](https://travis-ci.org/xemlock/htmlpurifier-html5)
[![Latest Stable Version](https://img.shields.io/packagist/v/xemlock/htmlpurifier-html5.svg)](https://packagist.org/packages/xemlock/htmlpurifier-html5)
[![Total Downloads](https://img.shields.io/packagist/dt/xemlock/htmlpurifier-html5.svg)](https://packagist.org/packages/xemlock/htmlpurifier-html5)
[![License](https://img.shields.io/packagist/l/xemlock/htmlpurifier-html5.svg)](https://packagist.org/packages/xemlock/htmlpurifier-html5)

This library provides HTML5 element definitions for [HTMLPurifier](http://htmlpurifier.org/).

## Installation

Install with [Composer](https://getcomposer.org/) by running the following command:

```
composer require xemlock/htmlpurifier-html5
```

## Usage

The most basic usage is similar to the original HTML Purifier. Create a HTML5-compatible config
using `HTMLPurifier_HTML5Config::createDefault()` factory method, and then pass it to an `HTMLPurifier` instance:

```php
$config = HTMLPurifier_HTML5Config::createDefault();
$purifier = new HTMLPurifier($config);
$clean_html5 = $purifier->purify($dirty_html5);
```

To modify the config you can either instantiate the config with a configuration array passed to
`HTMLPurifier_HTML5Config::create()`, or by calling `set` method on an already existing config instance.

For example, to allow `IFRAME`s with Youtube videos you can do the following:

```php
$config = HTMLPurifier_HTML5Config::create(array(
  'HTML.SafeIframe' => true,
  'URI.SafeIframeRegexp' => '%^//www\.youtube\.com/embed/%',
));
```

or equivalently:

```php
$config = HTMLPurifier_HTML5Config::createDefault();
$config->set('HTML.SafeIframe', true);
$config->set('URI.SafeIframeRegexp', '#^//www\.youtube\.com/embed/#');
```

## Supported HTML5 elements

Aside from HTML elements supported originally by HTML Purifier, this library
adds support for the following HTML5 elements:

article, aside, audio, details, figcaption, figure, footer, header, hgroup, main, nav, picture, section, source, summary, time, track, video

### Elements not (yet) supported

dialog, menu, menuitem, progress

## License

The MIT License (MIT). See the LICENSE file.
