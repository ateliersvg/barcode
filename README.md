<h1 align="center">Atelier Barcode</h1>

<p align="center">QR codes, matrix codes, and barcodes as SVG, in pure PHP.</p>

<p align="center">
  <img alt="PHP Version" src="https://img.shields.io/badge/PHP-8.3%2B-5a8dee?labelColor=14141c">
  <img alt="Tests" src="https://img.shields.io/github/actions/workflow/status/ateliersvg/barcode/CI.yml?branch=main&label=Tests&labelColor=14141c&color=5a8dee">
  <img alt="PHPUnit" src="https://img.shields.io/badge/PHPUnit-12-5a8dee?labelColor=14141c">
  <img alt="PHPStan" src="https://img.shields.io/badge/PHPStan-max-5a8dee?labelColor=14141c">
  <img alt="Stable" src="https://img.shields.io/github/v/release/ateliersvg/barcode?label=Stable&labelColor=14141c&color=5a8dee">
  <img alt="License" src="https://img.shields.io/github/license/ateliersvg/barcode?label=License&labelColor=14141c&color=5a8dee">
</p>

Fifteen symbologies, from QR Code and Data Matrix to EAN, UPC, ISBN, GS1, Code 39, Code 93,
Code 128, ITF and Codabar. Each one is a fluent builder whose `render()` returns a string of
SVG markup.

```php
echo QrCode::create('https://ateliersvg.com')->size(240)->render();
```

<p align="center">
  <img src="docs/images/qr-code.svg" width="120" alt="A QR code">
  &nbsp;&nbsp;
  <img src="docs/images/ean-13.svg" width="150" alt="An EAN-13 barcode">
  &nbsp;&nbsp;
  <img src="docs/images/data-matrix.svg" width="100" alt="A Data Matrix symbol">
</p>

No required extensions, no image library, no runtime dependencies. The output drops into an
`<img>`, a `background-image`, an inline `<svg>`, a PDF, or an email. Every symbology is verified
module by module by an extensive test suite.

**[Symbologies](#every-symbology) · [Styling](#styling-and-size) · [PNG and GIF](#png-and-gif) ·
[Raw geometry](#raw-geometry) · [Errors](#error-handling) · [Documentation](#documentation)**

## Installation

```bash
composer require atelier/barcode
```

Requires PHP 8.3 or later. `ext-gd` is needed only for PNG output.

## Quick start

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

Every builder is created with `::create()`, configured by chaining, and finished with
`render()`. See [Getting started](docs/getting-started.md).

## Every symbology

| Symbology | Preview | Kind | Input |
|-----------|:-------:|------|-------|
| [QR Code](docs/codes/qr-code.md) | <img src="docs/images/qr-code.svg" width="70" alt="QR Code example"> | 2D matrix | numeric, alphanumeric, or byte data |
| [Data Matrix](docs/codes/data-matrix.md) | <img src="docs/images/data-matrix.svg" width="70" alt="Data Matrix example"> | 2D matrix | extended ASCII, up to 44 chars |
| [GS1 DataMatrix](docs/codes/gs1-datamatrix.md) | <img src="docs/images/gs1-datamatrix.svg" width="70" alt="GS1 DataMatrix example"> | 2D matrix | GS1 AI pairs, single-region |
| [EAN-13](docs/codes/ean-13.md) | <img src="docs/images/ean-13.svg" width="100" alt="EAN-13 example"> | 1D linear | 12-13 digits |
| [EAN-8](docs/codes/ean-8.md) | <img src="docs/images/ean-8.svg" width="100" alt="EAN-8 example"> | 1D linear | 7-8 digits |
| [UPC-A](docs/codes/upc-a.md) | <img src="docs/images/upc-a.svg" width="100" alt="UPC-A example"> | 1D linear | 11-12 digits |
| [UPC-E](docs/codes/upc-e.md) | <img src="docs/images/upc-e.svg" width="100" alt="UPC-E example"> | 1D linear | 6-8 digits, number system 0 or 1 |
| [ISBN](docs/codes/isbn.md) | <img src="docs/images/isbn.svg" width="100" alt="ISBN example"> | 1D linear | ISBN-10 or ISBN-13 |
| [Code 128](docs/codes/code-128.md) | <img src="docs/images/code-128.svg" width="100" alt="Code 128 example"> | 1D linear | 7-bit ASCII |
| [Code 39](docs/codes/code-39.md) | <img src="docs/images/code-39.svg" width="100" alt="Code 39 example"> | 1D linear | `A-Z 0-9 space - . $ / + %` |
| [Code 93](docs/codes/code-93.md) | <img src="docs/images/code-93.svg" width="100" alt="Code 93 example"> | 1D linear | `A-Z 0-9 space - . $ / + %` |
| [GS1-128](docs/codes/gs1-128.md) | <img src="docs/images/gs1-128.svg" width="100" alt="GS1-128 example"> | 1D linear | GS1 AI pairs |
| [ITF-14](docs/codes/itf-14.md) | <img src="docs/images/itf-14.svg" width="100" alt="ITF-14 example"> | 1D linear | 13-14 digits |
| [Interleaved 2 of 5](docs/codes/interleaved-2-of-5.md) | <img src="docs/images/interleaved-2-of-5.svg" width="100" alt="Interleaved 2 of 5 example"> | 1D linear | even-length digits |
| [Codabar](docs/codes/codabar.md) | <img src="docs/images/codabar.svg" width="100" alt="Codabar example"> | 1D linear | digits, `- $ : / . +`, guards `A-D` |

Each page carries that symbology's options, defaults, bounds, and the exceptions it throws.

## Styling and size

Every builder shares `margin()`, `foreground()`, `background()`, and a size call: `size()` for
matrix codes, `scale()` and `height()` for linear ones.

```php
Ean13::create('4006381333931')
    ->scale(3)
    ->height(80)
    ->foreground('#14141c')
    ->background('transparent')
    ->render();
```

Symbology-specific settings sit alongside them: error correction for QR, a Mod 43 checksum for
Code 39, bearer bars for ITF-14, explicit guards for Codabar. See [Options](docs/options.md).

## PNG and GIF

SVG is the default output. When a bitmap is what the consumer needs, a raster renderer takes the
same geometry the builder already computed.

```php
use Atelier\Barcode\Renderer\PngRenderer;

$png = PngRenderer::render(
    matrix: QrCode::create('https://ateliersvg.com')->matrix(),
    moduleSize: 6,
    margin: 4,
);
```

`PngRenderer` requires `ext-gd`. `GifRenderer` has the same signature and needs nothing at all,
assembling the file byte by byte in PHP. See [Renderers](docs/renderers.md).

## Raw geometry

A builder can return its geometry instead of markup, for composing into a larger document or
rendering with something else entirely. `QrCode` and `DataMatrix` expose `matrix()`, linear
symbologies expose `modules()`.

```php
$grid = QrCode::create('hello')->matrix();   // array of rows of booleans
$bars = Code128::create('hello')->modules(); // bar and space widths
```

## Error handling

Every exception implements `Atelier\Barcode\Exception\CodeExceptionInterface`, so one catch
covers the package.

```php
use Atelier\Barcode\Exception\CodeExceptionInterface;

try {
    echo QrCode::create($payload)->render();
} catch (CodeExceptionInterface $e) {
    // Invalid input, unsupported characters, a missing optional extension,
    // an invalid colour, or output dimensions beyond the safety limits.
}
```

The concrete types are `InvalidCodeException`, `InvalidColorException`, and
`MissingExtensionException`.

## Documentation

- [Installation](docs/installation.md): requirements, and verifying the install.
- [Getting started](docs/getting-started.md): the first symbol, and what to do when it throws.
- [Every symbology](docs/codes/overview.md): compare the fifteen and pick one.
- [Options](docs/options.md): every setting, its default, and its bounds.
- [Renderers](docs/renderers.md): SVG, PNG, and GIF.

The full documentation is published at [ateliersvg.com/barcode](https://ateliersvg.com/barcode/).

## Contributing

Contributions are welcome. Visit the [project on GitHub](https://github.com/ateliersvg/barcode)
to [report a bug](https://github.com/ateliersvg/barcode/issues/new),
[suggest a feature](https://github.com/ateliersvg/barcode/issues/new), or
[open a pull request](https://github.com/ateliersvg/barcode/pulls).

Before submitting code, run:

```bash
composer qa   # PHP-CS-Fixer, PHPStan at level max, and PHPUnit
```

Changes to public behaviour need a test and a documentation update.

## Support

Bug reports, security disclosures, and contribution guidelines are collected at
[ateliersvg.com/support](https://ateliersvg.com/support/).

Atelier is maintained by Simon André. Sharing the package or
[starring it on GitHub](https://github.com/ateliersvg/barcode) helps more than you would think.

## License

Atelier Barcode is released under the [MIT License](LICENSE).
