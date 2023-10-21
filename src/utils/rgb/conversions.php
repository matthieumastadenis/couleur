<?php

namespace matthieumastadenis\couleur\utils\rgb;

use       matthieumastadenis\couleur\CssColor;
use       matthieumastadenis\couleur\utils;
use       matthieumastadenis\couleur\utils\hsl;
use       matthieumastadenis\couleur\utils\hsv;
use       matthieumastadenis\couleur\utils\lab;
use       matthieumastadenis\couleur\utils\linP3;
use       matthieumastadenis\couleur\utils\linProPhoto;
use       matthieumastadenis\couleur\utils\linRgb;
use       matthieumastadenis\couleur\utils\okLab;
use       matthieumastadenis\couleur\utils\xyzD50;
use       matthieumastadenis\couleur\utils\xyzD65;

function toCss(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :CssColor {
    return CssColor::fromRgb(
        (int) \round($red), 
        (int) \round($green), 
        (int) \round($blue),
    );
}

function toHexRgb(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {
    return [
        utils\decToHex(\min(255, $red)),
        utils\decToHex(\min(255, $green)),
        utils\decToHex(\min(255, $blue)),
        utils\decToHex(\min(255, $opacity)),
    ];
}

function toHsl(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {
    $red      /= 255;
    $green    /= 255;
    $blue     /= 255;
    $max       = \max($red, $green, $blue);
    $min       = \min($red, $green, $blue);
    $lightness = ($max + $min) / 2;

    if ($max == $min) {
        $hue        = 
        $saturation = 0;
    } 
    else {
        $d          = $max - $min;
        $saturation = ($lightness > 0.5)
            ? $d / (2 - $max - $min)
            : $d / ($max + $min)
        ;

        switch ($max) {
            case $red:
                $hue = ($green - $blue) / $d + ($green < $blue ? 6 : 0);
                break;
            case $green:
                $hue = ($blue - $red) / $d + 2;
                break;
            case $blue:
                $hue = ($red - $green) / $d + 4;
                break;
        }

        $hue /= 6;
    }

    return [
        (float) $hue        * 360, 
        (float) $saturation * 100, 
        (float) $lightness  * 100,
        (float) $opacity    / 2.55,
    ];
}

function toHsv(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {
    return hsl\toHsv(... toHsl($red, $green, $blue, $opacity));
}

function toHwb(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {
    return hsv\toHwb(... toHsv($red, $green, $blue, $opacity));
}

function toLab(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {
    return xyzD50\toLab(... toXyzD50($red, $green, $blue, $opacity));
}

function toLch(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {
    return lab\toLch(... toLab($red, $green, $blue, $opacity));
}

function toLinP3(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {
    return xyzD65\toLinP3(... toXyzD65($red, $green, $blue, $opacity));
}

function toLinProPhoto(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {
    return xyzD50\toLinProPhoto(... toXyzD50($red, $green, $blue, $opacity));
}

function toLinRgb(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {
    return utils\push(
        value : (float) ($opacity / 255),
        array : \array_map(
            callback : function (int|float $v) {
                $v    = (float) ($v / 255);
                $abs  = \abs($v);
                $sign = ($v < 0)
                    ? -1
                    : 1;

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

function toOkLab(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {
    return xyzD65\toOkLab(... toXyzD65($red, $green, $blue, $opacity));
}

function toOkLch(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {
    return okLab\toOkLch(... toOkLab($red, $green, $blue, $opacity));
}

function toP3(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {
    return linP3\toP3(... toLinP3($red, $green, $blue, $opacity));
}

function toProPhoto(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {
    return linProPhoto\toProPhoto(... toLinProPhoto($red, $green, $blue, $opacity));
}

function toXyzD50(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {
    return xyzD65\toXyzD50(... toXyzD65($red, $green, $blue, $opacity));
}

function toXyzD65(
    float $red     = 0,
    float $green   = 0,
    float $blue    = 0,
    float $opacity = 255,
) :array {    
    return linRgb\toXyzD65(... toLinRgb($red, $green, $blue, $opacity));
}
