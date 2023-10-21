<?php

namespace matthieumastadenis\couleur\utils\okLch;

use       matthieumastadenis\couleur\ColorSpace;
use       matthieumastadenis\couleur\Constant;
use       matthieumastadenis\couleur\exceptions\MissingColorValue;
use       matthieumastadenis\couleur\utils;

function clean(
    mixed     $value,
    bool|null $throw = null,
) :array {
    $values    = utils\parseColorValue($value, 100);
    $lightness = $values['lightness'] ?? $values['l'] ?? $values[0] ?? null;
    $chroma    = $values['chroma']    ?? $values['c'] ?? $values[1] ?? null;
    $hue       = $values['hue']       ?? $values['h'] ?? $values[2] ?? null;
    $opacity   = $values['opacity']   ?? $values['o'] ?? $values[3] ?? null;

    return match (true) {
        !$throw               => null,
        ($lightness === null) => throw new MissingColorValue('lightness'),
        ($chroma    === null) => throw new MissingColorValue('chroma'),
        ($hue       === null) => throw new MissingColorValue('hue'),
        default               => null,
    } ?? [
        utils\cleanCoordinate($lightness ?? 0,   0,    100,  false),
        utils\cleanCoordinate($chroma    ?? 0,   null, null, false),
        utils\cleanCoordinate($hue       ?? 0,   0,    360,  true),
        utils\cleanCoordinate($opacity   ?? 100, 0,    100,  false),
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
        to       : ColorSpace::OkLch, 
        from     : $from, 
        fallback : $fallback, 
        throw    : $throw, 
    );
}

function stringify(
    float     $lightness,
    float     $chroma,
    float     $hue,
    float     $opacity   = 100,
    bool|null $legacy    = null,
    bool|null $alpha     = null,
    int|null  $precision = null,
) :string {
    $legacy    ??= Constant::LEGACY->value();
    $precision ??= Constant::PRECISION->value();
    $s1          = ' ';
    $s2          = ' / ';
    $lUnit       = '%';
    $cUnit       = '';
    $hUnit       = 'deg';
    $aUnit       = '%';
    $alpha     ??= ($opacity !== (float) 100);

    if ($legacy) {
        $opacity /= 100;
        $aUnit    = '';
        $s1       =
        $s2       = ',';
    }

    $value = "oklch("
        .\round($lightness, $precision)
        .$lUnit
        .$s1
        .\round($chroma, $precision)
        .$cUnit
        .$s1
        .\round($hue, $precision)
        .$hUnit
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
    return utils\isColorString($value, ColorSpace::OkLch);
}
