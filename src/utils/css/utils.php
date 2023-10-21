<?php

namespace matthieumastadenis\couleur\utils\css;

use       matthieumastadenis\couleur\ColorSpace;
use       matthieumastadenis\couleur\CssColor;
use       matthieumastadenis\couleur\utils;

/**
 * Clean a CSS color value expressed as $value. Returns an instance of the CssColor enum.
 *
 * @param  mixed    $value
 * @param  boolean  $throw
 *
 * @return CssColor
 */
function clean(
    mixed    $value,
    bool     $throw = true,
) :CssColor {
    if (\is_array($value)) {
        $value = $value[0] ?? 'black';
    }

    return ($value instanceof CssColor)
        ? $value
        : CssColor::fromCss((string) $value, $throw)
    ;
}

function from(
    mixed                              $value,
    ColorSpace|\Stringable|string|null $from     = null,
    array|null                         $fallback = null,
    bool|null                          $throw    = null,
) :array {
    return utils\to(
        value    : $value,
        to       : ColorSpace::Css,
        from     : $from,
        fallback : $fallback,
        throw    : $throw,
    );
}

function stringify(
    mixed $value,
) :string {
    return ($value instanceof CssColor)
        ? $value->name
        : (string) $value
    ;
}

function verify(
    mixed $value,
) :bool {
    return ($value instanceof CssColor)
        || (\is_string($value) && CssColor::exists($value))
        || (\is_array($value)
            && (\count($value) === 1)
            && (($value[0] instanceof CssColor) || (
                \is_string($value[0] ?? null)
                && CssColor::exists($value[0])
            ))
        )
    ;
}
