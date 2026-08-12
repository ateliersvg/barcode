# ITF-14

| Kind | Charset | Capacity | URL | Phone |
|------|---------|----------|-----|-------|
| 1D linear | Digits only | 13-14 digits | No | No* |

Logistics barcode for GTIN-14 shipping containers. It is built on Interleaved 2 of 5 and
renders bearer bars by default.

## Example

<img src="../images/itf-14.svg" width="240">

```php
Itf14::create('1001234567890')->render();
```

## Usage

```php
use Atelier\Barcode\Itf14;

echo Itf14::create('1001234567890')
    ->wideRatio(3)
    ->withBearerBars(true)
    ->scale(2)
    ->height(80)
    ->render();
```

## Options

| Method | Default | Description |
|---|---|---|
| `scale(int)` | `2` | pixels per module |
| `height(int)` | `80` | bar height in pixels |
| `margin(int)` | `10` | quiet zone, in modules |
| `wideRatio(int)` | `3` | wide bar/space ratio, from 2 to 10 |
| `withBearerBars(bool)` | `true` | draw the ITF-14 bearer frame |
| `foreground(string)` | `#000000` | bar color |
| `background(string)` | `#ffffff` | background color |
| `withText(bool)` | `true` | show the human-readable value |

`modules()` returns the raw ITF bar pattern. `value()` returns the full 14-digit GTIN.

<img src="../images/itf-14-no-bearer-bars.svg" alt="The same GTIN without the heavy frame around the bars">

The same GTIN with `withBearerBars(false)`. The frame is on by default because it is what stops a scanner from reading a partial symbol on a flexing carton.

## Limits

- Exactly 13 or 14 digits.
- If 14 digits are given, the 14th must be the correct check digit.

*ITF-14 has no phone-number semantics; it is package identification.*
