<?php

namespace matthieumastadenis\couleur\utils\xyzD65;

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
use       matthieumastadenis\couleur\utils\xyzD50;

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
    float    $x       = 0,
    float    $y       = 0,
    float    $z       = 0,
    float    $opacity = 1,
) :array {
    return rgb\toHsl(... toRgb($x, $y, $z, $opacity));
}

function toHsv(
    float    $x       = 0,
    float    $y       = 0,
    float    $z       = 0,
    float    $opacity = 1,
) :array {
    return hsl\toHsv(... toHsl($x, $y, $z, $opacity));
}

function toHwb(
    float    $x       = 0,
    float    $y       = 0,
    float    $z       = 0,
    float    $opacity = 1,
) :array {
    return hsv\toHwb(... toHsv($x, $y, $z, $opacity));
}

function toLab(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return xyzD50\toLab(... toXyzD50($x, $y, $z, $opacity));
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
    return utils\push(
        value : $opacity,
        array : utils\multiplyMatrices(
            a : [
                [  2.493496911941425,   -0.9313836179191239,  -0.40271078445071684 ],
                [ -0.8294889695615747,  1.7626640603183463,   0.023624685841943577 ],
                [  0.03584583024378447, -0.07617238926804182, 0.9568845240076872   ],
            ],
            b : [ $x, $y, $z ],
        ),
    );
}

function toLinProPhoto(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return xyzD50\toLinProPhoto(... toXyzD50($x, $y, $z, $opacity));
}

function toLinRgb(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return utils\push(
        value : $opacity,
        array : utils\multiplyMatrices(
            a : [
                [  3.2409699419045226,  -1.537383177570094,   -0.4986107602930034  ],
                [ -0.9692436362808796,   1.8759675015077202,   0.04155505740717559 ],
                [  0.05563007969699366, -0.20397695888897652,  1.0569715142428786  ],
            ],
            b : [ $x, $y, $z ],
        ),
    );
}

function toOkLab(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    $okLab = utils\push(
        value : $opacity * 100,
        array : utils\multiplyMatrices(
            a : [
                [  0.2104542553,  0.7936177850, -0.0040720468 ],
                [  1.9779984951, -2.4285922050,  0.4505937099 ],
                [  0.0259040371,  0.7827717662, -0.8086757660 ],
            ],
            b : \array_map(
                callback : fn ($v) => \pow($v, 1/3),
                array    : utils\multiplyMatrices(
                    a : [
                        [ 0.8190224432164319,   0.3619062562801221,  -0.12887378261216414 ],
                        [ 0.0329836671980271,   0.9292868468965546,   0.03614466816999844 ],
                        [ 0.048177199566046255, 0.26423952494422764,  0.6335478258136937  ],
                    ],
                    b : [ $x, $y, $z ],
                ),
            ),
        ),
    );

    // Multiply Lightness by 100 so it is compatible with CSS OkLab:
    $okLab[0] *= 100;

    return $okLab;
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

function toXyzD50(
    float $x       = 0,
    float $y       = 0,
    float $z       = 0,
    float $opacity = 1,
) :array {
    return utils\push(
        value : $opacity,
        array : utils\multiplyMatrices(
            a : [
                [  1.0479298208405488,    0.022946793341019088,  -0.05019222954313557 ],
                [  0.029627815688159344,  0.990434484573249,     -0.01707382502938514 ],
                [ -0.009243058152591178,  0.015055144896577895,   0.7518742899580008  ],
            ],
            b : [ $x, $y, $z ],
        ),
    );
}
