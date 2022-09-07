<?php

namespace matthieumastadenis\couleur\utils\hsl;

use       matthieumastadenis\couleur\CssColor;
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
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :CssColor {
    return rgb\toCss(... toRgb($hue, $saturation, $lightness, $opacity));
}

function toHexRgb(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    return rgb\toHexRgb(... toRgb($hue, $saturation, $lightness, $opacity));
}

function toHsv(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    $saturation /= 100;
    $lightness  /= 100;
    $value       = $lightness + $saturation * \min($lightness, 1 - $lightness);
    $saturation  = ($value === 0)
        ? 0
        : 200 * (1 - $lightness / $value)
    ;
    
    return [
        $hue,
        $saturation,
        $value * 100,
        $opacity,
    ];
}

function toHwb(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    return hsv\toHwb(... toHsv($hue, $saturation, $lightness, $opacity));
}

function toLab(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    return xyzD50\toLab(... toXyzD50($hue, $saturation, $lightness, $opacity));
}

function toLch(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    return lab\toLch(... toLab($hue, $saturation, $lightness, $opacity));
}

function toLinP3(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    return xyzD65\toLinP3(... toXyzD65($hue, $saturation, $lightness, $opacity));
}

function toLinProPhoto(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    return xyzD50\toLinProPhoto(... toXyzD50($hue, $saturation, $lightness, $opacity));
}

function toLinRgb(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    return rgb\toLinRgb(... toRgb($hue, $saturation, $lightness, $opacity));
}

function toOkLab(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    return xyzD65\toOkLab(... toXyzD65($hue, $saturation, $lightness, $opacity));
}

function toOkLch(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    return okLab\toOkLch(... toOkLab($hue, $saturation, $lightness, $opacity));
}

function toP3(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    return linP3\toP3(... toLinP3($hue, $saturation, $lightness, $opacity));
}

function toProPhoto(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    return linProPhoto\toProPhoto(... toLinProPhoto($hue, $saturation, $lightness, $opacity));
}

function toRgb(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    $precision ??= 0;
    $hue        /= 60;

    if ($hue < 0) {
        $hue = 6 - \fmod(-$hue, 6);
    }
    
    $hue        = \fmod($hue, 6);
    $saturation = \max(0, \min(1, $saturation / 100));
    $lightness  = \max(0, \min(1, $lightness / 100));
    $c          = (1 - \abs((2 * $lightness) - 1)) * $saturation;
    $x          = $c * (1 - \abs(\fmod($hue, 2) - 1));

    if ($hue < 1) {
        $red   = $c;
        $green = $x;
        $blue  = 0;
    } 
    else if ($hue < 2) {
        $red   = $x;
        $green = $c;
        $blue  = 0;
    } 
    else if ($hue < 3) {
        $red   = 0;
        $green = $c;
        $blue  = $x;
    } 
    else if ($hue < 4) {
        $red   = 0;
        $green = $x;
        $blue  = $c;
    } 
    else if ($hue < 5) {
        $red   = $x;
        $green = 0;
        $blue  = $c;
    } 
    else {
        $red   = $c;
        $green = 0;
        $blue  = $x;
    }

    $m       = $lightness - $c / 2;
    $red     = \round(($red   + $m) * 255, $precision);
    $green   = \round(($green + $m) * 255, $precision);
    $blue    = \round(($blue  + $m) * 255, $precision);
    $opacity = \round($opacity * 2.55, $precision);

    return [
        (float) $red,
        (float) $green,
        (float) $blue,
        (float) $opacity,
    ];
}

function toXyzD50(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    return xyzD65\toXyzD50(... toXyzD65($hue, $saturation, $lightness, $opacity));
}

function toXyzD65(
    float $hue        = 0,
    float $saturation = 0,
    float $lightness  = 0,
    float $opacity    = 100,
) :array {
    return linRgb\toXyzD65(... toLinRgb($hue, $saturation, $lightness, $opacity));
}