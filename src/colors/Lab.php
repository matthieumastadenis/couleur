<?php

namespace matthieumastadenis\couleur\colors;

use       matthieumastadenis\couleur\Color;
use       matthieumastadenis\couleur\ColorFactory;
use       matthieumastadenis\couleur\ColorInterface;
use       matthieumastadenis\couleur\utils;

class      Lab
extends    Color
implements ColorInterface {

    /* #region Constructor */

    public function __construct(
        public readonly float $lightness = 0,
        public readonly float $a         = 0,
        public readonly float $b         = 0,
        public readonly float $opacity   = 100,
    ) {

    }

    /* #endregion */

    /* #region Public Static Methods */

    public static function aliases(

    ) :array {
        return [
            'lab',
            'cielab',
            'cie-lab',
            'cie_lab',
        ];
    }

    /* #endregion */

    /* #region Public Methods */

    public function change(
        \Stringable|string|int|float|null $lightness  = null,
        \Stringable|string|int|float|null $a          = null,
        \Stringable|string|int|float|null $b          = null,
        \Stringable|string|int|float|null $opacity    = null,
        Lab|null                          $fallback   = null,
        bool|null                         $throw      = null,
    ) :Lab {
        $changeThrow = $throw ?? true;

        return ColorFactory::newLab(
            value    : [
                utils\changeCoordinate($this->lightness, $lightness, false, $changeThrow),
                utils\changeCoordinate($this->a,         $a,         false, $changeThrow),
                utils\changeCoordinate($this->b,         $b,         false, $changeThrow),
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
        return utils\lab\stringify(
            lightness : $this->lightness,
            a         : $this->a,
            b         : $this->b,
            opacity   : $this->opacity,
            legacy    : $legacy,
            alpha     : $alpha,
            precision : $precision,
        );
    }

    /* #endregion */

}
