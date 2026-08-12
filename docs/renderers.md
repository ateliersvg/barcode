---
order: 30
---
# Renderers

`render()` returns SVG. Two other renderers turn the same symbol into a bitmap, and both take the module matrix rather than the markup.

| Output | How | Requires |
|---|---|---|
| SVG | `render()` on any builder | nothing |
| GIF | `GifRenderer::render()` | nothing, assembled byte by byte in PHP |
| PNG | `PngRenderer::render()` | `ext-gd` |

## SVG

The default, and the only one that scales without loss. A symbol renders as rectangles aligned on the module grid, so it stays crisp at any size.

```php
echo QrCode::create('https://ateliersvg.com')->render();
```

## The module matrix

Both bitmap renderers take a grid of booleans, where `true` is a foreground module. Every builder exposes it:

```php
$matrix = QrCode::create('https://ateliersvg.com')->matrix();
$modules = Code128::create('ATELIER-2026')->modules();
```

`matrix()` returns a two-dimensional grid for matrix codes. `modules()` returns the bar pattern for linear ones.

## GIF

Pure PHP: the 1-bit image and its LZW-compressed data are assembled byte by byte, so no extension is involved.

```php
use Atelier\Barcode\Renderer\GifRenderer;

$gif = GifRenderer::render(
    matrix: QrCode::create('https://ateliersvg.com')->matrix(),
    moduleSize: 6,
    margin: 4,
);

file_put_contents('qr.gif', $gif);
```

## PNG

Same arguments, and it needs `ext-gd`. Without the extension it throws `MissingExtensionException` rather than failing further down.

```php
use Atelier\Barcode\Renderer\PngRenderer;

$png = PngRenderer::render(
    matrix: QrCode::create('https://ateliersvg.com')->matrix(),
    moduleSize: 6,
    margin: 4,
    foreground: '#08090c',
    background: '#ffffff',
);
```

## Limits

Both bitmap renderers cap the rendered area at 40 megapixels and throw beyond it. A module size large enough to exceed that is a mistake, not a use case.
