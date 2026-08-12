# Code 128

| Kind | Charset | Capacity | URL | Phone |
|------|---------|----------|-----|-------|
| 1D linear | 7-bit ASCII | Unbounded* | Yes | Yes |

Dense linear barcode over the full 7-bit ASCII range. Automatically picks code sets to keep
numeric runs compact, and always appends its own checksum.

## Example

<img src="../images/code-128.svg" width="220">

```php
Code128::create('CODE-128')->render();
```

## Usage

```php
use Atelier\Barcode\Code128;

echo Code128::create('SHIP-4417-XZ')
    ->scale(2)
    ->height(80)
    ->withText(false)
    ->foreground('#08090c')
    ->background('#f4f0e8')
    ->render();
```

## Options

| Method | Default | Description |
|---|---|---|
| `scale(int)` | `2` | pixels per module |
| `height(int)` | `80` | bar height in pixels |
| `margin(int)` | `10` | quiet zone, in modules |
| `foreground(string)` | `#000000` | bar color |
| `background(string)` | `#ffffff` | background color |
| `withText(bool)` | `true` | show the human-readable value under the bars |

`modules()` returns the raw bar pattern instead of SVG.

<img src="../images/code-128-numeric.svg" alt="A fourteen-digit value encoded more compactly than a fourteen-character text value">

Fourteen digits in a narrower symbol than the twelve-character value above. Code set C packs two digits per symbol, and the encoder switches to it on its own.

## Limits

- Any byte above 127 throws `InvalidCodeException` (Code 128 supports 7-bit ASCII only).
- Empty data throws.
- No maximum length enforced by this library; very long data produces a wide barcode.

*Unbounded = no hard cap in this implementation; physical/print width is the real constraint.*

---
[Code 39 →](code-39.md)
