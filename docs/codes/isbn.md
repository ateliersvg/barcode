# ISBN

| Kind | Charset | Capacity | URL | Phone |
|------|---------|----------|-----|-------|
| 1D linear | ISBN digits | 10 or 13 digits | No | No |

Book identifiers, rendered as their EAN-13 "bookland" barcode. Accepts either format:
ISBN-10 is converted to its 978-prefixed EAN-13 equivalent, with hyphens and spaces
stripped automatically.

## Example

<img src="../images/isbn.svg" width="220">

```php
Isbn::create('978-0-201-37962-4')->render();
```

## Usage

```php
use Atelier\Barcode\Isbn;

echo Isbn::create('0-201-37962-7')
    ->scale(2)
    ->height(80)
    ->render();
```

## Options

| Method | Default | Description |
|---|---|---|
| `scale(int)` | `2` | pixels per module |
| `height(int)` | `80` | bar height in pixels |
| `margin(int)` | `11` | quiet zone, in modules |
| `foreground(string)` | `#000000` | bar color |
| `background(string)` | `#ffffff` | background color |

`isbn()` returns the normalized ISBN as given; `ean13()` returns the underlying `Ean13`
instance; `modules()` returns the raw bar pattern instead of SVG.

<img src="../images/isbn-from-isbn-10.svg" alt="An identical barcode produced from the ISBN-10 form of the same book">

The same bars, built from the ISBN-10 `0-201-37962-7`. An ISBN-10 is converted to its 978 EAN-13 form before rendering, so both inputs are one barcode.

## Limits

- After stripping hyphens/spaces, the input must be exactly 10 or 13 characters and pass its
  format's own check-digit validation; otherwise it throws `InvalidCodeException`.
- ISBN-10's check character may be `X`; anything else non-digit throws.
