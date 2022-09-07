<?php

namespace matthieumastadenis\couleur;

use       matthieumastadenis\couleur\colors\Css;
use       matthieumastadenis\couleur\colors\HexRgb;
use       matthieumastadenis\couleur\colors\Hsl;
use       matthieumastadenis\couleur\colors\Hsv;
use       matthieumastadenis\couleur\colors\Hwb;
use       matthieumastadenis\couleur\colors\Lab;
use       matthieumastadenis\couleur\colors\Lch;
use       matthieumastadenis\couleur\colors\LinP3;
use       matthieumastadenis\couleur\colors\LinProPhoto;
use       matthieumastadenis\couleur\colors\LinRgb;
use       matthieumastadenis\couleur\colors\OkLab;
use       matthieumastadenis\couleur\colors\OkLch;
use       matthieumastadenis\couleur\colors\P3;
use       matthieumastadenis\couleur\colors\ProPhoto;
use       matthieumastadenis\couleur\colors\Rgb;
use       matthieumastadenis\couleur\colors\XyzD50;
use       matthieumastadenis\couleur\colors\XyzD65;
use       matthieumastadenis\couleur\utils;

abstract class ColorFactory {

    /* #region Public Static Methods */    

    /**
     * Returns a new ColorInterface instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $to       The desired output color space (if not specified it will be the same as $from)
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  ColorInterface|null                $fallback A ColorInterface instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return ColorInterface|null
     */
    public static function new(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $to        = null,
        ColorSpace|\Stringable|string|null $from      = null,
        ColorInterface|null                $fallback  = null,
        bool|null                          $throw     = null,
    ) :ColorInterface|null {
        $throw ??= !$fallback;

        utils\setFromAndTo(
            value    : $value,
            to       : $to,
            from     : $from, 
            throw    : $throw, 
        );

        if (!($from instanceof ColorSpace)
        || !($to instanceof ColorSpace)) {
            return $fallback;
        }

        return new ($to->value)(... utils\toColor(
            value     : $value,
            to        : $to,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        ));
    }

    /**
     * Returns a new colors\Css instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  Css|null                           $fallback A colors\Css instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return Css|null
     */
    public static function newCss(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        Css|null                           $fallback  = null,
        bool|null                          $throw     = null,
    ) :Css|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::Css,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\HexRgb instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  HexRgb|null                        $fallback A colors\HexRgb instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return HexRgb|null
     */
    public static function newHexRgb(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        HexRgb|null                        $fallback  = null,
        bool|null                          $throw     = null,
    ) :HexRgb|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::HexRgb,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\Hsl instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  Hsl|null                           $fallback A colors\Hsl instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return Hsl|null
     */
    public static function newHsl(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        Hsl|null                           $fallback  = null,
        bool|null                          $throw     = null,
    ) :Hsl|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::Hsl,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\Hsv instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  Hsv|null                           $fallback A colors\Hsv instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return Hsv|null
     */
    public static function newHsv(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        Hsv|null                           $fallback  = null,
        bool|null                          $throw     = null,
    ) :Hsv|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::Hsv,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\Hwb instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  Hwb|null                           $fallback A colors\Hwb instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return Hwb|null
     */
    public static function newHwb(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        Hwb|null                           $fallback  = null,
        bool|null                          $throw     = null,
    ) :Hwb|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::Hwb,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\Lab instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  Lab|null                           $fallback A colors\Lab instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return Lab|null
     */
    public static function newLab(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        Lab|null                           $fallback  = null,
        bool|null                          $throw     = null,
    ) :Lab|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::Lab,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\Lch instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  Lch|null                           $fallback A colors\Lch instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return Lch|null
     */
    public static function newLch(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        Lch|null                           $fallback  = null,
        bool|null                          $throw     = null,
    ) :Lch|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::Lch,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\LinP3 instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  LinP3|null                         $fallback A colors\LinP3 instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return LinP3|null
     */
    public static function newLinP3(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        LinP3|null                         $fallback  = null,
        bool|null                          $throw     = null,
    ) :LinP3|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::LinP3,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\LinProPhoto instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  LinProPhoto|null                   $fallback A colors\LinProPhoto instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return LinProPhoto|null
     */
    public static function newLinProPhoto(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        LinProPhoto|null                   $fallback  = null,
        bool|null                          $throw     = null,
    ) :LinProPhoto|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::LinProPhoto,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\LinRgb instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  LinRgb|null                        $fallback A colors\LinRgb instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return LinRgb|null
     */
    public static function newLinRgb(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        LinRgb|null                        $fallback  = null,
        bool|null                          $throw     = null,
    ) :LinRgb|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::LinRgb,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\OkLab instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  OkLab|null                         $fallback A colors\OkLab instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return OkLab|null
     */
    public static function newOkLab(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        OkLab|null                         $fallback  = null,
        bool|null                          $throw     = null,
    ) :OkLab|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::OkLab,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\OkLch instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  OkLch|null                         $fallback A colors\OkLch instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return OkLch|null
     */
    public static function newOkLch(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        OkLch|null                         $fallback  = null,
        bool|null                          $throw     = null,
    ) :OkLch|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::OkLch,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\P3 instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  P3|null                            $fallback A colors\P3 instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return P3|null
     */
    public static function newP3(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        P3|null                            $fallback  = null,
        bool|null                          $throw     = null,
    ) :P3|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::P3,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\ProPhoto instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  ProPhoto|null                      $fallback A colors\ProPhoto instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return ProPhoto|null
     */
    public static function newProPhoto(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        ProPhoto|null                      $fallback  = null,
        bool|null                          $throw     = null,
    ) :ProPhoto|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::ProPhoto,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\Rgb instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  Rgb|null                           $fallback A colors\Rgb instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return Rgb|null
     */
    public static function newRgb(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        Rgb|null                           $fallback  = null,
        bool|null                          $throw     = null,
    ) :Rgb|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::Rgb,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\XyzD50 instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  XyzD50|null                        $fallback A colors\XyzD50 instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return XyzD50|null
     */
    public static function newXyzD50(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        XyzD50|null                        $fallback  = null,
        bool|null                          $throw     = null,
    ) :XyzD50|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::XyzD50,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new colors\XyzD65 instance corresponding to $value. 
     *
     * @param  mixed                              $value    A color string (like '#ff0000' or 'rgb(255,0,0)') or a coordinates array (like [ 'ff', '00', '00' ] or [ 255, 0, 0])
     * @param  ColorSpace|\Stringable|string|null $from     The input color space (if not specified it will be automatically guessed by interpreting the format of $value)
     * @param  XyzD65|null                        $fallback A colors\XyzD65 instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     * 
     * @return XyzD65|null
     */
    public static function newXyzD65(
        mixed                              $value,
        ColorSpace|\Stringable|string|null $from      = null,
        XyzD65|null                        $fallback  = null,
        bool|null                          $throw     = null,
    ) :XyzD65|null {
        return static::new(
            value     : $value,
            to        : ColorSpace::XyzD65,
            from      : $from,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /* #endregion */
    
}