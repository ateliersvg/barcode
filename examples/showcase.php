<?php

declare(strict_types=1);

/*
 * Renders at least two examples per code type and writes a self-contained
 * gallery to examples/output/index.html (the showroom).
 *
 * Run: php examples/showcase.php
 */

use Atelier\Barcode\Codabar;
use Atelier\Barcode\Code128;
use Atelier\Barcode\Code39;
use Atelier\Barcode\Code93;
use Atelier\Barcode\DataMatrix;
use Atelier\Barcode\Ean13;
use Atelier\Barcode\Ean8;
use Atelier\Barcode\Ecc;
use Atelier\Barcode\Gs1128;
use Atelier\Barcode\Gs1DataMatrix;
use Atelier\Barcode\Interleaved2Of5;
use Atelier\Barcode\Isbn;
use Atelier\Barcode\Itf14;
use Atelier\Barcode\QrCode;
use Atelier\Barcode\UpcA;
use Atelier\Barcode\UpcE;

require __DIR__.'/../vendor/autoload.php';

/** @var array<string, list<array{label: string, snippet: string, svg: string}>> $groups */
$groups = [
    'QR Code' => [
        [
            'label' => 'URL, quartile correction',
            'snippet' => "QrCode::create('https://ateliersvg.com')\n    ->ecc(Ecc::Quartile)->size(220)->render();",
            'svg' => QrCode::create('https://ateliersvg.com')->ecc(Ecc::Quartile)->size(220)->render(),
        ],
        [
            'label' => 'Themed, high correction',
            'snippet' => "QrCode::create('ATELIER/CODE')\n    ->ecc(Ecc::High)->size(220)\n    ->foreground('oklch(0.72 0.17 265)')\n    ->background('#0d0d12')->render();",
            'svg' => QrCode::create('ATELIER/CODE')->ecc(Ecc::High)->size(220)->foreground('oklch(0.72 0.17 265)')->background('#0d0d12')->render(),
        ],
        [
            'label' => 'Wi-Fi join payload',
            'snippet' => "QrCode::create('WIFI:S:Atelier;T:WPA2;P:opensesame;;')\n    ->ecc(Ecc::Medium)->size(220)->render();",
            'svg' => QrCode::create('WIFI:S:Atelier;T:WPA2;P:opensesame;;')->ecc(Ecc::Medium)->size(220)->render(),
        ],
    ],
    'Data Matrix' => [
        [
            'label' => 'Compact product token',
            'snippet' => "DataMatrix::create('ATELIER-2026')\n    ->size(220)->render();",
            'svg' => DataMatrix::create('ATELIER-2026')->size(220)->render(),
        ],
        [
            'label' => 'Themed batch id',
            'snippet' => "DataMatrix::create('BATCH-0042-A')\n    ->size(220)\n    ->foreground('oklch(0.72 0.18 180)')\n    ->background('#0d0d12')->render();",
            'svg' => DataMatrix::create('BATCH-0042-A')->size(220)->foreground('oklch(0.72 0.18 180)')->background('#0d0d12')->render(),
        ],
    ],
    'Code 39' => [
        [
            'label' => 'Inventory label',
            'snippet' => "Code39::create('ATELIER-39')\n    ->scale(2)->height(70)->render();",
            'svg' => Code39::create('ATELIER-39')->scale(2)->height(70)->render(),
        ],
        [
            'label' => 'Mod 43 checksum',
            'snippet' => "Code39::create('BIN 42')\n    ->withChecksum(true)->scale(2)->height(70)->render();",
            'svg' => Code39::create('BIN 42')->withChecksum(true)->scale(2)->height(70)->render(),
        ],
    ],
    'Code 93' => [
        [
            'label' => 'Dense inventory label',
            'snippet' => "Code93::create('ATELIER-93')\n    ->scale(2)->height(70)->render();",
            'svg' => Code93::create('ATELIER-93')->scale(2)->height(70)->render(),
        ],
        [
            'label' => 'Caption includes checks',
            'snippet' => "Code93::create('CODE93')\n    ->withChecksumText(true)\n    ->scale(2)->height(70)->render();",
            'svg' => Code93::create('CODE93')->withChecksumText(true)->scale(2)->height(70)->render(),
        ],
    ],
    'Codabar' => [
        [
            'label' => 'Explicit start and stop guards',
            'snippet' => "Codabar::create('A12345B')\n    ->scale(2)->height(70)->render();",
            'svg' => Codabar::create('A12345B')->scale(2)->height(70)->render(),
        ],
        [
            'label' => 'Payload with guard builder',
            'snippet' => "Codabar::withGuards('240728', 'C', 'D')\n    ->scale(2)->height(70)->render();",
            'svg' => Codabar::withGuards('240728', 'C', 'D')->scale(2)->height(70)->render(),
        ],
    ],
    'Code 128' => [
        [
            'label' => 'SKU with caption',
            'snippet' => "Code128::create('ATELIER-2026')\n    ->scale(2)->height(70)->render();",
            'svg' => Code128::create('ATELIER-2026')->scale(2)->height(70)->render(),
        ],
        [
            'label' => 'Themed, no caption',
            'snippet' => "Code128::create('SHIP-4417-XZ')\n    ->scale(2)->height(70)->withText(false)\n    ->foreground('oklch(0.78 0.15 150)')\n    ->background('#0d0d12')->render();",
            'svg' => Code128::create('SHIP-4417-XZ')->scale(2)->height(70)->withText(false)->foreground('oklch(0.78 0.15 150)')->background('#0d0d12')->render(),
        ],
    ],
    'EAN-13' => [
        [
            'label' => 'Retail product (check digit computed)',
            'snippet' => "Ean13::create('590123412345')\n    ->scale(2)->height(70)->render();",
            'svg' => Ean13::create('590123412345')->scale(2)->height(70)->render(),
        ],
        [
            'label' => 'ISBN-style prefix',
            'snippet' => "Ean13::create('978020137962')\n    ->scale(2)->height(70)->render();",
            'svg' => Ean13::create('978020137962')->scale(2)->height(70)->render(),
        ],
    ],
    'EAN-8' => [
        [
            'label' => 'Small retail package',
            'snippet' => "Ean8::create('5512345')\n    ->scale(2)->height(70)->render();",
            'svg' => Ean8::create('5512345')->scale(2)->height(70)->render(),
        ],
        [
            'label' => 'Themed, no caption',
            'snippet' => "Ean8::create('9638507')\n    ->scale(3)->height(70)->withText(false)\n    ->foreground('oklch(0.22 0.14 32)')\n    ->background('#fff4d7')->render();",
            'svg' => Ean8::create('9638507')->scale(3)->height(70)->withText(false)->foreground('oklch(0.22 0.14 32)')->background('#fff4d7')->render(),
        ],
    ],
    'UPC-A' => [
        [
            'label' => 'North American retail code',
            'snippet' => "UpcA::create('03600029145')\n    ->scale(2)->height(70)->render();",
            'svg' => UpcA::create('03600029145')->scale(2)->height(70)->render(),
        ],
        [
            'label' => 'Check digit validated',
            'snippet' => "UpcA::create('012345678905')\n    ->scale(2)->height(70)->render();",
            'svg' => UpcA::create('012345678905')->scale(2)->height(70)->render(),
        ],
    ],
    'UPC-E' => [
        [
            'label' => 'Compressed UPC payload',
            'snippet' => "UpcE::create('042100')\n    ->scale(2)->height(70)->render();",
            'svg' => UpcE::create('042100')->scale(2)->height(70)->render(),
        ],
        [
            'label' => 'Compressed from UPC-A',
            'snippet' => "UpcE::fromUpcA('004000002101')\n    ->scale(2)->height(70)->render();",
            'svg' => UpcE::fromUpcA('004000002101')->scale(2)->height(70)->render(),
        ],
    ],
    'Interleaved 2 of 5' => [
        [
            'label' => 'Warehouse numeric run',
            'snippet' => "Interleaved2Of5::create('1234567890')\n    ->wideRatio(3)->scale(2)->height(70)->render();",
            'svg' => Interleaved2Of5::create('1234567890')->wideRatio(3)->scale(2)->height(70)->render(),
        ],
        [
            'label' => 'Dense variant',
            'snippet' => "Interleaved2Of5::create('240728001122')\n    ->wideRatio(2)->scale(2)->height(70)->render();",
            'svg' => Interleaved2Of5::create('240728001122')->wideRatio(2)->scale(2)->height(70)->render(),
        ],
    ],
    'ITF-14' => [
        [
            'label' => 'Shipping container GTIN',
            'snippet' => "Itf14::create('1001234567890')\n    ->scale(2)->height(70)->render();",
            'svg' => Itf14::create('1001234567890')->scale(2)->height(70)->render(),
        ],
        [
            'label' => 'No bearer frame',
            'snippet' => "Itf14::create('3001234567890')\n    ->withBearerBars(false)\n    ->scale(2)->height(70)->render();",
            'svg' => Itf14::create('3001234567890')->withBearerBars(false)->scale(2)->height(70)->render(),
        ],
    ],
    'GS1-128' => [
        [
            'label' => 'GTIN, expiry, batch',
            'snippet' => "Gs1128::create('(01)09501101530003(17)260728(10)BATCH42')\n    ->scale(2)->height(70)->render();",
            'svg' => Gs1128::create('(01)09501101530003(17)260728(10)BATCH42')->scale(2)->height(70)->render(),
        ],
        [
            'label' => 'Ordered AI pairs',
            'snippet' => "Gs1128::create([['01', '09501101530003'], ['21', 'SERIAL9']])\n    ->scale(2)->height(70)->render();",
            'svg' => Gs1128::create([['01', '09501101530003'], ['21', 'SERIAL9']])->scale(2)->height(70)->render(),
        ],
    ],
    'GS1 DataMatrix' => [
        [
            'label' => 'GTIN, expiry, batch',
            'snippet' => "Gs1DataMatrix::create('(01)09501101530003(17)260728(10)BATCH42')\n    ->size(220)->render();",
            'svg' => Gs1DataMatrix::create('(01)09501101530003(17)260728(10)BATCH42')->size(220)->render(),
        ],
        [
            'label' => 'Themed serial',
            'snippet' => "Gs1DataMatrix::create([['01', '09501101530003'], ['21', 'SERIAL9']])\n    ->size(220)\n    ->foreground('oklch(0.74 0.16 210)')\n    ->background('#101418')->render();",
            'svg' => Gs1DataMatrix::create([['01', '09501101530003'], ['21', 'SERIAL9']])->size(220)->foreground('oklch(0.74 0.16 210)')->background('#101418')->render(),
        ],
    ],
    'ISBN' => [
        [
            'label' => 'ISBN-10 converted to bookland EAN',
            'snippet' => "Isbn::create('0-201-37962-7')\n    ->scale(2)->height(70)->render();",
            'svg' => Isbn::create('0-201-37962-7')->scale(2)->height(70)->render(),
        ],
        [
            'label' => 'ISBN-13',
            'snippet' => "Isbn::create('978-0-201-37962-4')\n    ->scale(2)->height(70)->render();",
            'svg' => Isbn::create('978-0-201-37962-4')->scale(2)->height(70)->render(),
        ],
    ],
];

$outDir = __DIR__.'/output';
if (!is_dir($outDir) && !mkdir($outDir, 0o755, true) && !is_dir($outDir)) {
    throw new RuntimeException(sprintf('Could not create output directory: %s', $outDir));
}

$sections = '';
$count = 0;
foreach ($groups as $type => $items) {
    $cards = '';
    foreach ($items as $i => $item) {
        $slug = strtolower((string) preg_replace('/[^a-z0-9]+/i', '-', $type)).'-'.($i + 1);
        file_put_contents($outDir.'/'.$slug.'.svg', $item['svg']);
        ++$count;

        $cards .= '<figure class="card">'
            .'<div class="media">'.$item['svg'].'</div>'
            .'<figcaption>'
            .'<span class="label">'.htmlspecialchars($item['label'], ENT_QUOTES).'</span>'
            .'<pre class="snippet"><code>'.htmlspecialchars($item['snippet'], ENT_QUOTES).'</code></pre>'
            .'</figcaption>'
            .'</figure>';
    }

    $sections .= '<section class="group">'
        .'<h2>'.htmlspecialchars($type, ENT_QUOTES).'</h2>'
        .'<div class="grid">'.$cards.'</div>'
        .'</section>';
}

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Atelier Barcode - Showroom</title>
<style>
  *,*::before,*::after{box-sizing:border-box}
  body{
    margin:0;background:#0b0b0d;color:#f2f2f4;
    font-family:"Inter",system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;
    -webkit-font-smoothing:antialiased;
    padding:clamp(32px,6vw,80px) clamp(20px,5vw,72px);
  }
  header{max-width:1200px;margin:0 auto clamp(32px,5vw,64px)}
  .eyebrow{
    font-family:ui-monospace,"SF Mono",Menlo,monospace;
    font-size:12px;letter-spacing:.24em;text-transform:uppercase;color:#7c7c86;margin:0 0 12px;
  }
  h1{margin:0;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:600;letter-spacing:-.02em}
  header p{margin:14px 0 0;color:#9a9aa4;max-width:60ch;line-height:1.5}
  main{max-width:1200px;margin:0 auto;display:flex;flex-direction:column;gap:clamp(40px,6vw,72px)}
  .group h2{
    margin:0 0 20px;font-size:.8rem;font-weight:600;letter-spacing:.16em;text-transform:uppercase;color:#c7c7cf;
    padding-bottom:12px;border-bottom:1px solid rgba(255,255,255,.08);
  }
  .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px}
  .card{
    background:rgba(255,255,255,.03);border-radius:16px;overflow:hidden;
    display:flex;flex-direction:column;
  }
  .media{
    background:#f5f2ea;padding:24px;display:flex;align-items:center;justify-content:center;min-height:180px;
  }
  .media svg{max-width:100%;height:auto;max-height:220px;display:block}
  figcaption{padding:16px 18px 18px;display:flex;flex-direction:column;gap:10px}
  .label{font-size:.92rem;font-weight:600;color:#ededf2}
  .snippet{
    margin:0;background:#08080a;border-radius:10px;padding:12px 14px;overflow-x:auto;
    font-family:ui-monospace,"SF Mono",Menlo,monospace;font-size:.72rem;line-height:1.5;color:#a7b6c4;
  }
  .snippet code{white-space:pre}
  footer{max-width:1200px;margin:clamp(40px,6vw,72px) auto 0;color:#6b6b74;font-size:.82rem}
  footer code{font-family:ui-monospace,Menlo,monospace;color:#9a9aa4}
</style>
</head>
<body>
<header>
  <p class="eyebrow">atelier/barcode · showroom</p>
  <h1>QR codes, matrix codes, and barcodes as SVG</h1>
  <p>Every symbol below is pure-PHP SVG output from <code>atelier/barcode</code>. Two or more examples per type, rendered by <code>examples/showcase.php</code>.</p>
</header>
<main>
$sections
</main>
<footer>Regenerate with <code>php examples/showcase.php</code>. Individual SVGs are written alongside this page in <code>examples/output/</code>.</footer>
</body>
</html>

HTML;

$indexPath = $outDir.'/index.html';
file_put_contents($indexPath, $html);

printf("Rendered %d examples across %d types.\n", $count, count($groups));
printf("Showroom: %s\n", $indexPath);
