<?php

namespace matthieumastadenis\couleur\utils\hexRgb;

use       matthieumastadenis\couleur\ColorSpace;
use       matthieumastadenis\couleur\utils;

function clean(
    mixed    $value,
    bool     $throw = true,
) :array {
    $values = [];

    if (\is_array($value)) {
        $values = $value;
    }
    else if (\is_string($value)) {
        $value  = \trim($value, '#');
        $values = (\strlen($value) > 3)
            ? \str_split($value, 2)
            : \array_map(
                callback : fn ($v) => $v.$v,
                array    : \str_split($value),
            )
        ;
    }

    return [
        utils\cleanHexValue($values[0] ?? '00', 2, true),
        utils\cleanHexValue($values[1] ?? '00', 2, true),
        utils\cleanHexValue($values[2] ?? '00', 2, true),
        utils\cleanHexValue($values[3] ?? 'ff', 2, true),
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
        to       : ColorSpace::HexRgb, 
        from     : $from, 
        fallback : $fallback, 
        throw    : $throw, 
    );
}

function stringify(
    string    $red,
    string    $green,
    string    $blue,
    string    $opacity   = 'FF',
    bool|null $alpha     = null,
    bool      $short     = true,
    bool|null $uppercase = null,
    bool      $sharp     = true,
) :string {
    $red   = utils\cleanHexValue($red);
    $green = utils\cleanHexValue($green);
    $blue  = utils\cleanHexValue($blue);
    $value = $red.$green.$blue;
    $lower = null;
    
    if ($alpha ?? (\strtoupper($opacity) !== 'FF')) {
        $value .= $opacity;
    }

    $value = match ($uppercase) {
        true    => \strtoupper($value),
        false   => \strtolower($value),
        default => $value,
    };

    $initials = [];

    foreach (\str_split($value, 2) as $v) {
        if ($v[0] === $v[1]) {
            $initials[] = $v[0];
        }
        else {
            $short = false;
            break;
        }
    }

    if ($short) {
        $value = \implode('', $initials);
    }

    return $sharp
        ? "#$value"
        : $value
    ;
}

function verify(
    mixed $value,
) :bool {
    return \is_string($value) && \preg_match(
        pattern : '/^#?[0-9A-Fa-f]{3,8}$/', 
        subject : $value,
    );
}
