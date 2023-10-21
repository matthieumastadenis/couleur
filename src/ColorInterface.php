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

/**
 * An immutable object representing a color expressed in a precise and supported color space.
 *
 * It can be converted to another supported color space using one of the to...() methods.
 * Variant instances can be created with the change() method.
 *
 */
interface ColorInterface
extends   \Stringable {

    /* #region Magic Methods */

    /**
     * Returns the color as a CSS string (examples: '#ff0000', 'rgb(100% 0% 0% / 100%)'...).
     * This method is a shortcut to calling the stringify() method with its default parameters.
     *
     * @return string
     */
    public function __toString(

    ) :string;

    /* #endregion */

    /* #region Public Static Methods */

    /**
     * Returns an array containing all supported aliases for the ColorSpace of the current color.
     *
     * @return array
     */
    public static function aliases(

    ) :array;

    /**
     * Returns the ColorSpace instance corresponding to the current color.
     *
     * @return ColorSpace
     */
    public static function space(

    ) :ColorSpace;

    /* #endregion */

    /* #region Public Methods */

    /**
     * Returns a new ColorInterface instance of the same class, with modified coordinates.
     * Each implementation of this method may add its own parameters, depending on the corresponding color space.
     *
     * @return ColorInterface
     */
    public function change(

    ) :self;

    /**
     * Returns an array containing all coordinates of the current color.
     *
     * @return array
     */
    public function coordinates(

    ) :array;

    /**
     * Returns the color as a CSS string (examples: '#ff0000', 'rgb(100% 0% 0% / 100%)'...)
     * Each implementation of this method may add its own parameters, depending on the corresponding color space.
     *
     * @return string
     */
    public function stringify(

    ) :string;

    /**
     * Returns a new ColorInterface instance corresponding to the current color converted into the $to color space.
     *
     * @param  ColorSpace|\Stringable|string|null $to       The desired output color space (can be an instance of the ColorSpace enum or a stringable alias)
     * @param  ColorInterface|null                $fallback A ColorInterface instance used as a fallback in case of failure
     * @param  boolean|null                       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return ColorInterface                               The converted color object
     */
    public function to(
        ColorSpace|\Stringable|string|null $to       = null,
        ColorInterface|null                $fallback = null,
        bool|null                          $throw    = null,
    ) :ColorInterface;

    /**
     * Returns a new colors\Css instance corresponding to the current color converted into the Css color space.
     *
     * @param  Css|null     $fallback A colors\Css instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return Css                    The converted color object
     */
    public function toCss(
        Css|null  $fallback = null,
        bool|null $throw    = null,
    ) :Css;

    /**
     * Returns a new colors\HexRgb instance corresponding to the current color converted into the HexRgb color space.
     *
     * @param  HexRgb|null  $fallback A colors\HexRgb instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return HexRgb                 The converted color object
     */
    public function toHexRgb(
        HexRgb|null $fallback = null,
        bool|null   $throw    = null,
    ) :HexRgb;

    /**
     * Returns a new colors\Hsl instance corresponding to the current color converted into the Hsl color space.
     *
     * @param  Hsl|null     $fallback A colors\Hsl instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return Hsl                    The converted color object
     */
    public function toHsl(
        Hsl|null  $fallback = null,
        bool|null $throw    = null,
    ) :Hsl;

    /**
     * Returns a new colors\Hsv instance corresponding to the current color converted into the Hsv color space.
     *
     * @param  Hsv|null     $fallback A colors\Hsv instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return Hsv                    The converted color object
     */
    public function toHsv(
        Hsv|null  $fallback = null,
        bool|null $throw    = null,
    ) :Hsv;

    /**
     * Returns a new colors\Hwb instance corresponding to the current color converted into the Hwb color space.
     *
     * @param  Hwb|null     $fallback A colors\Hwb instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return Hwb                    The converted color object
     */
    public function toHwb(
        Hwb|null  $fallback = null,
        bool|null $throw    = null,
    ) :Hwb;

    /**
     * Returns a new colors\Lab instance corresponding to the current color converted into the Lab color space.
     *
     * @param  Lab|null     $fallback A colors\Lab instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return Lab                    The converted color object
     */
    public function toLab(
        Lab|null  $fallback = null,
        bool|null $throw    = null,
    ) :Lab;

    /**
     * Returns a new colors\Lch instance corresponding to the current color converted into the Lch color space.
     *
     * @param  Lch|null     $fallback A colors\Lch instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return Lch                    The converted color object
     */
    public function toLch(
        Lch|null  $fallback = null,
        bool|null $throw    = null,
    ) :Lch;

    /**
     * Returns a new colors\LinP3 instance corresponding to the current color converted into the LinP3 color space.
     *
     * @param  LinP3|null   $fallback A colors\LinP3 instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return LinP3                  The converted color object
     */
    public function toLinP3(
        LinP3|null $fallback = null,
        bool|null  $throw    = null,
    ) :LinP3;

    /**
     * Returns a new colors\LinProPhoto instance corresponding to the current color converted into the LinProPhoto color space.
     *
     * @param  LinProPhoto|null $fallback A colors\LinProPhoto instance used as a fallback in case of failure
     * @param  boolean|null     $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return LinProPhoto                The converted color object
     */
    public function toLinProPhoto(
        LinProPhoto|null $fallback = null,
        bool|null        $throw    = null,
    ) :LinProPhoto;

    /**
     * Returns a new colors\LinRgb instance corresponding to the current color converted into the LinRgb color space.
     *
     * @param  LinRgb|null  $fallback A colors\LinRgb instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return LinRgb                 The converted color object
     */
    public function toLinRgb(
        LinRgb|null $fallback = null,
        bool|null   $throw    = null,
    ) :LinRgb;

    /**
     * Returns a new colors\OkLab instance corresponding to the current color converted into the OkLab color space.
     *
     * @param  OkLab|null   $fallback A colors\OkLab instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return OkLab                  The converted color object
     */
    public function toOkLab(
        OkLab|null $fallback = null,
        bool|null  $throw    = null,
    ) :OkLab;

    /**
     * Returns a new colors\OkLch instance corresponding to the current color converted into the OkLch color space.
     *
     * @param  OkLch|null   $fallback A colors\OkLch instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return OkLch                  The converted color object
     */
    public function toOkLch(
        OkLch|null $fallback = null,
        bool|null  $throw    = null,
    ) :OkLch;

    /**
     * Returns a new colors\P3 instance corresponding to the current color converted into the P3 color space.
     *
     * @param  P3|null      $fallback A colors\P3 instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return P3                     The converted color object
     */
    public function toP3(
        P3|null   $fallback = null,
        bool|null $throw    = null,
    ) :P3;

    /**
     * Returns a new colors\ProPhoto instance corresponding to the current color converted into the ProPhoto color space.
     *
     * @param  ProPhoto|null $fallback A colors\ProPhoto instance used as a fallback in case of failure
     * @param  boolean|null  $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return ProPhoto                The converted color object
     */
    public function toProPhoto(
        ProPhoto|null $fallback = null,
        bool|null     $throw    = null,
    ) :ProPhoto;

    /**
     * Returns a new colors\Rgb instance corresponding to the current color converted into the Rgb color space.
     *
     * @param  Rgb|null     $fallback A colors\Rgb instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return Rgb                    The converted color object
     */
    public function toRgb(
        Rgb|null  $fallback = null,
        bool|null $throw    = null,
    ) :Rgb;

    /**
     * Returns a new colors\XyzD50 instance corresponding to the current color converted into the XyzD50 color space.
     *
     * @param  XyzD50|null  $fallback A colors\XyzD50 instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return XyzD50                 The converted color object
     */
    public function toXyzD50(
        XyzD50|null $fallback = null,
        bool|null   $throw    = null,
    ) :XyzD50;

    /**
     * Returns a new colors\XyzD65 instance corresponding to the current color converted into the XyzD65 color space.
     *
     * @param  XyzD65|null  $fallback A colors\XyzD65 instance used as a fallback in case of failure
     * @param  boolean|null $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return XyzD65                 The converted color object
     */
    public function toXyzD65(
        XyzD65|null $fallback = null,
        bool|null   $throw    = null,
    ) :XyzD65;

    /* #endregion */

}
