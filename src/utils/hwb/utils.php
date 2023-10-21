<?php

namespace matthieumastadenis\couleur\utils\hwb;

use       matthieumastadenis\couleur\ColorSpace;
use       matthieumastadenis\couleur\Constant;
use       matthieumastadenis\couleur\exceptions\MissingColorValue;
use       matthieumastadenis\couleur\utils;

function clean(
    mixed     $value,
    bool|null $throw = null,
) :array {
    $values     = utils\parseColorValue($value, 100);
    $hue        = $values['hue']       ?? $values['h'] ?? $values[0] ?? null;
    $whiteness  = $values['whiteness'] ?? $values['w'] ?? $values[1] ?? null;
    $blackness  = $values['blackness'] ?? $values['b'] ?? $values[2] ?? null;
    $opacity    = $values['opacity']   ?? $values['o'] ?? $values[3] ?? null;

    return match (true) {
        !$throw               => null,
        ($hue       === null) => throw new MissingColorValue('hue'),
        ($whiteness === null) => throw new MissingColorValue('whiteness'),
        ($blackness === null) => throw new MissingColorValue('blackness'),
        default               => null,
    } ?? [
        utils\cleanCoordinate($hue       ?? 0,   0, 360, true),
        utils\cleanCoordinate($whiteness ?? 0,   0, 100, false),
        utils\cleanCoordinate($blackness ?? 0,   0, 100, false),
        utils\cleanCoordinate($opacity   ?? 100, 0, 100, false),
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
        to       : ColorSpace::Hwb, 
        from     : $from, 
        fallback : $fallback, 
        throw    : $throw, 
    );
}

function stringify(
    float     $hue,
    float     $whiteness,
    float     $blackness,
    float     $opacity   = 100,
    bool|null $legacy    = null,
    bool|null $alpha     = null,
    int|null  $precision = null,
) :string {
    $legacy    ??= Constant::LEGACY->value();
    $precision ??= Constant::PRECISION->value();
    $s1          = ' ';
    $s2          = ' / ';
    $hUnit       = 'deg';
    $wbUnit      = '%';
    $aUnit       = '%';
    $alpha     ??= ($opacity !== (float) 100);

    if ($legacy) {
        $opacity /= 100;
        $aUnit    = '';
        $s1       =
        $s2       = ',';
    }

    $value = "hwb("
        .\round($hue, $precision)
        .$hUnit
        .$s1
        .\round($whiteness, $precision)
        .$wbUnit
        .$s1
        .\round($blackness, $precision)
        .$wbUnit
    ;

    if (!$alpha) {
        return "$value)";
    }

    return $value
        .$s2
        .$opacity
        .$aUnit
        .')'
    ;
}

function verify(
    mixed $value,
) :bool {
    return utils\isColorString($value, ColorSpace::Hwb);
}