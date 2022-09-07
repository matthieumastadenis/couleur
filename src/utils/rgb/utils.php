<?php

namespace matthieumastadenis\couleur\utils\rgb;

use       matthieumastadenis\couleur\ColorSpace;
use       matthieumastadenis\couleur\Constant;
use       matthieumastadenis\couleur\exceptions\MissingColorValue;
use       matthieumastadenis\couleur\utils;

function clean(
    mixed     $value,
    bool|null $throw = null,
) :array {
    $values  = utils\parseColorValue($value, 255);
    $red     = $values['red']     ?? $values['r'] ?? $values[0] ?? null;
    $green   = $values['green']   ?? $values['g'] ?? $values[1] ?? null;
    $blue    = $values['blue']    ?? $values['b'] ?? $values[2] ?? null;
    $opacity = $values['opacity'] ?? $values['o'] ?? $values[3] ?? null;

    return match (true) {
        !$throw           => null,
        ($red   === null) => throw new MissingColorValue('red'),
        ($green === null) => throw new MissingColorValue('green'),
        ($blue  === null) => throw new MissingColorValue('blue'),
        default           => null,
    } ?? [
        utils\cleanCoordinate($red     ?? 0,   0, 255),
        utils\cleanCoordinate($green   ?? 0,   0, 255),
        utils\cleanCoordinate($blue    ?? 0,   0, 255),
        utils\cleanCoordinate($opacity ?? 255, 0, 255),
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
        to       : ColorSpace::Rgb, 
        from     : $from, 
        fallback : $fallback, 
        throw    : $throw, 
    );
}

function stringify(
    float     $red,
    float     $green,
    float     $blue,
    float     $opacity   = 255,
    bool|null $legacy    = null,
    bool|null $alpha     = null,
    int|null  $precision = null,
) :string {
    $legacy    ??= Constant::LEGACY->value();
    $precision ??= Constant::PRECISION->value();
    $function    = 'rgb';
    $s1          = ' ';
    $s2          = ' / ';
    $unit        = '%';
    $aUnit       = '';
    $alpha     ??= ($opacity !== (float) 255);

    if ($legacy) {
        if ($alpha) {
            $function = 'rgba';
        }

        $opacity /= 255;
        $unit     = '';
        $s1       =
        $s2       = ',';
    }
    else {
        $red     /= 2.55;
        $green   /= 2.55;
        $blue    /= 2.55;
        $opacity /= 2.55;
        $aUnit    = '%';
    }

    $value = "$function("
        .\round($red, $precision)
        .$unit
        .$s1
        .\round($green, $precision)
        .$unit
        .$s1
        .\round($blue, $precision)
        .$unit
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
    return utils\isColorString($value, ColorSpace::Rgb)
        || utils\validateArray(
            value  : $value, 
            filter : fn ($v) => !\is_object($v) && ((int) $v >= 0) && ((int) $v <= 255)
        )
    ;
}