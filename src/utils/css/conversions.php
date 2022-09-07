<?php

namespace matthieumastadenis\couleur\utils\css;

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

function toHexRgb(
    CssColor|\Stringable|string $color,
) :array {
    return rgb\toHexRgb(... toRgb($color));
}

function toHsl(
    CssColor|\Stringable|string $color,
) :array {
    return rgb\toHsl(... toRgb($color));
}

function toHsv(
    CssColor|\Stringable|string $color,
) :array {
    return hsl\toHsv(... toHsl($color));
}

function toHwb(
    CssColor|\Stringable|string $color,
) :array {
    return hsv\toHwb(... toHsv($color));
}

function toLab(
    CssColor|\Stringable|string $color,
) :array {
    return xyzD50\toLab(... toXyzD50($color));
}

function toLch(
    CssColor|\Stringable|string $color,
) :array {
    return lab\toLch(... toLab($color));
}

function toLinP3(
    CssColor|\Stringable|string $color,
) :array {
    return xyzD65\toLinP3(... toXyzD65($color));
}

function toLinProPhoto(
    CssColor|\Stringable|string $color,
) :array {
    return xyzD50\toLinProPhoto(... toXyzD50($color));
}

function toLinRgb(
    CssColor|\Stringable|string $color,
) :array {
    return rgb\toLinRgb(... toRgb($color));
}

function toOkLab(
    CssColor|\Stringable|string $color,
) :array {
    return xyzD65\toOkLab(... toXyzD65($color));
}

function toOkLch(
    CssColor|\Stringable|string $color,
) :array {
    return okLab\toOkLch(... toOkLab($color));
}

function toP3(
    CssColor|\Stringable|string $color,
) :array {
    return linP3\toP3(... toLinP3($color));
}

function toProPhoto(
    CssColor|\Stringable|string $color,
) :array {
    return linProPhoto\toProPhoto(... toLinProPhoto($color));
}

function toRgb(
    CssColor|\Stringable|string $color,
) :array {
    if (!($color instanceof CssColor)) {
        $color = CssColor::fromCss($color);
    }
    
    return $color?->toRgbCoordinates()
        ?? [ 0, 0, 0, 255 ];
}

function toXyzD50(
    CssColor|\Stringable|string $color,
) :array {
    return xyzD65\toXyzD50(... toXyzD65($color));
}

function toXyzD65(
    CssColor|\Stringable|string $color,
) :array {
    return linRgb\toXyzD65(... toLinRgb($color));
}