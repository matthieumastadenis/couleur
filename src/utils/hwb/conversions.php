<?php

namespace matthieumastadenis\couleur\utils\hwb;

use       matthieumastadenis\couleur\CssColor;
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
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :CssColor {
    return rgb\toCss(... toRgb($hue, $whiteness, $blackness, $opacity));
}

function toHexRgb(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    return rgb\toHexRgb(... toRgb($hue, $whiteness, $blackness, $opacity));
}

function toHsl(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    return hsv\toHsl(... toHsv($hue, $whiteness, $blackness, $opacity));
}

function toHsv(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    $whiteness /= 100;
    $blackness /= 100;

    $sum = $whiteness + $blackness;

    if ($sum >= 1) {
        return [
            $hue,
            0,
            $whiteness / $sum * 100,
            $opacity,
        ];
    }

    $value      = 1 - $blackness;
    $saturation = ($value === 0)
        ? 0
        : 1 - $whiteness / $value
    ;

    return [
        $hue,
        $saturation * 100,
        $value      * 100,
    ];
}

function toLab(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    return xyzD50\toLab(... toXyzD50($hue, $whiteness, $blackness, $opacity));
}

function toLch(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    return lab\toLch(... toLab($hue, $whiteness, $blackness, $opacity));
}

function toLinP3(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    return xyzD65\toLinP3(... toXyzD65($hue, $whiteness, $blackness, $opacity));
}

function toLinProPhoto(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    return xyzD50\toLinProPhoto(... toXyzD50($hue, $whiteness, $blackness, $opacity));
}

function toLinRgb(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    return rgb\toLinRgb(... toRgb($hue, $whiteness, $blackness, $opacity));
}

function toOkLab(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    return xyzD65\toOkLab(... toXyzD65($hue, $whiteness, $blackness, $opacity));
}

function toOkLch(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    return okLab\toOkLch(... toOkLab($hue, $whiteness, $blackness, $opacity));
}

function toP3(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    return linP3\toP3(... toLinP3($hue, $whiteness, $blackness, $opacity));
}

function toProPhoto(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    return linProPhoto\toProPhoto(... toLinProPhoto($hue, $whiteness, $blackness, $opacity));
}

function toRgb(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    return hsl\toRgb(... toHsl($hue, $whiteness, $blackness, $opacity));
}

function toXyzD50(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    return xyzD65\toXyzD50(... toXyzD65($hue, $whiteness, $blackness, $opacity));
}

function toXyzD65(
    float $hue       = 0,
    float $whiteness = 0,
    float $blackness = 0,
    float $opacity   = 100,
) :array {
    return linRgb\toXyzD65(... toLinRgb($hue, $whiteness, $blackness, $opacity));
}
