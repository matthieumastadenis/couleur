<?php

namespace matthieumastadenis\couleur\utils\okLab;

use       matthieumastadenis\couleur\CssColor;
use       matthieumastadenis\couleur\utils;
use       matthieumastadenis\couleur\utils\hsl;
use       matthieumastadenis\couleur\utils\hsv;
use       matthieumastadenis\couleur\utils\lab;
use       matthieumastadenis\couleur\utils\linP3;
use       matthieumastadenis\couleur\utils\linProPhoto;
use       matthieumastadenis\couleur\utils\linRgb;
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

function toLab(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return xyzD50\toLab(... toXyzD50($lightness, $a, $b, $opacity));
}

function toLch(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    return lab\toLch(... toLab($lightness, $a, $b, $opacity));
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

function toOkLch(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    $hue = \atan2($b, $a) * 180 / \pi();

    return [
        $lightness,
        \sqrt($a ** 2 + $b ** 2),
        ($hue >= 0)
            ? $hue
            : $hue + 360,
        $opacity,
    ];
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
    return xyzD65\toXyzD50(... toXyzD65($lightness, $a, $b, $opacity));
}

function toXyzD65(
    float $lightness = 0,
    float $a         = 0,
    float $b         = 0,
    float $opacity   = 100,
) :array {
    // Divide $lightness by 100 to convert from CSS OkLab:
    $lightness /= 100;

    return utils\push(
        value : $opacity / 100,
        array : utils\multiplyMatrices(
            a : [
                	[  1.2268798733741557,  -0.5578149965554813,  0.28139105017721583 ],
                	[ -0.04057576262431372,  1.1122868293970594, -0.07171106666151701 ],
                	[ -0.07637294974672142, -0.4214933239627914,  1.5869240244272418  ],
            ],
            b : \array_map(
                callback : fn ($v) => $v ** 3,
                array    : utils\multiplyMatrices(
                    a : [
                            [ 0.99999999845051981432,  0.39633779217376785678,   0.21580375806075880339  ],
                            [ 1.0000000088817607767,  -0.1055613423236563494,   -0.063854174771705903402 ],
                            [ 1.0000000546724109177,  -0.089484182094965759684, -1.2914855378640917399   ],
                    ],
                    b : [ $lightness, $a, $b ],
                ),
            ),
        ),
    );
}
