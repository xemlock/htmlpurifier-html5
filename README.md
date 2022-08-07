# HTML5 Definitions for HTML Purifier

[![Build Status](https://github.com/xemlock/htmlpurifier-html5/workflows/build/badge.svg)](https://github.com/xemlock/htmlpurifier-html5/actions?query=workflow/build)
[![Coverage Status](https://coveralls.io/repos/github/xemlock/htmlpurifier-html5/badge.svg?branch=master)](https://coveralls.io/github/xemlock/htmlpurifier-html5?branch=master)
[![Latest Stable Version](https://img.shields.io/packagist/v/xemlock/htmlpurifier-html5.svg)](https://packagist.org/packages/xemlock/htmlpurifier-html5)
[![Total Downloads](https://img.shields.io/packagist/dt/xemlock/htmlpurifier-html5.svg)](https://packagist.org/packages/xemlock/htmlpurifier-html5/stats)
[![License](https://img.shields.io/packagist/l/xemlock/htmlpurifier-html5.svg)](https://packagist.org/packages/xemlock/htmlpurifier-html5)

This library provides HTML5 element definitions for [HTML Purifier](https://github.com/ezyang/htmlpurifier),
compliant with the [WHATWG spec](https://html.spec.whatwg.org/).

It is the most complete HTML5-compliant solution among all based on HTML Purifier. Apart from providing the most extensive set of element definitions, it provides tidy/sanitization rules for transforming the input into a valid HTML5 output.


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
$config->set('URI.SafeIframeRegexp', '%^//www\.youtube\.com/embed/%');
```

## Configuration

Apart from HTML Purifier's built-in [configuration directives](http://htmlpurifier.org/live/configdoc/plain.html), the following new directives are also supported:

* __Attr.AllowedInputTypes__

  Version added: 0.1.12\
  Type: [Lookup](http://htmlpurifier.org/live/configdoc/plain.html#type-lookup) (or null)\
  Default: `null`

  List of allowed input types, chosen from the types defined in the spec. By default, the setting is `null`, meaning there is no restriction on allowed types. Empty array means that no explicit `type` attributes are allowed, effectively making all inputs a text inputs.

* __HTML.Forms__

  Version added: 0.1.12\
  Type: [Boolean](http://htmlpurifier.org/live/configdoc/plain.html#type-bool)\
  Default: `false`

  Whether or not to permit form elements in the user input, regardless of
  [%HTML.Trusted](http://htmlpurifier.org/live/configdoc/plain.html#HTML.Trusted) value.
  Please be very careful when using this functionality, as enabling forms in untrusted
  documents may allow for phishing attacks.

* __HTML.IframeAllowFullscreen__

  Version added: 0.1.11\
  Type: [Boolean](http://htmlpurifier.org/live/configdoc/plain.html#type-bool)\
  Default: `false`

  Whether or not to permit `allowfullscreen` attribute on `iframe` tags. It requires either
  [%HTML.SafeIframe](http://htmlpurifier.org/live/configdoc/plain.html#HTML.SafeIframe) or
  [%HTML.Trusted](http://htmlpurifier.org/live/configdoc/plain.html#HTML.Trusted) to be `true`.

* __HTML.Link__

  Version added: 0.1.12\
  Type: [Boolean](http://htmlpurifier.org/live/configdoc/plain.html#type-bool)\
  Default: `false`

  Permit the `link` tags in the user input, regardless of
  [%HTML.Trusted](http://htmlpurifier.org/live/configdoc/plain.html#HTML.Trusted) value.
  This effectively allows `link` tags without allowing other untrusted elements.

  If enabled, URIs in `link` tags will not be matched against a whitelist specified
  in %URI.SafeLinkRegexp (unless %HTML.SafeIframe is also enabled).

* __HTML.SafeLink__

  Version added: 0.1.12\
  Type: [Boolean](http://htmlpurifier.org/live/configdoc/plain.html#type-bool)\
  Default: `false`

  Whether to permit `link` tags in untrusted documents. This directive must
  be accompanied by a whitelist of permitted URIs via %URI.SafeLinkRegexp,
  otherwise no `link` tags will be allowed.

* __HTML.XHTML__

  Version added: 0.1.12\
  Type: [Boolean](http://htmlpurifier.org/live/configdoc/plain.html#type-bool)\
  Default: `false`

  While deprecated in HTML 4.01 / XHTML 1.0 context, in HTML5 it's used for
  enabling support for namespaced attributes and XML self-closing tags.

  When enabled it causes `xml:lang` attribute to take precedence over `lang`,
  when both attributes are present on the same element.

* __URI.SafeLinkRegexp__

  Version added: 0.1.12\
  Type: [String](http://htmlpurifier.org/live/configdoc/plain.html#type-string)\
  Default: `null`

  A PCRE regular expression that will be matched against a `<link>` URI. This directive
  only has an effect if %HTML.SafeLink is enabled. Here are some example values:
  `%^https?://localhost/%` - Allow localhost URIs

  Use `Attr.AllowedRel` to control permitted link relationship types.

## Supported HTML5 elements

Aside from HTML elements supported originally by HTML Purifier, this library
adds support for the following HTML5 elements:

`<article>`, `<aside>`, `<audio>`, `<bdi>`, `<data>`, `<details>`, `<dialog>`, `<figcaption>`, `<figure>`, `<footer>`, `<header>`, `<hgroup>`, `<main>`, `<mark>`, `<nav>`, `<picture>`, `<progress>`, `<section>`, `<source>`, `<summary>`, `<time>`, `<track>`, `<video>`, `<wbr>`

as well as HTML5 attributes added to existing HTML elements, such as:

`<a>`, `<del>`, `<fieldset>`, `<ins>`, `<script>`


## License

The MIT License (MIT). See the LICENSE file.
