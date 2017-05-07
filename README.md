# HTML5 Definitions for HTML Purifier

[![Build Status](https://travis-ci.org/xemlock/htmlpurifier-html5.svg?branch=master)](https://travis-ci.org/xemlock/htmlpurifier-html5)

## Installation

```
composer require xemlock/htmlpurifier-html5
```

## Usage

```
$config = HTMLPurifier_HTML5Config::create();
$purifier = new HTMLPurifier($config);
$purifier->purify(...);
```
