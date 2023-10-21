<?php

namespace matthieumastadenis\couleur\utils\xyzD50;

use       matthieumastadenis\couleur\CssColor;
use       matthieumastadenis\couleur\utils;
use       matthieumastadenis\couleur\utils\hsl;
use       matthieumastadenis\couleur\utils\hsv;
use       matthieumastadenis\couleur\utils\lab;
use       matthieumastadenis\couleur\utils\linP3;
use       matthieumastadenis\couleur\utils\linProPhoto;
use       matthieumastadenis\couleur\utils\linRgb;
use       matthieumastadenis\couleur\utils\okLab;
use       matthieumastadenis\couleur\utils\rgb;
use       matthieumastadenis\couleur\utils\xyzD65;

function toCss(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :CssColor {
    return rgb\toCss(... toRgb($x, $y, $z, $opacity));
}

function toHexRgb(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return rgb\toHexRgb(... toRgb($x, $y, $z, $opacity));
}

function toHsl(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return rgb\toHsl(... toRgb($x, $y, $z, $opacity));
}

function toHsv(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return hsl\toHsv(... toHsl($x, $y, $z, $opacity));
}

function toHwb(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return hsv\toHwb(... toHsv($x, $y, $z, $opacity));
}

function toLab(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    $xyz = [ $x, $y, $z ];
    $d50 = [
        0.3457 / 0.3585,
        1.00000,
        (1.0 - 0.3457 - 0.3585) / 0.3585,
    ];

    $a = 216/24389;
    $b = 24389/27;

    $xyz = \array_map(
        fn ($k, $v) => $v / $d50[$k],
        \array_keys($xyz),
        \array_values($xyz),
    );

    $f = \array_map(
        fn ($v) => (($v > $a)
            ? \pow($v, 1/3)
            : (($b * $v + 16) / 116)
        ),
        $xyz,
    );

    return [
        (116 * $f[1]) - 16,
         500 * ($f[0] - $f[1]),
         200 * ($f[1] - $f[2]),
         $opacity * 100,
    ];
}

function toLch(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return lab\toLch(... toLab($x, $y, $z, $opacity));
}

function toLinP3(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return xyzD65\toLinP3(... toXyzD65($x, $y, $z, $opacity));
}

function toLinProPhoto(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return utils\push(
        value : $opacity,
        array : utils\multiplyMatrices(
            a : [
                [  1.3457989731028281,  -0.25558010007997534,  -0.05110628506753401 ],
                [ -0.5446224939028347,   1.5082327413132781,    0.02053603239147973 ],
                [  0.0,                  0.0,                   1.2119675456389454  ],
            ],
            b : [
                $x,
                $y,
                $z,
            ],
        ),
    );
}

function toLinRgb(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return xyzD65\toLinRgb(... toXyzD65($x, $y, $z, $opacity));
}

function toOkLab(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return xyzD65\toOkLab(... toXyzD65($x, $y, $z, $opacity));
}

function toOkLch(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return okLab\toOkLch(... toOkLab($x, $y, $z, $opacity));
}

function toP3(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return linP3\toP3(... toLinP3($x, $y, $z, $opacity));
}

function toProPhoto(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return linProPhoto\toProPhoto(... toLinProPhoto($x, $y, $z, $opacity));
}

function toRgb(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return linRgb\toRgb(... toLinRgb($x, $y, $z, $opacity));
}

function toXyzD65(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return utils\push(
        value : $opacity,
        array : utils\multiplyMatrices(
            a : [
                [  0.9554734527042182,   -0.023098536874261423,  0.0632593086610217   ],
                [ -0.028369706963208136,  1.0099954580058226,    0.021041398966943008 ],
                [  0.012314001688319899, -0.020507696433477912,  1.3303659366080753   ],
            ],
            b : [
                $x,
                $y,
                $z,
            ],
        ),
    );
}
