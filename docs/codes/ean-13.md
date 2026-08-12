# EAN-13

| Kind | Charset | Capacity | URL | Phone |
|------|---------|----------|-----|-------|
| 1D linear | Digits only | 12-13 digits | No | No* |

The retail barcode printed on nearly every packaged product worldwide. Give it 12 digits and
the check digit is computed for you; give it a full 13 and the check digit is validated.

## Example

<img src="../images/ean-13.svg" width="220">

```php
Ean13::create('590123412345')->render();
```

## Usage

```php
use Atelier\Barcode\Ean13;

echo Ean13::create('590123412345')
    ->scale(2)
    ->height(80)
    ->foreground('#08090c')
    ->background('#f4f0e8')
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

`modules()` returns the raw bar pattern instead of SVG. `value()` returns the full 13-digit
code, including whichever check digit was computed or validated.

<img src="../images/ean-13-quiet-zone.svg" alt="The same barcode surrounded by a wide light margin on an opaque background">

The same code at `margin(30)` on an opaque background, against the default of `11`. The quiet zone is part of the symbol, not padding: printed too tight, a valid barcode stops scanning.

## Limits

- Exactly 12 or 13 digits, nothing else: throws `InvalidCodeException` otherwise.
- If 13 digits are given, the 13th must be the correct check digit or it throws.

*A 12-digit numeric phone number would technically encode, but EAN-13 has no concept of a
phone number; treat it as digits-only, not a phone format.*
