# HTML5 Definitions for HTML Purifier

## Installation

```
composer install xemlock/htmlpurifier-html5
```

## Usage

```
$config = HTMLPurifier_HTML5Config::create();
$purifier = new HTMLPurifier($config);
$purifier->purify(...);
```
