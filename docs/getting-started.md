---
order: 10
---
# Getting Started

`atelier/barcode` turns a string into a scannable symbol. Every symbology is a fluent builder whose `render()` returns SVG markup.

This page assumes the package is installed; see [Installation](installation.md) if it is not.


## A first symbol

```php
use Atelier\Barcode\Ecc;
use Atelier\Barcode\QrCode;

$svg = QrCode::create('https://ateliersvg.com')
    ->ecc(Ecc::Medium)
    ->size(240)
    ->margin(4)
    ->render();

file_put_contents('qr.svg', $svg);
```

A linear barcode is the same shape of call:

```php
use Atelier\Barcode\Code128;

echo Code128::create('ATELIER-2026')->render();
```

## Error handling

Invalid input throws at `create()` time, or when a setter validates its argument. Every exception implements `CodeExceptionInterface`, so one catch covers the package:

```php
use Atelier\Barcode\Exception\CodeExceptionInterface;

try {
    echo QrCode::create($payload)->render();
} catch (CodeExceptionInterface $e) {
    // Invalid input, unsupported characters, a missing extension,
    // an invalid colour, or output beyond the safety limits.
}
```

The concrete types are `InvalidCodeException`, `InvalidColorException`, and `MissingExtensionException`.

## Where to go next

| If you need to | Read |
|---|---|
| pick a symbology | [Every symbology](codes/overview.md) |
| output PNG or GIF instead of SVG | [Renderers](renderers.md) |
| change size, colours, or quiet zone | [Options](options.md) |
