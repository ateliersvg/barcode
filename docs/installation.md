---
order: 5
---
# Installation

Install `atelier/barcode` in a PHP 8.3 or newer application, then render one symbol to confirm Composer can load the package.

## Requirements

PHP 8.3 or newer. No runtime dependencies: SVG and GIF output are pure PHP.

`ext-gd` is needed only by the [PNG renderer](renderers.md). Without it the other two outputs work unchanged, and `PngRenderer` throws `MissingExtensionException` rather than failing further down.

## Install the package

```bash
composer require atelier/barcode
```

## Verify the installation

```php
use Atelier\Barcode\QrCode;

echo QrCode::create('https://ateliersvg.com')->render();
```

Markup starting with `<svg` means the package is loaded and encoding correctly.
