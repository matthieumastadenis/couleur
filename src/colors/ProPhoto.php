<?php

namespace matthieumastadenis\couleur\colors;

use       matthieumastadenis\couleur\Color;
use       matthieumastadenis\couleur\ColorFactory;
use       matthieumastadenis\couleur\ColorInterface;
use       matthieumastadenis\couleur\utils;

class      ProPhoto
extends    Color
implements ColorInterface {

    /* #region Constructor */

    public function __construct(
        public readonly float $red     = 0,
        public readonly float $green   = 0,
        public readonly float $blue    = 0,
        public readonly float $opacity = 1,
    ) {

    }

    /* #endregion */

    /* #region Public Static Methods */
    
    
    public static function aliases(

    ) :array {
        return [
            'prophoto-rgb',
            'prophoto_rgb',
            'prophoto',
        ];
    }

    /* #endregion */
    
    /* #region Public Methods */

    public function change(
        \Stringable|string|int|float|null $red       = null,
        \Stringable|string|int|float|null $green     = null,
        \Stringable|string|int|float|null $blue      = null,
        \Stringable|string|int|float|null $opacity   = null,
        LinP3|null                        $fallback  = null,
        bool|null                         $throw     = null,
    ) :ProPhoto {
        $changeThrow = $throw ?? true;

        return ColorFactory::newProPhoto(
            value    : [
                utils\changeCoordinate($this->red,     $red,     false, $changeThrow),
                utils\changeCoordinate($this->green,   $green,   false, $changeThrow),
                utils\changeCoordinate($this->blue,    $blue,    false, $changeThrow),
                utils\changeCoordinate($this->opacity, $opacity, false, $changeThrow),
            ],
            from     : $this::space(),
            fallback : $fallback,
            throw    : $throw,
        );
    } 
    
    public function stringify(
        bool|null $legacy    = null,
        bool|null $alpha     = null,
        int|null  $precision = null,
    ) :string {
        return utils\proPhoto\stringify(
            red       : $this->red,
            green     : $this->green,
            blue      : $this->blue,
            opacity   : $this->opacity,
            alpha     : $alpha,
            precision : $precision,
        );
    }

    /* #endregion */

}
