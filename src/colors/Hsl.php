<?php

namespace matthieumastadenis\couleur\colors;

use       matthieumastadenis\couleur\Color;
use       matthieumastadenis\couleur\ColorFactory;
use       matthieumastadenis\couleur\ColorInterface;
use       matthieumastadenis\couleur\utils;

class      Hsl
extends    Color
implements ColorInterface {

    /* #region Constructor */

    public function __construct(
        public readonly float $hue        = 0,
        public readonly float $saturation = 0,
        public readonly float $lightness  = 0,
        public readonly float $opacity    = 100,
    ) {

    }

    /* #endregion */

    /* #region Public Static Methods */
    
    public static function aliases(

    ) :array {
        return [
            'hsl',
            'hsla',
        ];
    }

    /* #endregion */
    
    /* #region Public Methods */

    public function change(
        \Stringable|string|int|float|null $hue        = null,
        \Stringable|string|int|float|null $saturation = null,
        \Stringable|string|int|float|null $lightness  = null,
        \Stringable|string|int|float|null $opacity    = null,
        Hsl|null                          $fallback   = null,
        bool|null                         $throw      = null,
    ) :Hsl {
        $changeThrow = $throw ?? true;

        return ColorFactory::newHsl(
            value    : [
                utils\changeCoordinate($this->hue,        $hue,        false, $changeThrow),
                utils\changeCoordinate($this->saturation, $saturation, false, $changeThrow),
                utils\changeCoordinate($this->lightness,  $lightness,  false, $changeThrow),
                utils\changeCoordinate($this->opacity,    $opacity,    false, $changeThrow),
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
        return utils\hsl\stringify(
            hue        : $this->hue,
            saturation : $this->saturation,
            lightness  : $this->lightness,
            opacity    : $this->opacity,
            legacy     : $legacy,
            alpha      : $alpha,
            precision  : $precision,
        );
    }

    /* #endregion */
}
