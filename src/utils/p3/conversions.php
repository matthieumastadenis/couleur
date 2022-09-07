<?php

namespace matthieumastadenis\couleur\utils\p3;

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
use       matthieumastadenis\couleur\utils\xyzD65;

function toCss(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :CssColor {
    return rgb\toCss(... toRgb($red, $green, $blue, $opacity));
}

function toHexRgb(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return rgb\toHexRgb(... toRgb($red, $green, $blue, $opacity));
}

function toHsl(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return rgb\toHsl(... toRgb($red, $green, $blue, $opacity));
}

function toHsv(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return hsl\toHsv(... toHsl($red, $green, $blue, $opacity));
}

function toHwb(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return hsv\toHwb(... toHsv($red, $green, $blue, $opacity));
}

function toLab(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return xyzD50\toLab(... toXyzD50($red, $green, $blue, $opacity));
}

function toLch(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return lab\toLch(... toLab($red, $green, $blue, $opacity));
}

function toLinP3(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return utils\push(
        value : $opacity,
        array : \array_map(
            callback : function (int|float $v) {
                $abs  = \abs($v);
                $sign = ($v < 0)
                    ? -1
                    : 1
                ;

                if ($abs < 0.04045) {
                    return $v / 12.92;
                }

                return (float) (
                    $sign * \pow(($abs + 0.055) / 1.055, 2.4)
                );
            },
            array : [ $red, $green, $blue ],
        ),
    );
}

function toLinProPhoto(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return xyzD50\toLinProPhoto(... toXyzD50($red, $green, $blue, $opacity));
}

function toLinRgb(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return xyzD65\toLinRgb(... toXyzD65($red, $green, $blue, $opacity));
}

function toOkLab(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return xyzD65\toOkLab(... toXyzD65($red, $green, $blue, $opacity));
}

function toOkLch(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return okLab\toOkLch(... toOkLab($red, $green, $blue, $opacity));
}

function toProPhoto(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return linProPhoto\toProPhoto(... toLinProPhoto($red, $green, $blue, $opacity));
}

function toRgb(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return linRgb\toRgb(... toLinRgb($red, $green, $blue, $opacity));
}

function toXyzD50(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return xyzD65\toXyzD50(... toXyzD65($red, $green, $blue, $opacity));
}

function toXyzD65(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 1,
) :array {
    return linP3\toXyzD65(... toLinP3($red, $green, $blue, $opacity));
}
