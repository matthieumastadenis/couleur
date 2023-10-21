<?php

namespace matthieumastadenis\couleur\colors;

use       matthieumastadenis\couleur\Color;
use       matthieumastadenis\couleur\ColorFactory;
use       matthieumastadenis\couleur\ColorInterface;
use       matthieumastadenis\couleur\utils;

class      Lch
extends    Color
implements ColorInterface {

    /* #region Constructor */

    public function __construct(
        public readonly float $lightness = 0,
        public readonly float $chroma    = 0,
        public readonly float $hue       = 0,
        public readonly float $opacity   = 100,
    ) {

    }

    /* #endregion */

    /* #region Public Static Methods */
    
    public static function aliases(

    ) :array {
        return [
            'lch',
            'cielch',
            'cie-lch',
            'cie_lch',
        ];
    }

    /* #endregion */
    
    /* #region Public Methods */

    public function change(
        \Stringable|string|int|float|null $lightness = null,
        \Stringable|string|int|float|null $chroma    = null,
        \Stringable|string|int|float|null $hue       = null,
        \Stringable|string|int|float|null $opacity   = null,
        Lch|null                          $fallback  = null,
        bool|null                         $throw     = null,
    ) :Lch {
        $changeThrow = $throw ?? true;

        return ColorFactory::newLch(
            value    : [
                utils\changeCoordinate($this->lightness, $lightness, false, $changeThrow),
                utils\changeCoordinate($this->chroma,    $chroma,    false, $changeThrow),
                utils\changeCoordinate($this->hue,       $hue,       false, $changeThrow),
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
        return utils\lch\stringify(
            lightness : $this->lightness,
            chroma    : $this->chroma,
            hue       : $this->hue,
            opacity   : $this->opacity,
            legacy    : $legacy,
            alpha     : $alpha,
            precision : $precision,
        );
    }

    /* #endregion */

}
