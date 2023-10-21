<?php

namespace matthieumastadenis\couleur\utils\lab;

use       matthieumastadenis\couleur\CssColor;
use       matthieumastadenis\couleur\utils;
use       matthieumastadenis\couleur\utils\hsl;
use       matthieumastadenis\couleur\utils\hsv;
use       matthieumastadenis\couleur\utils\linP3;
use       matthieumastadenis\couleur\utils\linProPhoto;
use       matthieumastadenis\couleur\utils\linRgb;
use       matthieumastadenis\couleur\utils\okLab;
use       matthieumastadenis\couleur\utils\rgb;
use       matthieumastadenis\couleur\utils\xyzD50;
use       matthieumastadenis\couleur\utils\xyzD65;

function toCss(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :CssColor {
    return rgb\toCss(... toRgb($lightness, $a, $b, $opacity));
}

function toHexRgb(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return rgb\toHexRgb(... toRgb($lightness, $a, $b, $opacity));
}

function toHsl(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return rgb\toHsl(... toRgb($lightness, $a, $b, $opacity));
}

function toHsv(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return hsl\toHsv(... toHsl($lightness, $a, $b, $opacity));
}

function toHwb(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return hsv\toHwb(... toHsv($lightness, $a, $b, $opacity));
}

function toLch(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    $lab = [ $lightness, $a, $b ];
	$hue = \atan2($lab[2], $lab[1]) * 180 / \pi();

	return [
		$lab[0],
		\sqrt(\pow($lab[1], 2) + \pow($lab[2], 2)),
		($hue >= 0
            ? $hue
            : $hue + 360
        ),
        $opacity,
	];
}

function toLinP3(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return xyzD65\toLinP3(... toXyzD65($lightness, $a, $b, $opacity));
}

function toLinProPhoto(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return xyzD50\toLinProPhoto(... toXyzD50($lightness, $a, $b, $opacity));
}

function toLinRgb(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return xyzD65\toLinRgb(... toXyzD65($lightness, $a, $b, $opacity));
}

function toOkLab(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return xyzD65\toOkLab(... toXyzD65($lightness, $a, $b, $opacity));
}

function toOkLch(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return okLab\toOkLch(... toOkLab($lightness, $a, $b, $opacity));
}

function toP3(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return linP3\toP3(... toLinP3($lightness, $a, $b, $opacity));
}

function toProPhoto(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return linProPhoto\toProPhoto(... toLinProPhoto($lightness, $a, $b, $opacity));
}

function toRgb(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return linRgb\toRgb(... toLinRgb($lightness, $a, $b, $opacity));
}

function toXyzD50(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    $lab  = [ $lightness, $a, $b ];
	$a    = 24389/27;
	$b    = 216/24389;
	$f    = [];
	$f[1] = ($lab[0] + 16) / 116;
	$f[0] = $lab[1] / 500 + $f[1];
	$f[2] = $f[1] - $lab[2] / 200;
	$xyz  = [
		(\pow($f[0], 3) > $b)
            ? \pow($f[0], 3)
            : (116 * $f[0] - 16) / $a,
        ($lab[0] > $a * $b)
            ? \pow(($lab[0] + 16) / 116, 3)
            : $lab[0] / $a,
        (\pow($f[2], 3) > $b)
            ? \pow($f[2], 3)
            : (116 * $f[2] - 16) / $a,
	];

    $d50 = [
        0.3457 / 0.3585,
        1.00000,
        (1.0 - 0.3457 - 0.3585) / 0.3585,
    ];

    return utils\push(
        value : (float) ($opacity / 100),
        array : \array_map(
            fn ($k, $v) => $v * $d50[$k],
            \array_keys($xyz),
            \array_values($xyz),
        ),
    );
}

function toXyzD65(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return xyzD50\toXyzD65(... toXyzD50($lightness, $a, $b, $opacity));
}
