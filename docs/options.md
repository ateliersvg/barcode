---
order: 40
---
# Options

Every builder shares the same vocabulary. What differs between symbologies is which setters exist and what they default to, and each page states its own.

## Sizing

| Setting | Applies to | Default |
|---|---|---|
| `size(int)` | matrix codes | per symbology, `220` or `320` |
| `scale(int)` | linear codes | `2` |
| `height(int)` | linear codes | per symbology, `72` or `80` |
| `margin(int)` | all | per symbology, `2` to `11` |

A matrix code is square, so `size()` sets both dimensions. A linear barcode has a module width and a bar height, so it takes `scale()` and `height()` instead.

## Quiet zone

`margin()` is the empty band around the symbol, counted in modules. It is part of the symbol, not padding: printed too tight, a valid barcode stops scanning.

Defaults differ because the standards differ. EAN-13 reserves 11 modules, a QR code 4.

## Colour

| Setting | Default |
|---|---|
| `foreground(string)` | `#000000` |
| `background(string)` | `#ffffff` |

Both accept `#rgb` or `#rrggbb` and throw `InvalidColorException` otherwise.

Scanners read contrast, not hue. A dark symbol on a light ground works; the reverse does not, and neither does a pair too close in luminance.

## Human-readable text

`withText(bool)` shows or hides the digits printed under a linear barcode. The data is encoded either way; only the fallback for a human reading it aloud changes.

Not every symbology exposes it. EAN-13 has no toggle, Code 93 adds `withChecksumText()` for its two check characters.

## Bar width ratio

`wideRatio(int)` sets how many narrow modules a wide bar is worth, on the symbologies built from two widths: Code 39, Interleaved 2 of 5, and ITF-14. Default `3`, minimum `2`.

A tighter ratio makes a shorter symbol and leaves a scanner less margin to tell the two widths apart.

## Geometry instead of markup

`matrix()` and `modules()` return the module grid rather than SVG, which is what the [renderers](renderers.md) take and what a custom output would need.
