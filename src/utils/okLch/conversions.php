<?php

namespace matthieumastadenis\couleur\utils\okLch;

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
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :CssColor {
    return rgb\toCss(... toRgb($lightness, $chroma, $hue, $opacity));
}

function toHexRgb(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return rgb\toHexRgb(... toRgb($lightness, $chroma, $hue, $opacity));
}

function toHsl(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return rgb\toHsl(... toRgb($lightness, $chroma, $hue, $opacity));
}

function toHsv(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return hsl\toHsv(... toHsl($lightness, $chroma, $hue, $opacity));
}

function toHwb(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return hsv\toHwb(... toHsv($lightness, $chroma, $hue, $opacity));
}

function toLab(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return xyzD50\toLab(... toXyzD50($lightness, $chroma, $hue, $opacity));
}

function toLch(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return lab\toLch(... toLab($lightness, $chroma, $hue, $opacity));
}

function toLinP3(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return xyzD65\toLinP3(... toXyzD65($lightness, $chroma, $hue, $opacity));
}

function toLinProPhoto(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return xyzD50\toLinProPhoto(... toXyzD50($lightness, $chroma, $hue, $opacity));
}

function toLinRgb(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return xyzD65\toLinRgb(... toXyzD65($lightness, $chroma, $hue, $opacity));
}

function toOkLab(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return [
		$lightness,
		$chroma * \cos($hue * \pi() / 180),
		$chroma * \sin($hue * \pi() / 180),
        $opacity,
	];
}

function toP3(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return linP3\toP3(... toLinP3($lightness, $chroma, $hue, $opacity));
}

function toProPhoto(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return linProPhoto\toProPhoto(... toLinProPhoto($lightness, $chroma, $hue, $opacity));
}

function toRgb(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return linRgb\toRgb(... toLinRgb($lightness, $chroma, $hue, $opacity));
}

function toXyzD50(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return xyzD65\toXyzD50(... toXyzD65($lightness, $chroma, $hue, $opacity));
}

function toXyzD65(
    float $lightness = 0,
    float $chroma    = 0,
    float $hue       = 0,
    float $opacity   = 100,
) :array {
    return okLab\toXyzD65(... toOkLab($lightness, $chroma, $hue, $opacity));
}