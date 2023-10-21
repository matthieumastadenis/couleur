<?php

namespace matthieumastadenis\couleur\colors;

use       matthieumastadenis\couleur\Color;
use       matthieumastadenis\couleur\ColorFactory;
use       matthieumastadenis\couleur\ColorInterface;
use       matthieumastadenis\couleur\utils;

class      XyzD50
extends    Color
implements ColorInterface {

    /* #region Constructor */

    public function __construct(
        public readonly float $x       = 0,
        public readonly float $y       = 0,
        public readonly float $z       = 0,
        public readonly float $opacity = 1,
    ) {

    }

    /* #endregion */
    
    /* #region Public Static Methods */
    
    public static function aliases(

    ) :array {
        return [
            'xyz-d50',
            'xyz_d50',
            'xyzd50',
        ];
    }
    
    /* #endregion */
    
    /* #region Public Methods */

    public function change(
        \Stringable|string|int|float|null $x        = null,
        \Stringable|string|int|float|null $y        = null,
        \Stringable|string|int|float|null $z        = null,
        \Stringable|string|int|float|null $opacity  = null,
        XyzD50|null                       $fallback = null,
        bool|null                         $throw    = null,
    ) :XyzD50 {
        $changeThrow = $throw ?? true;

        return ColorFactory::newXyzD50(
            value    : [
                utils\changeCoordinate($this->x,       $y,       false, $changeThrow),
                utils\changeCoordinate($this->y,       $y,       false, $changeThrow),
                utils\changeCoordinate($this->z,       $z,       false, $changeThrow),
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
        return utils\xyzD50\stringify(
            x         : $this->x,
            y         : $this->y,
            z         : $this->z,
            opacity   : $this->opacity,
            alpha     : $alpha,
            precision : $precision,
        );
    }

    /* #endregion */

}
