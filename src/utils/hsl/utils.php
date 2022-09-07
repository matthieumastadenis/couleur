<?php

namespace matthieumastadenis\couleur\utils\hsl;

use       matthieumastadenis\couleur\ColorSpace;
use       matthieumastadenis\couleur\Constant;
use       matthieumastadenis\couleur\exceptions\MissingColorValue;
use       matthieumastadenis\couleur\utils;

function clean(
    mixed     $value,
    bool|null $throw = null,
) :array {
    $values     = utils\parseColorValue($value, 100);
    $hue        = $values['hue']        ?? $values['h'] ?? $values[0] ?? null;
    $saturation = $values['saturation'] ?? $values['s'] ?? $values[1] ?? null;
    $lightness  = $values['lightness']  ?? $values['l'] ?? $values[2] ?? null;
    $opacity    = $values['opacity']    ?? $values['o'] ?? $values[3] ?? null;

    return match (true) {
        !$throw                => null,
        ($hue        === null) => throw new MissingColorValue('hue'),
        ($saturation === null) => throw new MissingColorValue('saturation'),
        ($lightness  === null) => throw new MissingColorValue('lightness'),
        default                => null,
    } ?? [
        utils\cleanCoordinate($hue        ?? 0,   0, 360, true),
        utils\cleanCoordinate($saturation ?? 0,   0, 100, false),
        utils\cleanCoordinate($lightness  ?? 0,   0, 100, false),
        utils\cleanCoordinate($opacity    ?? 100, 0, 100, false),
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
        to       : ColorSpace::Hsl, 
        from     : $from, 
        fallback : $fallback, 
        throw    : $throw, 
    );
}

function stringify(
    float     $hue,
    float     $saturation,
    float     $lightness,
    float     $opacity   = 100,
    bool|null $legacy    = null,
    bool|null $alpha     = null,
    int|null  $precision = null,
) :string {
    $legacy    ??= Constant::LEGACY->value();
    $precision ??= Constant::PRECISION->value();
    $function    = 'hsl';
    $s1          = ' ';
    $s2          = ' / ';
    $hUnit       = 'deg';
    $slUnit      = '%';
    $aUnit       = '%';
    $alpha     ??= ($opacity !== (float) 100);

    if ($legacy) {
        if ($alpha) {
            $function = 'hsla';
        }

        $opacity /= 100;
        $aUnit    = '';
        $s1       =
        $s2       = ',';
    }

    $value = "$function("
        .\round($hue, $precision)
        .$hUnit
        .$s1
        .\round($saturation, $precision)
        .$slUnit
        .$s1
        .\round($lightness, $precision)
        .$slUnit
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
    return utils\isColorString($value, ColorSpace::Hsl);
}