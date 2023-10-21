<?php

namespace matthieumastadenis\couleur\utils\hsv;

use       matthieumastadenis\couleur\CssColor;
use       matthieumastadenis\couleur\utils\hsl;
use       matthieumastadenis\couleur\utils\lab;
use       matthieumastadenis\couleur\utils\linP3;
use       matthieumastadenis\couleur\utils\linProPhoto;
use       matthieumastadenis\couleur\utils\linRgb;
use       matthieumastadenis\couleur\utils\okLab;
use       matthieumastadenis\couleur\utils\rgb;
use       matthieumastadenis\couleur\utils\xyzD50;
use       matthieumastadenis\couleur\utils\xyzD65;

function toCss(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :CssColor {
    return rgb\toCss(... toRgb($hue, $saturation, $value, $opacity));
}

function toHexRgb(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    return rgb\toHexRgb(... toRgb($hue, $saturation, $value, $opacity));
}

function toHsl(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    $saturation /= 100;
    $value      /= 100;
    $lightness   = $value * (1 - $saturation / 2);
    $saturation  = (\in_array($lightness, [ 0, 1 ], true))
        ? 0
        : 100 * ($value - $lightness) / \min($lightness, 1 - $lightness)
    ;

    return [
        $hue,
        $saturation,
        $lightness * 100,
        $opacity,
    ];
}

function toHwb(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    return [
        $hue,
        $value * (100 - $saturation) / 100,
        100 - $value,
        $opacity,
    ];
}

function toLab(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    return xyzD50\toLab(... toXyzD50($hue, $saturation, $value, $opacity));
}

function toLch(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    return lab\toLch(... toLab($hue, $saturation, $value, $opacity));
}

function toLinP3(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    return xyzD65\toLinP3(... toXyzD65($hue, $saturation, $value, $opacity));
}

function toLinProPhoto(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    return xyzD50\toLinProPhoto(... toXyzD50($hue, $saturation, $value, $opacity));
}

function toLinRgb(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    return rgb\toLinRgb(... toRgb($hue, $saturation, $value, $opacity));
}

function toOkLab(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    return xyzD65\toOkLab(... toXyzD65($hue, $saturation, $value, $opacity));
}

function toOkLch(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    return okLab\toOkLch(... toOkLab($hue, $saturation, $value, $opacity));
}

function toP3(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    return linP3\toP3(... toLinP3($hue, $saturation, $value, $opacity));
}

function toProPhoto(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    return linProPhoto\toProPhoto(... toLinProPhoto($hue, $saturation, $value, $opacity));
}

function toRgb(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    return hsl\toRgb(... toHsl($hue, $saturation, $value, $opacity));
}

function toXyzD50(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    return xyzD65\toXyzD50(... toXyzD65($hue, $saturation, $value, $opacity));
}

function toXyzD65(
    float $hue        = 0,
    float $saturation = 0,
    float $value      = 0,
    float $opacity    = 100,
) :array {
    return linRgb\toXyzD65(... toLinRgb($hue, $saturation, $value, $opacity));
}
