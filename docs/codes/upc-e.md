# UPC-E

| Kind | Charset | Capacity | URL | Phone |
|------|---------|----------|-----|-------|
| 1D linear | Digits only | 6-8 digits | No | No* |

Zero-compressed UPC for small packaging. It accepts the 6-digit payload, 7 digits with number
system, or the full 8 digits with check digit. It can also compress a compatible UPC-A value.

## Example

<img src="../images/upc-e.svg" width="180">

```php
UpcE::create('042100')->render();
```

## Usage

```php
use Atelier\Barcode\UpcE;

echo UpcE::fromUpcA('004000002101')
    ->scale(2)
    ->height(72)
    ->render();
```

## Options

| Method | Default | Description |
|---|---|---|
| `scale(int)` | `2` | pixels per module |
| `height(int)` | `72` | bar height in pixels |
| `margin(int)` | `9` | quiet zone, in modules |
| `foreground(string)` | `#000000` | bar color |
| `background(string)` | `#ffffff` | background color |
| `withText(bool)` | `true` | show the human-readable value |

`modules()` returns the raw bar pattern. `value()` returns the UPC-E value, and
`expandedValue()` returns the equivalent UPC-A value.

<img src="../images/upc-e-expanded.svg" alt="The full-length UPC-A barcode that the compressed symbol expands to">

The UPC-A that this symbol expands to, from `expandedValue()`. Same product, same check digit, and about two thirds wider: that difference is the whole point of UPC-E.

## Limits

- Number system must be `0` or `1`.
- Full 8-digit input must carry the correct check digit.
- `fromUpcA()` throws when the UPC-A value is not compressible to UPC-E.

*UPC-E has no phone-number semantics; it is digits-only product identification.*
