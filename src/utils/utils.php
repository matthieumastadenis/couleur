<?php

namespace matthieumastadenis\couleur\utils;

use       matthieumastadenis\couleur\ColorSpace;
use       matthieumastadenis\couleur\exceptions\CallbackDoesNotExist;
use       matthieumastadenis\couleur\exceptions\UnknownColorSpace;
use       matthieumastadenis\couleur\exceptions\UnsupportedCoordinateModifier;

/**
 * Add leading zero to $value if it is a stringable value starting with a dot. 
 * This function is useful for converting CSS opacity shortcuts to proper boolean 
 * numbers: '.5' is converted to '0.5'.
 * If $value is not stringable or does not start with a dot, it is returned without 
 * any change.
 *
 * @param  \Stringable|string|integer|float $value The value to transform
 * 
 * @return \Stringable|string|integer|float        The transformed or unchanged value
 */
function addLeadingZero(
    \Stringable|string|int|float $value,
) :\Stringable|string|int|float {
    return (isStringable($value) && \str_starts_with((string) $value, '.'))
        ? "0$value"
        : $value
    ;
}

/**
 * Returns the $value coordinate replaced or updated by $new.
 * 
 * If $new is null, $value will be returned.
 * If $new is a simple stringable or number, it will simply be returned instead of $value.
 * If $new is a string starting with a modifier character (+, -, *, /, %) or ending with a percentage character (%), $value will be modified then returned.
 * 
 * Examples: changeCoordinate(50, '+5')   returns 55 ;
 *           changeCoordinate(50, '-5')   returns 45 ;
 *           changeCoordinate(50, '*2')   returns 100 ;
 *           changeCoordinate(50, '/2')   returns 25 ;
 *           changeCoordinate(50, '%6')   returns 2 ;
 *           changeCoordinate(50, '10%')  returns 5 ;
 *           changeCoordinate(50, '+10%') returns 55 ; 
 *           changeCoordinate(50, '-10%') returns 45 ;
 *           changeCoordinate(50, '*10%') returns 250 ;
 *           changeCoordinate(50, '/10%') returns 10 ;
 *           changeCoordinate(50, '%10%') returns 0 ;
 *
 * @param  \Stringable|string|integer|float      $value The original coordinate you want to replace or update
 * @param  \Stringable|string|integer|float|null $new   Either a new value which will be returned instead of the original $value, or a modifier string which will be used to update $value
 * @param  boolean                               $hex   If true $value and $new will be considered as strings containing hexadecimal numbers
 * @param  boolean                               $throw If false the function will not throw exceptions
 * 
 * @return \Stringable|string|integer|float
 */
function changeCoordinate(
    \Stringable|string|int|float      $value,
    \Stringable|string|int|float|null $new   = null,
    bool                              $hex   = false,
    bool                              $throw = true,
) :\Stringable|string|int|float {
    if ($new === null) {
        return $value;
    }

    if (\is_int($new) || \is_float($new)) {
        return $new;
    }

    $val      = (string) $new;
    $original = (float) ($hex
        ? hexToDec($value)
        : $value
    );

    $modifier = startsWith($val, [ '+',   '-',  '*',  '/',  '%' ]);
    $val      = \substr($val, \strlen((string) $modifier));

    if (\str_ends_with($new, '%')) {
        $val = $original / 100 * (float) \substr($val, 0, -1);

        if (!$modifier) {
            return $hex
                ? decToHex($val)
                : $val
            ;
        }
    }
    else {
        if (!$modifier) {
            return $val;
        }

        if ($hex) {
            $val = (float) match ($modifier) {
                '+', '-' => hexToDec($val),
                default  => $val,
            };
        }
    }

    $result = match ($modifier) {
        '+'     => $original + $val,
        '-'     => $original - $val,
        '*'     => $original * $val,
        '/'     => $original / $val,
        '%'     => \fmod($original, $val),
        default => $throw
            ? throw new UnsupportedCoordinateModifier($modifier)
            : $original,
    };
    
    return $hex
        ? decToHex(\round($result))
        : $result
    ;
}

/**
 * Clean a single color coordinate. 
 * 
 * The purpose of this function is to transform any coordinate that is part of a color 
 * to a proper float number in the expected range.
 * 
 * By default, it uses 0 as the $min value and 100 as the $max value, so if you call 
 * the function with '150' or 150 the result will be (float) 100, and if you call the 
 * function with '-150' or -150 the result will be (float) 0. You can define both 
 * $min and $max to null if you want an unbounded result.
 * 
 * Percentages are automatically converted using $max value. For example, if you call 
 * the function with $max=255 and with a $value of '50%' the result will be (float) 127.5.
 * 
 * If you set $round to true, the value will be rounded with $precision decimals. The 
 * $precision can not exceed \ini_get('precision'), and will be considered as 0 by default.
 *
 * @param \Stringable|string|integer|float $value     The stringable or number to clean
 * @param integer                          $min       Minimum allowed value (can be null to unbound)
 * @param integer                          $max       Maximum allowed value (can be null to unbound)
 * @param boolean                          $loop      
 * @param integer|null                     $precision Used to round the value
 * @param boolean                          $round     If true the value will be rounded
 * @param \Stringable|string|null          $padLeft
 * @param integer|null                     $length
 * 
 * @return float
 */
function cleanCoordinate(
    \Stringable|string|int|float $value,
    float|null                   $min       = 0,
    float|null                   $max       = 100,
    bool                         $loop      = false,
    int|null                     $precision = null,
    bool                         $round     = false,
    \Stringable|string|null      $padLeft   = null,
    int                          $length    = null,
) :float {
    if (isStringable($value)) {
        $value = addLeadingZero((string) $value);
        $value = \str_ends_with($value, '%')
            ? (((float) $value) * $max / 100)
            : (float) $value
        ;
    }

    $value = (float) ($round
        ? \round($value, cleanPrecision($precision))
        : $value
    );

    if ($min !== null) {
        $value = \max($min, $value);
    }

    if ($max !== null) {
        $value = \min($value, $max);
    }
    
    $value = (float) $value;

    return ($padLeft === null)
        ? $value
        : \str_pad(
            string     : $value,
            length     : $length ?? \strlen((string) $max),
            pad_string : $padLeft, 
            pad_type   : \STR_PAD_LEFT,
        )
    ;
}

/**
 * This function transforms a potentially invalid number of decimals to a valid 
 * number of decimals, which can be use in any rounding function.
 * 
 * It returns the minimum integer value between $precision and \ini_get('precision'). 
 * If the $precision parameter is null, it will be considered as 0.
 *
 * @param  integer|null $precision A potentially invalid number of decimals
 * 
 * @return integer                 The corresponding valid number of decimals
 */
function cleanPrecision(
    int|null $precision = null,
) :int {
    $default = \ini_get('precision');

    if (!\in_array($default, [ '', false ], true)) {
        $default = 14;
    }

    return (int) \min($precision ?? 0, $default);
}

/**
 * Return the value of a constant if it exists, or $value if the constant does not exists.
 * If $create is set to true, the constant will be defined with $value as a value.
 * 
 * The purpose of this function is to handle constants which are specific to the 
 * matthieumastadenis/couleur package, so it only uses uppercase constants prefixed 
 * with 'COULEUR_'. It is not made to be used with external or third-party constants.
 *
 * @param  \Stringable|string $name   The constant name (will be converted to uppercase and prefixed with 'COULEUR_')
 * @param  mixed              $value  Fallback value (also used to define the constant if $create is true)
 * @param  boolean            $create If true the constant will be defined with $value as a value
 * 
 * @return mixed                      The constant value if it exists, $value otherwise
 */
function constant(
    \Stringable|string $name,
    mixed              $value  = null,
    bool               $create = false,
) :mixed {
    $name = \strtoupper((string) $name);
    
    if (!\str_starts_with($name, 'COULEUR_')) {
        $name = "COULEUR_$name";
    }

    if (\defined($name)) {
        return \constant($name);
    }

    if ($create) {
        \define($name, $value);
    }

    return $value;
}

/**
 * Clean an hexadecimal value so it contains exaclty $length characters. 
 * Also converts the value to uppercase or lowercase if $uppercase is set to true or false.
 * 
 * The purpose of this function is to help converting short hexadecimal color values to their 
 * longer form, like #f00 to #ff0000. It should be called separately for red, green and blue.
 * 
 * If $value is 'f' and $length is 2, the result will be 'ff'.
 *
 * @param  \Stringable|string $value     The hexadecimal string to clean
 * @param  integer            $length    The minimum length expected
 * @param  boolean|null       $uppercase If true $value will be converted to uppercase, 
 *                                       if false $value will be converted to lowercase,
 *                                       if null the case remains unchanged
 * 
 * @return string                        The cleaned hexadecimal $value
 */
function cleanHexValue(
    \Stringable|string $value,
    int                $length    = 2,
    bool|null          $uppercase = null,
    \Stringable|string $prefix    = null,
) :string {
    $value  = (string) $value;
    $prefix = (string) ($prefix ?? $value);
    $l      = \strlen($value);
    
    while ($l < $length) {
        $value = $prefix.$value;
        $l++;
    }

    if ($uppercase === null) {
        return $value;
    }

    return $uppercase
        ? \strtoupper($value)
        : \strtolower($value)
    ;
}

/**
 * Converts a float number to its hexadecimal string equivalent.
 *
 * @param  float        $number
 * @param  integer      $length
 * @param  boolean|null $uppercase
 * @param  integer|null $precision
 * 
 * @return string
 */
function decToHex(
    float     $number,
    int       $length    = 2,
    bool|null $uppercase = null,
) :string {
    return cleanHexValue(
        value : \dechex(
            num : (int) \round($number),
        ),
        length    : $length,
        uppercase : $uppercase,
        prefix    : '0',
    );
}

/**
 * Attempts to guess a color space by interpreting $value. 
 * 
 * This fonction only works with color spaces handled by the matthieumastadenis\couleur\ColorSpace enum.
 * 
 * If $value does not correspond to any of these color spaces, a UnknownColorSpace exception will be thrown by default. 
 * If the $throw parameter is set to false, $fallback will be returned instead.
 *
 * @param mixed           $value    A color value to analyze. Typically it should be an array like [ 255,0,0 ] or a 
 *                                  stringable color expression like 'rgb(255,0,0)'.
 * @param ColorSpace|null $fallback Fallback value returned if no color space was found and no exception was thrown. 
 * @param boolean|null    $throw    If $value does not correspond to any supported color space and this parameter 
 *                                  is true, the fonction will throw a UnknownColorSpace exception. If $throw is null, 
 *                                  an exception will only be thrown if $fallback is also null.
 * 
 * @return ColorSpace|null          The ColorSpace instance corresponding to $value, $fallback otherwise
 */
function findColorSpace(
    mixed           $value,
    ColorSpace|null $fallback = null,
    bool|null       $throw    = null,
) :ColorSpace|null {
    $throw ??= !$fallback;

    foreach (ColorSpace::cases() as $space) {
        $verifyCallback = $space->verifyCallback();

        if (!\function_exists($verifyCallback)) {
            if ($throw) {
                return throw new CallbackDoesNotExist($verifyCallback);
            }
            else {
                continue;
            }
        }

        if ($verifyCallback($value)) {
            return $space;
        }
    }

    return $throw
        ? throw new UnknownColorSpace
        : $fallback;
}


/**
 * This function is used when converting a color value to any color space.
 * 
 * If the $from parameter is null, the function uses findColorSpace() to identify the input color space from the format of $value.
 * 
 * If the $to parameter is null, it will be the same as the specified or identified input color space.
 *
 * @param  mixed                              $value
 * @param  ColorSpace|\Stringable|string|null $to
 * @param  ColorSpace|\Stringable|string|null $from
 * @param  boolean                            $throw
 * 
 * @return array
 */
function findFromAndTo(
    mixed                              $value,
    ColorSpace|\Stringable|string|null $to    = null,
    ColorSpace|\Stringable|string|null $from  = null,
    bool|null                          $throw = true,
) :array {
    $from = toColorSpace(
        value : $from ??= findColorSpace(
            value    : $value,
            fallback : null,
            throw    : $throw,
        ),
        fallback : null,
        throw    : $throw,
    );

    $to = toColorSpace(
        value    : $to ?? $from,
        fallback : null,
        throw    : $throw,
    );

    return [
        'from' => $from, 
        'to'   => $to
    ];
}

/**
 * Converts an hexadecimal string to its float number equivalent.
 *
 * @param \Stringable|string $value
 * @return float
 */
function hexToDec(
    \Stringable|string $value,
) :float {
    return (float) \hexdec(
        hex_string : (string) $value,
    );
}

/**
 * Returns true if $value is a stringable color expression using any supported color space
 * (like 'rgba(255,0,0,1)' or 'color(xyz-d50 0.41 0.21 0.02 / 100%)'). Returns false otherwise.
 *
 * @param  mixed                         $value
 * @param  \Stringable|string|array|null $spaces
 * 
 * @return boolean
 */
function isColorString(
    mixed                               $value,
    ColorSpace|\Stringable|string|array $spaces = null,
) :bool {
    if (!isStringable($value)) {
        return false;
    }

    $value = (string) $value;

    if ($spaces instanceof ColorSpace) {
        $spaces = $spaces->aliases();
    }

    foreach (toArray($spaces) as $space) {
        if ($space === null) {
            $space = '[0-9A-Za-z]+';
        }
    
        $n  = '-?[0-9\.]*((deg)|%)?';
        $s  = '[\s,]*';
        $os = '[\s,\/]*';
        
        if (\preg_match(
            pattern : "/^($space\s*\()|(color\s*\($space)$s$n$s$n$s$n$os$n\s*\)?$/", 
            subject : $value,
        )) {
            return true;
        }
    } 

    return false;
}

/**
 * Returns true if $value is an array or an instance of \Traversable, false otherwise.
 *
 * @param  mixed   $value The value to test as an iterable
 * 
 * @return boolean        True if $value is an array or an instance of \Traversable, false otherwise
 */
function isIterable(
    mixed $value,
) :bool {
    return \is_array($value)
        || (\is_object($value) && ($value instanceof \Traversable))
    ;
}

/**
 * Returns true if $value is a string or an object implementing the \Stringable interface.
 * Returns false otherwise.
 *
 * @param  mixed   $value The value to test as a stringable
 * 
 * @return boolean        True if $value is a string or a \Stringable object, false otherwise
 */
function isStringable(
    mixed $value,
) :bool {
    return \is_string($value)
        || ($value instanceof \Stringable)
    ;
}

/**
 * Where the magic happens. This is used by several color spaces conversion functions. 
 * 
 * This function is directly inspired by the multiplyMatrices() function in color.js form Lea Verou and Chris Lilley.
 * (see https://github.com/LeaVerou/color.js/blob/main/src/multiply-matrices.js)
 * 
 * It returns an array which is the product of the two number matrices passed as parameters.
 *
 * @param  array $a m x n matrice
 * @param  array $b n x p matrice
 * 
 * @return array    m x p product
 */
function multiplyMatrices(
    array $a, 
    array $b,
) :array {
    $m = count($a);

	if (!\is_array($a[0] ?? null)) {
		// $a is vector, convert to [[a, b, c, ...]]
		$a = [ $a ];
	}

	if (!\is_array($b[0])) {
		// $b is vector, convert to [[a], [b], [c], ...]]
        $b = \array_map(
            callback : fn ($v) => [ $v ], 
            array    : $b,
        );
	}

    $p = count($b[0]);

    // transpose $b:
    $bCols = \array_map(
        callback : fn ($k) => \array_map(
            (fn ($i) => $i[$k]),
            $b,
        ),
        array : \array_keys($b[0]),
    );

    $product = \array_map(
        callback : fn ($row) => \array_map(
            callback : fn ($col) => \is_array($row)
                ? \array_reduce(
                    array    : $row,
                    callback : fn ($a, $v, $i = null) => $a + $v * (
                        $col[$i ?? \array_search($v, $row)] ?? 0
                    ),
                    initial  : 0,
                ) : \array_reduce(
                    array    : $col,
                    callback : fn ($a, $v) => $a + $v * $row,
                    initial  : 0,
                ),
            array : $bCols,
        ),
        array : $a,
    );

	if ($m === 1) {
        // Avoid [[a, b, c, ...]]:
		$product = $product[0];
	}

	if ($p === 1) {
        // Avoid [[a], [b], [c], ...]]:
        return \array_map(
            callback : fn ($v) => $v[0],
            array    : $product,
        );
	}

	return $product;
}

/**
 * Parse any color value and returns an array of corresponding cleaned coordinates. 
 * 
 * Typically $value should be an array of coordinates like [ 255,0,0 ], or a stringable color expression like 'rgb(255,0,0)'.
 * 
 * @param  mixed          $value
 * @param  int|float|null $opacityFactor
 * 
 * @return array
 */
function parseColorValue(
    mixed          $value,
    int|float|null $opacityFactor = null,
) :array {
    return isStringable($value)
        ? parseStringColorValue($value, $opacityFactor)
        : toArray($value)
    ;
}

/**
 * Parse a stringable color expression like 'rgb(255,0,0)' and returns an array 
 * of corresponding cleaned coordinates, like [ 255,0,0,255 ].
 * 
 * @param  \Stringable|string $value
 * @param  int|float|null     $opacityFactor
 * 
 * @return array
 */
function parseStringColorValue(
    \Stringable|string $value,
    int|float|null     $opacityFactor = null,
    int                $opacityIndex  = 3,
) :array {
    $replace = \array_merge(
        \array_keys(ColorSpace::allAliases()),
        [ 'color', '(', ')' ],
    );
    
    $string = \str_replace(
        search  : $replace,
        replace : '', 
        subject : \trim((string) $value, ', '),
    );

    $separator = \str_contains($string, ',')
        ? ','
        : ' '
    ;

    $values = \explode(
        separator : $separator,
        string    : $string,
    );

    $values = \array_map(
        callback : fn ($v) => \is_numeric($v)
            ? (float) $v
            : $v,
        array    : \array_values(
            array : \array_filter(
                array : \array_map(
                    callback : fn ($v) => addLeadingZero(\preg_replace(
                        pattern     : '/[^0-9\.%]/',
                        replacement : '',
                        subject     : $v,
                    )),
                    array : $values,
                ),
                callback : fn ($v) => ($v !== ''),
            ),
        ),
    );

    if (!$opacityFactor) {
        return $values;
    }

    return \array_map(
        function ($v, $i) use ($opacityFactor, $opacityIndex) {
            if (($i === $opacityIndex) && !\str_ends_with($v, '%')) {
                $v = $opacityFactor * ((float) $v);
            }

            return $v;
        },
        \array_values($values),
        \array_keys($values),
    );
}

/**
 * Adds $value to $array and returns $array.
 * 
 * By default $value will simply be pushed at the end of $array.
 * 
 * If $index is specified, $value will be added to $array with $index as a key.
 * By default if $array already contains a value with the $index key, it will not be replaced,
 * except if $replace is set to true.
 * 
 * @param mixed               $value
 * @param array               $array
 * @param string|integer|null $index
 * @param boolean             $replace
 * 
 * @return array
 */
function push(
    mixed           $value,
    array           $array,
    string|int|null $index   = null,
    bool            $replace = false,
) :array {
    if ($index === null) {
        $array[] = $value;
    }
    else if (!$replace || !\array_key_exists($index, $array)) {
        $array[$index] = $value;
    }

    return $array;
}

/**
 * This function is equivalent to findFromAndTo(), but with $to and $from parameters passed 
 * as reference so they can be automatically exported to the scope from which it is called.
 * 
 * It is notably used by the to() function.
 *
 * @param  mixed                              $value
 * @param  ColorSpace|\Stringable|string|null $to
 * @param  ColorSpace|\Stringable|string|null $from
 * @param  boolean                            $throw
 * 
 * @return array
 */
function setFromAndTo(
    mixed                               $value,
    ColorSpace|\Stringable|string|null &$to    = null,
    ColorSpace|\Stringable|string|null &$from  = null,
    bool|null                           $throw = true,    
) :array {
    $results = findFromAndTo(
        value    : $value,
        to       : $to,
        from     : $from, 
        throw    : $throw, 
    );

    $to   = $results['to']   ?? null;
    $from = $results['from'] ?? null;

    return $results;
}

/**
 * If $haystack starts with one of the values provided in $needles, returns the needle. Otherwise the function returns false.
 * If $returnNeedle is set to false, the function will return true instead of the needle prefix.
 * 
 * Examples : startsWith('+50', '+')                 returns '+' ;
 *            startsWith('-50', [ '+', '-' ])        returns '-' ;
 *            startsWith('-50', [ '+', '-' ], false) returns true ;
 *            startsWith('+50', [ '*', '/' ])        returns false ;
 *
 *
 * @param  \Stringable|string          $haystack
 * @param  \Stringable|string|iterable $needles
 * @param  boolean                     $returnNeedle
 * @return string|boolean
 */
function startsWith(
    \Stringable|string          $haystack,
    \Stringable|string|iterable $needles,
    bool                        $returnNeedle = true,
) :string|bool {
    $haystack = (string) $haystack;

    foreach (toIterable($needles) as $needle) {
        $needle = (string) $needle;

        if (!\strlen($needle)) {
            continue;
        }

        if (\str_starts_with($haystack, $needle)) {
            return $returnNeedle
                ? $needle
                : true
            ;
        }
    }

    return false;
}

/**
 * This is the highest-level function used to convert any color value to any color space. 
 * 
 * It uses setFromAndTo() to find the color spaces corresponding to the $to and $from parameters if those are null.
 * 
 * If the conversion succeeds, it always returns an array of values, like [ 255,0,0,255 ] or [ 'FF','00','00','FF' ].
 * In case of errors, it will throw exceptions, except if $throw if set to false (or if $throw is null and $fallback is not null).
 *
 * @param  mixed                              $value
 * @param  ColorSpace|\Stringable|string|null $to
 * @param  ColorSpace|\Stringable|string|null $from
 * @param  array|null                         $fallback
 * @param  boolean|null                       $throw
 * 
 * @return array
 */
function to(
    mixed                              $value,
    ColorSpace|\Stringable|string|null $to        = null,
    ColorSpace|\Stringable|string|null $from      = null,
    array|null                         $fallback  = null,
    bool|null                          $throw     = null,
) :array {
    setFromAndTo(
        value    : $value,
        to       : $to,
        from     : $from, 
        throw    : $throw, 
    );

    if (!($from instanceof ColorSpace)
    || !($to instanceof ColorSpace)) {
        return $fallback;
    }
    
    return toColor(
        value     : $value,
        to        : $to,
        from      : $from,
        fallback  : $fallback,
        throw     : $throw,
    );
}


/**
 * Converts $value to an array and returns it. 
 * 
 * If $keep is true and $value is not already an array, the returned array will include $value.
 * If $keep is false and $value is not already an array, the returned array will be empty.
 *
 * @param  mixed   $value
 * @param  boolean $keep
 * 
 * @return array
 */
function toArray(
    mixed $value,
    bool  $keep = true,
) :array {
    return \is_array($value)
        ? $value
        : ($keep
            ? [ $value ]
            : []
        )
    ;
}

/**
 * Converts $value to an iterable and returns it.
 * 
 * If $value is an array or an instance of \Traversable it will be returned without modification.
 * Otherwise $value will be converted to an array then returned.
 * 
 * If $keep is true and $value is not already an iterabble, the returned array will include $value.
 * If $keep is false and $value is not already an iterable, the returned array will be empty.
 *
 * @param  mixed    $value
 * @param  boolean  $keep
 * @return iterable
 */
function toIterable(
    mixed $value,
    bool  $keep = true,
) :iterable {
    return isIterable($value)
        ? $value
        : toArray($value, $keep)
    ;
}

/**
 * Converts any color value to the specified $to color space. 
 * This function is notably called directly by the to() function.
 * 
 * If $from is null, it will use the $to same color space than the $to parameter.
 * 
 * If the conversion succeeds, it always returns an array of values, like [ 255,0,0,255 ] or [ 'FF','00','00','FF' ].
 * In case of errors, it will throw exceptions, except if $throw if set to false (or if $throw is null and $fallback is not null).
 *
 * @param  mixed           $value
 * @param  ColorSpace      $to
 * @param  ColorSpace|null $from
 * @param  array|null      $fallback
 * @param  boolean|null    $throw
 * 
 * @return array
 */
function toColor(
    mixed      $value,
    ColorSpace $to,
    ColorSpace $from      = null,
    array|null $fallback  = null,
    bool|null  $throw     = null,
) :array {
    $throw   ??= ($fallback === null);
    $from    ??= $to;
    $cleanFrom = $from->cleanCallback();
    $cleanTo   = $to->cleanCallback();
    $convert   = __NAMESPACE__
        .'\\'
        .\lcfirst($from->name)
        .'\\to'
        .$to->name
    ;

    if (!\function_exists($cleanFrom)) {
        return $throw
            ? throw new CallbackDoesNotExist($cleanFrom)
            : $fallback
        ;
    }

    $values = toArray($cleanFrom($value, $throw));

    if (!$values) {
        return $fallback;
    }

    if ($from === $to) {
        return $values;
    }
    
    foreach ([ $convert, $cleanTo ] as $callback) {
        if (!\function_exists($callback)) {
            return $throw
                ? throw new CallbackDoesNotExist($callback)
                : $fallback
            ;
        }
    }

    return toArray($cleanTo($convert(... $values)));
}

/**
 * Converts $value to an instance of the ColorSpace enum if it's not already.
 *
 * @param  ColorSpace|\Stringable|string|null $value
 * @param  ColorSpace|null                    $fallback
 * @param  boolean|null                       $throw
 * 
 * @return ColorSpace|null
 */
function toColorSpace(
    ColorSpace|\Stringable|string|null $value,
    ColorSpace|null                    $fallback = null,
    bool|null                          $throw    = null,
) :ColorSpace|null {
    if ($value === null) {
        return ($throw ?? !$fallback)
            ? throw new UnknownColorSpace
            : $fallback;
    }

    return ($value instanceof ColorSpace)
        ? $value
        : ColorSpace::fromAlias(
            name     : $value,
            fallback : $fallback,
            throw    : $throw,
        )
    ;
}

/**
 * Returns true if $value is an array and if all of its values are validated using $filter, false otherwise.
 *
 * @param  mixed    $value  The value to validate
 * @param  callable $filter The filter used to validate the array values (if $value is an array)
 * 
 * @return boolean          True if $value is an array and if all of its values are validated using $filter, false otherwise
 */
function validateArray(
    mixed    $value,
    callable $filter,
) :bool {
    return \is_array($value) && (\array_filter($value, $filter) === $value);
}
