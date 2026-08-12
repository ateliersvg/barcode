# GS1 DataMatrix

| Kind | Charset | Capacity | URL | Phone |
|------|---------|----------|-----|-------|
| 2D matrix | GS1 AI data | AI `01`, `10`, `17`, `21`, single-region | No | No |

GS1 DataMatrix uses the same GS1 input contract as `Gs1128`, then renders an ECC200-style
Data Matrix with the initial FNC1 codeword.

## Example

<img src="../images/gs1-datamatrix.svg" width="180">

```php
Gs1DataMatrix::create('(01)09501101530003(17)260728(10)BATCH42')->render();
```

## Usage

```php
use Atelier\Barcode\Gs1DataMatrix;

echo Gs1DataMatrix::create([
    ['01', '09501101530003'],
    ['17', '260728'],
    ['10', 'BATCH42'],
])
    ->size(220)
    ->margin(2)
    ->render();
```

## Options

| Method | Default | Description |
|---|---|---|
| `size(int)` | `220` | SVG width and height in pixels |
| `margin(int)` | `2` | quiet zone, in modules |
| `foreground(string)` | `#000000` | module color |
| `background(string)` | `#ffffff` | background color |

`matrix()` returns the raw module grid. `payload()` returns the encoded GS1 payload and
`elementString()` returns the printable `(AI)value` form.

<img src="../images/gs1-datamatrix-short.svg" alt="A GS1 Data Matrix carrying a single application identifier" width="150">

The same symbol carrying only `(01)`. Each application identifier you drop shrinks the grid, because the element string is what gets encoded.

## Limits

- Supported AIs: `01` GTIN, `17` expiry date, `10` batch/lot, `21` serial.
- Single-region square Data Matrix symbols only, from 10x10 to 26x26.
- Throws when the resulting GS1 payload no longer fits that range.
