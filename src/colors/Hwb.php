<?php

namespace matthieumastadenis\couleur\colors;

use       matthieumastadenis\couleur\Color;
use       matthieumastadenis\couleur\ColorFactory;
use       matthieumastadenis\couleur\ColorInterface;
use       matthieumastadenis\couleur\utils;

class      Hwb
extends    Color
implements ColorInterface {

    /* #region Constructor */

    public function __construct(
        public readonly float $hue       = 0,
        public readonly float $whiteness = 0,
        public readonly float $blackness = 0,
        public readonly float $opacity   = 100,
    ) {

    }

    /* #endregion */

    /* #region Public Static Methods */
    
    public static function aliases(

    ) :array {
        return [
            'hwb',
        ];
    }

    /* #endregion */
    
    /* #region Public Methods */

    public function change(
        \Stringable|string|int|float|null $hue       = null,
        \Stringable|string|int|float|null $whiteness = null,
        \Stringable|string|int|float|null $blackness = null,
        \Stringable|string|int|float|null $opacity   = null,
        Hwb|null                          $fallback  = null,
        bool|null                         $throw     = null,
    ) :Hwb {
        $changeThrow = $throw ?? true;

        return ColorFactory::newHwb(
            value    : [
                utils\changeCoordinate($this->hue,       $hue,       false, $changeThrow),
                utils\changeCoordinate($this->whiteness, $whiteness, false, $changeThrow),
                utils\changeCoordinate($this->blackness, $blackness, false, $changeThrow),
                utils\changeCoordinate($this->opacity,   $opacity,   false, $changeThrow),
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
        return utils\hwb\stringify(
            hue       : $this->hue,
            whiteness : $this->whiteness,
            blackness : $this->blackness,
            opacity   : $this->opacity,
            legacy    : $legacy,
            alpha     : $alpha,
            precision : $precision,
        );
    }

    /* #endregion */
}