<?php

namespace matthieumastadenis\couleur\utils\xyzD50;

use       matthieumastadenis\couleur\ColorSpace;
use       matthieumastadenis\couleur\Constant;
use       matthieumastadenis\couleur\exceptions\MissingColorValue;
use       matthieumastadenis\couleur\utils;

function clean(
    mixed     $value,
    bool|null $throw = null,
) :array {
    $values  = utils\parseColorValue($value, 1);
    $x       =                       $values['x'] ?? $values[0] ?? null;
    $y       =                       $values['y'] ?? $values[1] ?? null;
    $z       =                       $values['z'] ?? $values[2] ?? null;
    $opacity = $values['opacity'] ?? $values['o'] ?? $values[3] ?? null;

    return match (true) {
        !$throw       => null,
        ($x === null) => throw new MissingColorValue('x'),
        ($y === null) => throw new MissingColorValue('y'),
        ($z === null) => throw new MissingColorValue('z'),
        default       => null,
    } ?? [
        utils\cleanCoordinate($x       ?? 0, 0, 1),
        utils\cleanCoordinate($y       ?? 0, 0, 1),
        utils\cleanCoordinate($z       ?? 0, 0, 1),
        utils\cleanCoordinate($opacity ?? 1, 0, 1),
    ];
}

function from(
    mixed                              $value,
    ColorSpace|\Stringable|string|null $from     = null,
    array|null                         $fallback = null,
    bool|null                          $throw    = null,
) :array {
    return utils\to(
        value    : $value,
        to       : ColorSpace::XyzD50,
        from     : $from,
        fallback : $fallback,
        throw    : $throw,
    );
}

function stringify(
    float     $x,
    float     $y,
    float     $z,
    float     $opacity   = 1,
    bool|null $alpha     = null,
    int|null  $precision = null,
) :string {
    $legacy    ??= Constant::LEGACY->value();
    $precision ??= Constant::PRECISION->value();
    $alpha     ??= ($opacity !== (float) 1);

    $value = "color(xyz-d50 "
        .\round($x, $precision)
        .' '
        .\round($y, $precision)
        .' '
        .\round($z, $precision)
    ;

    if (!$alpha) {
        return "$value)";
    }

    return $value
        .' / '
        .$opacity * 100
        .'%)'
    ;
}

function verify(
    mixed $value,
) :bool {
    return utils\isColorString($value, ColorSpace::XyzD50);
}
