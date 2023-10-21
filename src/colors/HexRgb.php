<?php

namespace matthieumastadenis\couleur\colors;

use       matthieumastadenis\couleur\Color;
use       matthieumastadenis\couleur\ColorFactory;
use       matthieumastadenis\couleur\ColorInterface;
use       matthieumastadenis\couleur\utils;

class      HexRgb
extends    Color
implements ColorInterface {

    /* #region Constructor */

    public function __construct(
        public readonly string $red     = '00',
        public readonly string $green   = '00',
        public readonly string $blue    = '00',
        public readonly string $opacity = 'FF',
    ) {

    }

    /* #endregion */
    
    /* #region Public Static Methods */    
    
    public static function aliases(

    ) :array {
        return [
            'hex',
            'hexrgb',
            'hex-rgb',
            'hex_rgb',
            'hexadecimal',
        ];
    }

    /* #endregion */
    
    /* #region Public Methods */

    public function change(
        \Stringable|string|null $red       = null,
        \Stringable|string|null $green     = null,
        \Stringable|string|null $blue      = null,
        \Stringable|string|null $opacity   = null,
        HexRgb|null             $fallback  = null,
        bool|null               $throw     = null,
    ) :HexRgb {
        $changeThrow = $throw ?? true;

        return ColorFactory::newHexRgb(
            value    : [
                utils\changeCoordinate($this->red,     $red,     true, $changeThrow),
                utils\changeCoordinate($this->green,   $green,   true, $changeThrow),
                utils\changeCoordinate($this->blue,    $blue,    true, $changeThrow),
                utils\changeCoordinate($this->opacity, $opacity, true, $changeThrow),
            ],
            from     : $this::space(),
            fallback : $fallback,
            throw    : $throw,
        );
    } 
    
    public function stringify(
        bool|null $alpha     = null,
        bool      $short     = true,
        bool|null $uppercase = null,
        bool      $sharp     = true,
    ) :string {        
        return utils\hexRgb\stringify(
            red       : $this->red,
            green     : $this->green,
            blue      : $this->blue,
            opacity   : $this->opacity,
            alpha     : $alpha,
            short     : $short,
            uppercase : $uppercase,
            sharp     : $sharp,
        );
    }

    /* #endregion */
    
}
