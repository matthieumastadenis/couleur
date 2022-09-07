# 🎨 Couleur: A modern PHP 8.1+ color library

- [🎨 Couleur: A modern PHP 8.1+ color library](#-couleur-a-modern-php-81-color-library)
  - [👋 Presentation](#-presentation)
  - [⚙️ Installation](#️-installation)
  - [🏁 Quick Start](#-quick-start)
  - [📚 Usage](#-usage)
    - [🏭 Immutable Objects and the `ColorFactory`](#-immutable-objects-and-the-colorfactory)
      - [Direct instanciation](#direct-instanciation)
      - [Using the `ColorFactory`](#using-the-colorfactory)
      - [Using immutable color objects](#using-immutable-color-objects)
    - [🧰 Pure Functions](#-pure-functions)
      - [Color Space Functions](#color-space-functions)
      - [Conversion Functions](#conversion-functions)
      - [Generic Functions](#generic-functions)
    - [🛠️ Enums and Constants](#️-enums-and-constants)
      - [The `Constant` Enum](#the-constant-enum)
      - [The `ColorSpace` Enum](#the-colorspace-enum)
      - [The `CssColor` Enum](#the-csscolor-enum)
  - [🌈 Color Spaces](#-color-spaces)
    - [CSS](#css)
    - [Hexadecimal RGB](#hexadecimal-rgb)
    - [HSL](#hsl)
    - [HSV](#hsv)
    - [HWB](#hwb)
    - [Lab](#lab)
    - [Lch](#lch)
    - [Linear RGB](#linear-rgb)
    - [Linear P3](#linear-p3)
    - [Linear ProPhoto](#linear-prophoto)
    - [OkLab](#oklab)
    - [OkLch](#oklch)
    - [P3](#p3)
    - [ProPhoto](#prophoto)
    - [RGB](#rgb)
    - [XYZ-D50](#xyz-d50)
    - [XYZ-D65](#xyz-d65)
  - [🤝 Contributing](#-contributing)
  - [📜 License](#-license)
  - [❤️ Thanks](#️-thanks)

## 👋 Presentation

**Couleur** is a modern **PHP 8.1+ color library**, intended to be compatible with **[CSS Color Module Level 4](https://drafts.csswg.org/css-color-4)**, and inspired by **[Color.js](https://github.com/LeaVerou/color.js)** from [Lea Verou](https://github.com/LeaVerou) and [Chris Lilley](https://github.com/svgeesus).

The main goal of this package is to allow **color conversions** between multiple, old and new [🌈 Color Spaces](#-color-spaces), like the famous **LCH** which provides [many advantages for design purpose](https://lea.verou.me/2020/04/lch-colors-in-css-what-why-and-how/).

**Couleur** is made to be usable with an **[OOP](https://en.wikipedia.org/wiki/Object-oriented_programming)** approach as well as with a **[FP](https://en.wikipedia.org/wiki/Functional_programming)** approach:

- If you prefer **OOP**, you can use [🏭 Immutable Objects and the `ColorFactory`](#-immutable-objects-and-the-colorfactory) ;
- If you prefer **FP**, you can directly use the multiple [🧰 Pure Functions](#-pure-functions) ;

> **Warning**:
> This package is currently under development.
>
> The current version may include bugs, untested code, undocumented code, unfinished code, or simply code that will change. More specifically, for the moment there is a lack of *unit tests*, and a few *color spaces* as well as *distance calculation functions* and *gammut correction* remain to be implemented. All of these will come soon.
>
> In the meantime, it is recommended to avoid using this package in production.

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

## ⚙️ Installation

Use the following command to add **Couleur** to your project with [Composer](https://getcomposer.org/):

```bash
composer require matthieumastadenis/couleur
```

Don't forget to include the [autoloader](https://getcomposer.org/doc/01-basic-usage.md#autoloading) provided by Composer:

```php
<?php

require 'vendor/autoload.php';
```

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

## 🏁 Quick Start

The following is a quick *tl;dr* example of the simplest way to use **Couleur**, based on an OOP approach. For more detailed instructions, please read the [📚 Usage](#-usage) section.

```php
<?php

use matthieumastadenis\couleur\ColorFactory;
use matthieumastadenis\couleur\ColorSpace;

require 'vendor/autoload.php';

// Create a new colors\Css instance from an HSL array:
$css1 = ColorFactory::newCss([ 0, 100, 50 ], ColorSpace::Hsl);
echo $css1; // Prints 'red'

// Convert to RGB:
$rgb1 = $css1->toRgb();

// Stringify:
echo $rgb1;                                          // Prints 'rgb(100% 0% 0%)'
echo $rgb1->stringify();                             // Prints 'rgb(100% 0% 0%)'
echo $rgb1->stringify(legacy : false, alpha : true); // Prints 'rgb(100% 0% 0% / 100%)'
echo $rgb1->stringify(legacy : true);                // Prints 'rgb(255,0,0)'
echo $rgb1->stringify(legacy : true, alpha : true);  // Prints 'rgba(255,0,0,1)'

// Create a variant color:
$rgb2 = $rgb1->change('-35', '+20', 60);
echo $rgb2->stringify(legacy : true); // Prints 'rgb(220,20,60)';

// Convert to CSS:
$css2 = $rgb2->toCss();
echo $css2; // Prints 'crimson'

// Convert to Lch:
$lch = $css2->toLch();
echo $lch->stringify(alpha : true); // Prints 'lch(47.878646049% 79.619059282 26.464486652deg / 100%)'

// Convert to P3:
$p3 = $lch->toP3();
echo $p3; // Prints 'color(display-p3 0.791710722 0.191507424 0.257366748)'

```

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

## 📚 Usage

### 🏭 Immutable Objects and the `ColorFactory`

#### Direct instanciation

**Couleur** provides one **immutable class** for each supported [🌈 Color Space](#-color-spaces). You can of course instantiate these classes manually:

```php
<?php

use matthieumastadenis\couleur\colors\Rgb;
use matthieumastadenis\couleur\colors\Hsl;

require 'vendor/autoload.php';

// Create a new colors\Css instance:
$rgb = new Css('red');

// Create a new colors\HexRgb instance (with 50% opacity):
$hex = new HexRgb('FF', '00', '00', '80');

// Create a new colors\Hsl instance (with 50% opacity):
$hsl = new Hsl(0, 100, 50, 50);

// Create a new colors\Rgb instance (with 50% opacity):
$rgb = new Rgb(255, 0, 0, 127.5);

```

> **Note** :
> You may have noticed from the previous example that it implies passing *correctly formatted* values to each constructor.
>
> For example, the `Rgb` class expects to receive opacity expressed in the same magnitude than red, green and blue values, meaning *as a number between 0 and 255*. Same thing for the `HexRgb` class which expects only *hexadecimal strings* for each of the four parameters it takes (opacity included).
>
> Because of this, you may prefer to avoid instanciating these classes yourself. A simpler solution is to [use the ColorFactory](#using-the-colorfactory) like in the following examples. It will automatically handle *values conversion* for you.

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

#### Using the `ColorFactory`

The best and simplest way to create color objects is by using the `ColorFactory` **abstract class** which provides a specific **static method** for each supported [🌈 Color Space](#-color-spaces):

```php
<?php

use matthieumastadenis\couleur\ColorFactory;

require 'vendor/autoload.php';

// Returns a new colors\Rgb instance (with 50% opacity):
$rgb1 = ColorFactory::newRgb('rgba(255,0,0,.5)');

// Returns a new colors\Lab instance:
$lab1 = ColorFactory::newLab('lab(54.29%,80.80,69.89,1)');

// Using a string value formatted with modern CSS syntax works as well:
$rgb2 = ColorFactory::newRgb('rgb(100% 0% 0% / 50%)');
$lab2 = ColorFactory::newLab('lab(54.29% 80.80 69.89 / 100%)');

// Using an array as a value also works:
$rgb3 = ColorFactory::newRgb([ 255, 0, 0, 127.5 ]);
$lab3 = ColorFactory::newLab([ 54.29, 80.80, 69.89, 100 ]);

```

Note that by default these methods are **automatically guessing** the input syntax. This means it's possible to provide an input value in a different format than the expected output, and the **conversion** will happen automatically:

```php
<?php

use matthieumastadenis\couleur\ColorFactory;

require 'vendor/autoload.php';

// Returns a new colors\Rgb instance from a CSS input:
$rgb = ColorFactory::newRgb('red');

// Returns a new colors\Css instance from a HSL input:
$css = ColorFactory::newCss('hsl(0deg,100%,50%)');

// Returns a new colors\XyzD65 instance from a Lab input:
$xyzD65 = ColorFactory::newXyzD65('lab(54.29% 80.80 69.89 / 100%)');

```

If you use an incorrectly formated value, a `UnknownColorSpace` **Exception** will be thrown:

```php
<?php

use matthieumastadenis\couleur\ColorFactory;

require 'vendor/autoload.php';

try {
    // Throws a UnknownColorSpace Exception:
    $rgb = ColorFactory::newRgb('not valid');
}
catch (\Exception $e) {
    die($e); // Unknown color space
}

```

Also if you use an incomplete value, a `MissingColorValue` **Exception** will be thrown:

```php
<?php

use matthieumastadenis\couleur\ColorFactory;

require 'vendor/autoload.php';

try {
    // Throws a MissingColorValue Exception:
    $rgb = ColorFactory::newRgb('rgb(255,0)');
}
catch (\Exception $e) {
    die($e); // Color value "blue" is missing
}

```

By using the `$from` parameter, you can specify the *input color space* with a *string alias* or with the [ColorSpace enum](#the-colorspace-enum). Like before, the value will automatically be converted from it to the targetted space.

Specifying this is particularly helpful when you're using an array as input, to be sure it will not be treated as RGB (which is the default for an array of numbers):

```php
<?php

use matthieumastadenis\couleur\ColorFactory;
use matthieumastadenis\couleur\ColorSpace;

require 'vendor/autoload.php';

// Without the $from parameter, array values are considered as RGB values by default:
$rgb1 = ColorFactory::newRgb([ 0, 100, 50 ]);
\var_dump($rgb1->coordinates()); // [ 0, 100, 50, 255 ]

// With the $from parameter, we can ensure that the input value will be treated like we want
// The following line creates a new colors\Rgb instance from an HSL input:
$rgb2 = ColorFactory::newRgb([ 0, 100, 50 ], 'hsl');
\var_dump($rgb2->coordinates()); // [ 255, 0, 0, 255 ]

// Same result, but with usage of the ColorSpace enum:
$rgb3 = ColorFactory::newRgb([ 0, 100, 50 ], ColorSpace::Hsl);
\var_dump($rgb3->coordinates()); // [ 255, 0, 0, 255 ]

```

You can alternatively use the `new()` **static method**, which adds a `$to` parameter just after the input value. If this parameter is not specified, the *targetted color space* will automatically be determined according to the format of the value:

```php
<?php

use matthieumastadenis\couleur\ColorFactory;
use matthieumastadenis\couleur\ColorSpace;

require 'vendor/autoload.php';

// Returns a new colors\Rgb instance (space guessed automatically):
$rgb = ColorFactory::new('rgb(255,0,0)');

// Returns a new colors\HexRgb instance (space guessed automatically):
$hex = ColorFactory::new('#ff0000');

// Returns a new colors\Css instance (space guessed automatically):
$css = ColorFactory::new('red');

// Returns a new colors\Css instance from an RGB value:
$css = ColorFactory::new('rgb(255,0,0)', 'css');

// Same result but using the ColorSpace enum:
$css = ColorFactory::new('rgb(255,0,0)', ColorSpace::Css);

// Returns a new colors\Lch instance (using the ColorSpace enum):
$lch = ColorFactory::new([ 54.29, 106.84, 40.86 ], ColorSpace::Lch);

// Returns a new colors\OkLab instance from an RGB value (using the ColorSpace enum):
$okLab = ColorFactory::new([ 255, 0, 0 ], ColorSpace::OkLab, ColorSpace::Rgb);

```

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

#### Using immutable color objects

Once you have a color instance, you can easily convert it to another color space using one of its dedicated `to...()` methods, which will return a new object:

```php
<?php

use matthieumastadenis\couleur\ColorFactory;
use matthieumastadenis\couleur\ColorSpace;

require 'vendor/autoload.php';

$rgb = ColorFactory::newRgb([ 255, 0, 0 ]);

// Converting to a new colors\Css instance:
$css = $rgb->toCss();

// Converting to a new colors\XyzD50 instance:
$xyzD50 = $css->toXyzD50();

// Converting to a new colors\OkLch instance (using the to() method):
$okLch = $xyzD50->to(ColorSpace::OkLch);

```

Note that **any color** can be converted to CSS with the `toCss()` method. It will automatically pick the *closest* CSS color:

```php
<?php

use matthieumastadenis\couleur\ColorFactory;

require 'vendor/autoload.php';

$rgb = ColorFactory::newRgb([ 250, 10, 10 ]);
$css = $rgb->toCss();

// Prints 'red':
echo $css;

```

All color objects are directly **stringable**. They also provide a `stringify()` method which offers more possibilities:

```php
<?php

use matthieumastadenis\couleur\ColorFactory;
use matthieumastadenis\couleur\ColorSpace;

require 'vendor/autoload.php';

$rgb = ColorFactory::newRgb([ 255, 0, 0 ]);

// Prints 'rgb(100% 0% 0%)':
echo $rgb;

// Prints 'rgb(100% 0% 0% / 100%)' ($alpha parameter):
echo $rgb->stringify(null, true);

// Prints 'rgba(255,0,0,1)' (using $legacy and $alpha parameters):
echo $rgb->stringify(true, true);

$lch = ColorFactory::newLch([ 54.2905429, 106.837191, 40.8576688 ], ColorSpace::Lch);

// Prints 'lch(54.29% 106.84 40.86deg)' Using the $precision parameter:
echo $lch->stringify(precision : 2);

```

All color objects also have a `coordinates()` method which returns an array:

```php
<?php

use matthieumastadenis\couleur\ColorFactory;

require 'vendor/autoload.php';

$hex = ColorFactory::newHexRgb('#F00');

// Returns [ 'FF', '00', '00', 'FF' ]:
$values = $hex->coordinates();

```

You can also directly access **readonly properties** from each color object:

```php
<?php

use matthieumastadenis\couleur\ColorFactory;

require 'vendor/autoload.php';

$rgb = ColorFactory::newRgb([ 255, 0, 0 ]);

// Prints 255:
echo $rgb->red;

$hsl = ColorFactory::newHsl([ 0, 100, 50 ]);

// Prints 50:
echo $hsl->lightness;

```

All color objects have a `change()` method which always return a *new object* corresponding to a *variant* of the current color.

```php
<?php

use matthieumastadenis\couleur\ColorFactory;
use matthieumastadenis\couleur\ColorSpace;

require 'vendor/autoload.php';

$hsl1 = ColorFactory::newHsl([ 0, 100, 50, 100 ], ColorSpace::Hsl);
echo $hsl1; // hsl(0deg 100% 50% / 100%)

// Redefining coordinates:
$hsl2 = $hsl1->change(hue : 180, opacity : 80);
echo $hsl2; // hsl(180deg 100% 50% / 80%)

// Add, subtract, multiply, divide coordinates:
$hsl3 = $hsl2->change('+20', '-10', '*1.5', '/2');
echo $hsl3; // hsl(200deg 90% 75% / 40%)

// Reduce coordinates by modulus:
$hsl4 = $hsl3->change(opacity : '%6');
echo $hsl4; // hsl(200deg 90% 75% / 4%)

// Calculate the percentage of coordinates:
$hsl5 = $hsl4->change('50%');
echo $hsl5; // hsl(100deg 90% 75% / 4%)

// Add, subtract, multiply, divide coordinates by a percentage:
$hsl6 = $hsl5->change('+50%', '-50%', '/10%', '*200%');
echo $hsl6; // hsl(150deg 45% 10% / 32%)

// Reduce coordinates by a percentage modulus:
$hsl7 = $hsl6->change(saturation : '%20%');
echo $hsl7; // hsl(150deg 0% 10% / 32%)

```

> **Note**:
> The `change()` method of the `HexRgb` class behave differently depending on the operation you asks for :
>
> - For replacing a coordinate you have to provide an **hexadecimal value** ;
> - For additions and substractions you have to provide an **hexadecimal value** ;
> - For all other operactions you have to provide a **decimal value** ;
>
> Please observe the detailed demonstration in the next example:

```php
<?php

use matthieumastadenis\couleur\ColorFactory;
use matthieumastadenis\couleur\ColorSpace;

require 'vendor/autoload.php';

$hex1 = ColorFactory::newHexRgb('#F00');
echo $hex1; // #F00

// When replacing coordinates, provide hexadecimal numbers:
$hex2 = $hex1->change('80', 'AA', 'BB', 'AA');
echo $hex2; // #80AABBAA

// When adding or subtracting coordinates, provide hexadecimal numbers:
$hex3 = $hex2->change('+8', '-11');
echo $hex3; // #89BA (88 99 BB AA)

// When multiplying, dividing or reducing coordinates by modulo, provide decimal numbers:
$hex4 = $hex3->change(null, '*1.5', '/2', '%3');
echo $hex4; // #88E65E02 (88 dechex(153*1.5) dechex(187/2) dechex(170%3))

// When using percentages, provide decimal numbers:
$hex5 = $hex4->change('20%');
echo $hex5; // #1BE65E02 (dechex(136*20/100) E6 5E 02)

// When using percentages with addition, substraction, multiplication or division, provide decimal numbers:
$hex6 = $hex5->change('+50%', '-20%', '/2%', '*200%');
echo $hex6; // #29B83208 (dechex(27+(27*50/100)) dechex(230-(230*20/100)) dechex(94/(84*2/100)) dechex(2*(2*200/100)))

// When using percentages with modulo, provide decimal numbers:
$hex7 = $hex6->change(green : '%4%');
echo $hex7; // #29023208 (29 dechex(184%(184*4/100)) 32 08)

```

> **Note**:
> The `change()` method of the `Css` class also behave differently: it only accepts a stringable color name or an instances of [the CssColor Enum](#the-csscolor-enum), which replace the color without variations.
>
> Please observe the next example:

```php
<?php

use matthieumastadenis\couleur\ColorFactory;
use matthieumastadenis\couleur\CssColor;

require 'vendor/autoload.php';

$css1 = ColorFactory::newCss(CssColor::red);
echo $css1; // red

$css2 = $css1->change(CssColor::purple);
echo $css2; // purple

$css2 = $css1->change(CssColor::purple);
echo $css2; // purple

$css3 = $css2->change('hotpink');
echo $css3; // hotpink

// Throws an UnsupportedCssColor Exception:
$css4 = $css3->change('invalid');

```

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

### 🧰 Pure Functions

Objects in **Couleur** are all based on a collection of **pure functions** under the hood. These functions can be used directly if you don't want to use objects.

> **Note**:
> Choosing this *functional programming approach* is better in terms of performance, but can be a bit more tedious because you have to manipulate arrays of values instead of objects.

There are three main types of functions provided by **Couleur** : dedicated [Color Space Functions](#color-space-functions), dedicated [Conversion Functions](#conversion-functions), and [Generic Functions](#generic-functions):

#### Color Space Functions

Each supported [🌈 Color Space](#-color-spaces) has its own dedicated functions, accessible under the namespace `matthieumastadenis\couleur\utils\[space]`. Those are the same for each color space: `clean()`, `from()`, `stringify()` and `verify()`.

`clean()` functions are made to transform an input value in a correctly formated set of values, according to the corresponding color space. They all return an array, except for `css\clean()` which directly returns an instance of the [the `CssColor` Enum](#the-csscolor-enum):

```php

<?php

use matthieumastadenis\couleur\utils\css;
use matthieumastadenis\couleur\utils\rgb;
use matthieumastadenis\couleur\utils\lch;

require 'vendor/autoload.php';

// All of the following return ColorSpace::red:
$css1 = css\clean('red');
$css2 = css\clean(' red ');
$css3 = css\clean('RED');

// All of the following return [ 255, 0, 0, 255 ]:
$rgb1 = rgb\clean([ '100%', '0%', '0%', '100%' ]);
$rgb2 = rgb\clean([ 255, 0, 0, '100%' ]);
$rgb3 = rgb\clean('rgb(255,0,0)');
$rgb4 = rgb\clean('rgba(255,0,0,1)');
$rgb5 = rgb\clean('rgb(100% 0 0 / 100%)');
$rgb6 = rgb\clean('color(rgb 100% 0 0 / 100%)');

// All of the following return [ 54.2905429, 106.837191, 40.8576688, 100 ]:
$lch1 = lch\clean([ 54.2905429, 106.837191, 40.8576688 ]);
$lch2 = lch\clean([ '54.2905429%', '106.837191', '40.8576688deg' ]);
$lch3 = lch\clean('lch(54.2905429%,106.837191,40.8576688deg)');
$lch4 = lch\clean('lch(54.2905429% 106.837191 40.8576688deg / 100%)');
$lch5 = lch\clean('color(lch 54.2905429% 106.837191 40.8576688deg)');
$lch6 = lch\clean('color(lch 54.2905429% 106.837191 40.8576688deg / 100%)');

```

`from()` functions **convert** and **clean** an input value from the specified color space (with the `$from` parameter) to the color space corresponding to the used namespace. If no *input color space* is specified with the `$from` parameter, it will be automatically guessed from the format of the `$value`:

```php
<?php

use matthieumastadenis\couleur\utils\rgb;
use matthieumastadenis\couleur\utils\lch;
use matthieumastadenis\couleur\ColorSpace;

require 'vendor/autoload.php';

// All of the following convert and clean from CSS to RGB,
// returning [ 255, 0, 0, 255 ]:
$rgb1 = rgb\from('red');
$rgb2 = rgb\from('red', ColorSpace::Css);

// All of the following convert and clean from RGB to HSL,
// returning [ 0, 100, 50, 100 ]:
$hsl1 = hsl\from([ 255, 0, 0, 255 ]);
$hsl2 = hsl\from('rgb(100% 0% 0% / 100%)');
$hsl3 = hsl\from('rgba(255,0,0,1)', 'rgb');
$hsl4 = hsl\from('rgba(255,0,0,1)', ColorSpace::Rgb);

```

`stringify()` functions return a *color string* fully compatible with CSS syntax. Depending of each color space, these functions can have the following parameters:

- `$sharp` : only for `HexRgb` colors, this can be used to include or not the hexadecimal sharp character (#) ;
- `$short` : only for `HexRgb` colors, this can be used to force or prevent the shortening of the value (#f00 instead of #ff0000) ;
- `$uppercase` : only for `HexRgb` colors, this can be used to force the conversion to uppercase or lowercase (by default the case is preserved) ;
- `$alpha` : can be used to force  or prevent the inclusion of opacity (by default opacity is included only if it has a value other than 100%) ;
- `$precision` : number of decimals used to round values (by defaut the [`COULEUR_PRECISION` constant](#the-constant-enum) is used) ;
- `$legacy` : if true the color string will be formatted according to the traditional CSS syntax rather than the modern one (rgba(255,0,0,1) instead of rgb(100% 0% 0% / 100%)) ;

```php
<?php

use matthieumastadenis\couleur\utils\hexRgb;
use matthieumastadenis\couleur\utils\rgb;
use matthieumastadenis\couleur\utils\xyzD65;

require 'vendor/autoload.php';

// Prints '#F00':
echo hexRgb\stringify('FF', '00', '00');

// Prints 'FF0' (using the $sharp parameter):
echo hexRgb\stringify('FF', '00', '00', sharp : false);

// Prints '#F00' (using array destructuring on clean() result):
echo hexRgb\stringify(... hexRgb\clean('#FF0000'));

// Prints '#FF0000' (using $short parameter):
echo hexRgb\stringify('FF', '00', '00', short : false);

// Prints '#F00F' (using $alpha parameter):
echo hexRgb\stringify('FF', '00', '00', alpha : true);

// Prints '#FF0000FF' (using $alpha and $short parameters):
echo hexRgb\stringify('FF', '00', '00', alpha : true, short : false);

// Prints 'rgb(100% 0% 0%)':
echo rgb\stringify(255, 0, 0);

// Prints 'rgb(100% 0% 0%)' (using array destructuring on clean() result):
echo rgb\stringify(... rgb\clean('rgb(255,0,0,1)'));

// Prints 'rgb(100% 0% 0% / 100%)' (using $alpha parameter):
echo rgb\stringify(255, 0, 0, alpha : true);

// Prints 'rgb(255,0,0)' (using $legacy parameter):
echo rgb\stringify(255, 0, 0, legacy : true);

// Prints 'rgba(255,0,0,1)' (using $legacy and $alpha parameters):
echo rgb\stringify(255, 0, 0, legacy : true, alpha : true);

// Prints 'color(xyz-d65 0.412390799 0.212639006 0.019330819)':
echo xyzD65\stringify(0.412390799, 0.212639006, 0.019330819);

// Prints 'color(xyz-d65 0.412390799 0.212639006 0.019330819 / 100%)' (using $alpha parameter):
echo xyzD65\stringify(0.412390799, 0.212639006, 0.019330819, alpha : true);

```

`verify()` functions simply return a **boolean** indicating if the input value matches the corresponding *color space*:

```php
<?php

use matthieumastadenis\couleur\utils\css;
use matthieumastadenis\couleur\utils\hexRgb;
use matthieumastadenis\couleur\utils\hsl;

require 'vendor/autoload.php';

// Returns true:
\var_dump(css\verify('red'));

// Returns false:
\var_dump(css\verify('invalid'));

// All of the following return true:
\var_dump(hexRgb\verify('f00'));
\var_dump(hexRgb\verify('f00f'));
\var_dump(hexRgb\verify('ff0000'));
\var_dump(hexRgb\verify('ff0000ff'));
\var_dump(hexRgb\verify('#f00'));
\var_dump(hexRgb\verify('#f00f'));
\var_dump(hexRgb\verify('#ff0000'));
\var_dump(hexRgb\verify('#ff0000ff'));

// Returns false:
\var_dump(hexRgb\verify('invalid'));

// The following also return false, because they eventually could be mistaken for RGB values:
\var_dump(hexRgb\verify([ 'ff', '00', '00' ]));
\var_dump(hexRgb\verify([ 'ff', '00', '00', 'ff' ]));

// All of the following return true:
\var_dump(hsl\verify('hsl(0,100,50)'));
\var_dump(hsl\verify('hsl(0deg,100%,50%)'));
\var_dump(hsl\verify('hsla(0,100,50,1)'));
\var_dump(hsl\verify('hsla(0deg,100%,50%,1)'));
\var_dump(hsl\verify('color(hsl,0,100,50,1)'));
\var_dump(hsl\verify('color(hsl,0deg,100%,50%,1)'));
\var_dump(hsl\verify('color(hsl 0 100 50 / 1)'));
\var_dump(hsl\verify('color(hsl 0deg 100% 50% / 1)'));

// All of the following return false:
\var_dump(hsl\verify('0,100,50'));
\var_dump(hsl\verify('hsl 0,100'));

// The following also return false, because they eventually could be mistaken for RGB values:
\var_dump(hexRgb\verify([ 0, 100, 50 ]));
\var_dump(hexRgb\verify([ '0deg', '100%', '50%' ]));

```

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

#### Conversion Functions

Each supported [🌈 Color Space](#-color-spaces) has a complete set of dedicated functions to **convert** into other *color spaces*. These are also accessible under the namespace `matthieumastadenis\couleur\utils\[space]`:

```php
<?php

use matthieumastadenis\couleur\utils\css;
use matthieumastadenis\couleur\utils\rgb;
use matthieumastadenis\couleur\CssColor;

require 'vendor/autoload.php';

// Returns [ 255, 0, 0, 255 ]:
$rgb = css\toRgb(CssColor::red);

// Returns [ 0, 100, 50, 100 ]:
$hsl = rgb\toHsl(... $rgb);

// Returns [  0.43606574282481, 0.22249319175624, 0.013923904500943, 1 ]
$xyzD50 = hsl\toXyzD50(... $hsl);

```

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

#### Generic Functions

**Couleur** also offers an ensemble of **generic utilitary functions**, all located under the namespace `matthieumastadenis\couleur\utils`.

If the majority of these functions are mostly made for interal usages, a few can be useful to you if you prefer to use **Couleur** with a *functional programming approcach*. These are described below.

The `constant()` function can be used to access and declare **configuration constants** direclty, without the need to use [the `Constant` Enum](#the-constant-enum):

```php
<?php

use matthieumastadenis\couleur\utils;

require 'vendor/autoload.php';

// Returns null:
\var_dump(utils\constant('unknown'));

// Returns 7:
\var_dump(utils\constant('precision', 7));

// Creates the constant with a value of 3, then returns 3:
\var_dump(utils\constant('precision', 3, true));

// Now that the constant was created, always returns 3:
\var_dump(utils\constant('precision'));

```

The `findColorSpace()` function helps you to guess a [🌈 Color Space](#-color-spaces) by interpreting a provided `$value`.

If the function succeeds, it returns an instance of [the `ColorSpace` Enum](#the-colorspace-enum).

In case of failure, the function will throw a `UnknownColorSpace` by default, except if you set the `$throw` parameter to `false` or if you provide a `$fallback` value.

```php
<?php

use matthieumastadenis\couleur\utils;
use matthieumastadenis\couleur\ColorSpace;

require 'vendor/autoload.php';

// Returns ColorSpace::Css:
$space = utils\findColorSpace('red');

// Returns ColorSpace::Rgb:
$space = utils\findColorSpace('rgba(255,0,0,1)');

// Also returns ColorSpace::Rgb:
$space = utils\findColorSpace([ 255, 0, 0, 255 ]);

// Throws a UnknownColorSpace Exception:
$space = utils\findColorSpace('invalid');

// Returns ColorSpace::Rgb (using the $fallback parameter):
$space = utils\findColorSpace('invalid', ColorSpace::Rgb);

// Returns null (using the $throw parameter):
$space = utils\findColorSpace('invalid', throw : false);

```

The `isColorString()` function returns a **boolean** indicating if the provided `$value` is a valid CSS color string.

By default it is very tolerant and will return `true` for any string corresponding to a valid CSS syntax, regardless of how you wrote the function name (meaning something like 'myCustomRgb(255,0,0)' will be considered as valid).

If you want a more precise check, you can use the `$spaces` parameter to provide either:

- an unique stringable value, like `'rgb'` ;
- an array of accepted values, like `[ 'rgb', 'rgba' ]` ;
- an instance of [the `ColorSpace` Enum](#the-colorspace-enum) (all of its aliases will be accepted) ;

```php
<?php

use matthieumastadenis\couleur\utils;
use matthieumastadenis\couleur\ColorSpace;

require 'vendor/autoload.php';

// All of the following return true:
\var_dump(utils\isColorString('myCustomColor(255,0,0,1)'));
\var_dump(utils\isColorString('rgb(100% 0% 0% / 100%)', 'rgb'));
\var_dump(utils\isColorString('rgba(255,0,0,1)', [ 'rgb', 'rgba' ]));
\var_dump(utils\isColorString('color(srgb 100% 0% 0% / 100%)', ColorSpace::Rgb));

// All of the following return false:
\var_dump(utils\isColorString('invalid'));
\var_dump(utils\isColorString('rgb 100%'));
\var_dump(utils\isColorString('255,0,0'));
\var_dump(utils\isColorString('rgba(255,0,0,1)', 'rgb'));
\var_dump(utils\isColorString('srgb(255,0,0,1)', [ 'rgb', 'rgba' ]));
\var_dump(utils\isColorString('myCustomRgb( 100% 0% 0% / 100%)', ColorSpace::Rgb));
\var_dump(utils\isColorString('color(myCustomRgb 100% 0% 0% / 100%)', ColorSpace::Rgb));

```

The `parseColorValue()` function transforms a *CSS color string* into an array of values. If the provided `$value` is not stringable, it will simply be returned as an array.

The `$opacityFactor` parameter is useful to convert opacity into the correct range (for example converting 1 to 100 or 255).

> **Note** :
> This function does not *clean* values inside of the array. For a typical usage, you may want to pass its result into the corresponding `clean()` function (see the [Color Space Functions](#color-space-functions) section for more details).

```php
<?php

use matthieumastadenis\couleur\utils;
use matthieumastadenis\couleur\CssColor;

require 'vendor/autoload.php';

// Returns [ 255, 0, 0 ]:
$values = utils\parseColorValue('rgb(255,0,0)');

// Returns [ 255, 0, 0, 1 ]:
$values = utils\parseColorValue('rgb(255,0,0,1)');

// Returns [ 255, 0, 0, 255 ] (using the $opacityFactor parameter):
$values = utils\parseColorValue('rgb(255,0,0,1)', 255);

// Returns [ '100%', '0%', '0%', '100%' ]:
$values = utils\parseColorValue('rgb(100% 0% 0% / 100%)');

// Returns [ CssColor::red ]
$values = utils\parseColorValue(CssColor::red);

// Returns [ 255, 0, 0, 255 ]:
$values = utils\parseColorValue([ 255, 0, 0, 255 ]);

```

The `to()` function is the highest-level function used to convert any color value to any color space.

In case of success, its result will always be an array.

Its `$to` and `$from` parameters correspond respectively to the output and input color spaces, and accept either an instance of [the `ColorSpace` Enum](#the-colorspace-enum) or a stringable value corresponding to a *valid color space alias* (you can find all valid aliases listed below in the [🌈 Color Spaces](#-color-spaces) section).

If these parameters are null, they will be guessed by interpreting the format of `$value` (using the `findColorSpace()` function).

```php
<?php

use matthieumastadenis\couleur\utils;
use matthieumastadenis\couleur\ColorSpace;

require 'vendor/autoload.php';

// Returns [ CssColor::red ]:
// ('red' is a valid CSS color so we can omit the $from parameter):
$css = utils\to('red', 'css');

// Returns [ 255, 0, 0, 255 ]:
// ([ CssColor::red ] is a valid CSS color so we can omit the $from parameter):
$rgb = utils\to($css, ColorSpace::Rgb);

// Returns [ 0, 100, 50, 100 ]:
// ([ 255, 0, 0, 255 ] is a valid RGB color so we can omit the $from parameter):
$hsl = utils\to($rgb, ColorSpace::Hsl);

// Returns [ 54.29054294697, 80.804920334624, 69.890988258963, 100 ]
// (the $from parameter avoids HSL array being interpreted as RGB):
$lab = utils\to($hsl, ColorSpace::Lab, ColorSpace::Hsl);

// Returns [ 54.29054294697, 106.83719104366, 40.857668782131, 100 ]
// (the $from parameter avoids Lab array being interpreted as RGB):
$lch = utils\to($lab, ColorSpace::Lch, ColorSpace::Lab);

// Returns [ 0.41239079028139, 0.21263903420017, 0.01933077971095, 100 ]
// (the $from parameter avoids Lch array being interpreted as RGB):
$xyzD65 = utils\to($lch, ColorSpace::XyzD65, ColorSpace::Lch);

// Returns [ 0.70226883304033, 0.27562276714962, 0.10344904551878, 1 ]
// (here we use a valid string input so we can omit the $from paramter):
$proPhoto = utils\to('color(xyz-d65 0.4124 0.2126 0.0193 / 100%)', ColorSpace::ProPhoto);

```

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

### 🛠️ Enums and Constants

#### The `Constant` Enum

**Couleur** can be preconfigured with dedicated **constants**. These act as default values used by multiple functions when the corresponding parameter is missing or set to null. All constants are written in uppercase and prefixed with `COULEUR_`.

Currently, the following constants are used:

- `COULEUR_LEGACY` (default `0`): if set to `1`, stringified colors will use the *legacy CSS syntax* by default ;
- `COULEUR_PRECISION` (default `9`): the default rounding precision for color values when stringified ;

You can use the `Constant` enum to easily access and manage these constants and their values:

```php
<?php

use matthieumastadenis\couleur\Constant;

require 'vendor/autoload.php';

// Returns all Constant cases:
Constant::cases();

// Always returns 0, which is the default value for the COULEUR_LEGACY constant:
Constant::LEGACY->value;

// Always returns 9, which is the default value for the COULEUR_PRECISION constant:
Constant::PRECISION->value;

// Returns the value of the COULEUR_LEGACY constant if defined, or 0 by default:
Constant::LEGACY->value();

// Returns the value of the COULEUR_PRECISION constant if defined, or 9 by default:
Constant::PRECISION->value();

// Returns the value of the COULEUR_LEGACY constant if defined, or 1 as fallback:
Constant::LEGACY->value(1);

// Returns the value of the COULEUR_PRECISION constant if defined, or 3 as fallback:
Constant::PRECISION->value(3);

// Returns the value of the COULEUR_LEGACY constant if defined, or define it with 1 as value then returns 1:
Constant::LEGACY->value(1, true);

// Returns the value of the COULEUR_PRECISION constant if defined, or define it with 3 as value then returns 3:
Constant::PRECISION->value(3, true);

```

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

#### The `ColorSpace` Enum

This enum is the simplest way to access all **color spaces** supported by **Couleur**:

```php
<?php

use matthieumastadenis\couleur\ColorSpace;

require 'vendor/autoload.php';

// Returns all ColorSpace cases:
ColorSpace::cases();

```

You can access a `ColorSpace` instance by the corresponding color `class`:

```php
<?php

use matthieumastadenis\couleur\ColorSpace;
use matthieumastadenis\couleur\colors\Lch;
use matthieumastadenis\couleur\colors\LinP3;
use matthieumastadenis\couleur\colors\Rgb;

require 'vendor/autoload.php';

// Returns ColorSpace::Lch:
ColorSpace::from(Lch::class);

// Returns ColorSpace::LinP3:
ColorSpace::from(LinP3::class);

// Returns ColorSpace::Rgb:
ColorSpace::from(Rgb::class);

```

Each `ColorSpace` is accessible from multiple **aliases** with the `fromAlias()` method. All aliases are case insensitive:

```php
<?php

use matthieumastadenis\couleur\ColorSpace;

require 'vendor/autoload.php';

// Returns all ColorSpace aliases:
ColorSpace::allAliases();

// Returns aliases of the HexRgb space:
ColorSpace::HexRgb->aliases();

// Returns ColorSpace::Rgb:
ColorSpace::fromAlias('rgb');
ColorSpace::fromAlias('srgb');
ColorSpace::fromAlias('RGBA');

// Returns ColorSpace::Lab:
ColorSpace::fromAlias('lab');
ColorSpace::fromAlias('cielab');
ColorSpace::fromAlias('CIE-LAB');

```

You can easily access [dedicated functions](#color-space-functions) from each `ColorSpace` with the `cleanCallback()`, `fromCallback()`, `stringifyCallback()` and `verifyCallback()` methods:

```php
<?php

use matthieumastadenis\couleur\ColorSpace;
use matthieumastadenis\couleur\CssColor;

require 'vendor/autoload.php';

// Returns 'matthieumastadenis\couleur\utils\xyzD50\clean':
ColorSpace::XyzD50->cleanCallback();

// Returns [ 255, 127.5, 0, 255 ]:
ColorSpace::Rgb->cleanCallback()('rgb(100%,50%,0)');

// Returns [ 'FF', '00', '00', 'FF' ]:
ColorSpace::HexRgb->cleanCallback()('#f00');

// Returns 'matthieumastadenis\couleur\utils\xyzD50\from':
ColorSpace::XyzD50->fromCallback();

// Returns [ 255, 0, 0, 255 ]:
ColorSpace::Rgb->fromCallback()('hsl(0deg,100%,50%)');

// Returns CssColor::red:
ColorSpace::Css->fromCallback()('#f00');

// Returns 'matthieumastadenis\couleur\utils\xyzD50\stringify':
ColorSpace::XyzD50->stringifyCallback();

// Returns 'rgb(100% 0% 0% / 50%):
ColorSpace::Rgb->stringifyCallback()(255, 0 , 0, 127.5);

// Returns '#F00':
ColorSpace::Css->stringifyCallback()(CssColor::red);

// Returns 'matthieumastadenis\couleur\utils\css\verify':
ColorSpace::Css->verifyCallback();

// Returns true:
ColorSpace::Rgb->verifyCallback()('rgb(100%,50%,0)');

// Returns false:
ColorSpace::HexRgb->verifyCallback()('#ff');

```

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

#### The `CssColor` Enum

This enum helps managing `CSS` **named colors**. With its multiple methods, you can easily know if a `CssColor` exists and get the corresponding `RGB` or `HexRGB` coordinates from it:

```php
<?php

use matthieumastadenis\couleur\CssColor;

require 'vendor/autoload.php';

// Returns all CssColor cases:
CssColor::cases();

// Returns RGB coordinates for all supported CSS colors:
CssColor::allRgbCoordinates();

// Returns HexRgb coordinates for all supported CSS colors:
CssColor::allHexRgbCoordinates();

// Returns true (the 'red' color exists):
CssColor::exists('red');

// Returns [ 255, 0, 0 ]:
CssColor::red->toRgbCoordinates();

// Returns [ 'FF', '00', '00' ]:
CssColor::red->toHexRgbCoordinates();

```

The `fromCss()` method allows you to get a specific `CssColor` by its name. If no supported color matches the `$name` parameter, a `UnsupportedCssColor` Exception will be thrown by default, unless you provide a `$fallback` or you set the `$throw` parameter to **false**.

```php
<?php

use matthieumastadenis\couleur\CssColor;

require 'vendor/autoload.php';

// Returns CssColor::red:
CssColor::fromCss('red');

// Throws a UnsupportedCssColor Exception:
CssColor::fromCss('unknown');

// Returns CssColor::pink Exception:
CssColor::fromCss('unknown', CssColor::pink);

// Returns null:
CssColor::fromCss('unknown', null, false);

```

You can also find the `CssColor` corresponding to precise `RGB` or `HexRGB` coordinates with `fromRgb()` and `fromHexRgb()`.

By default these functions will return the supported CSS color which is the **closest** to the provided coordinates, unless you set the `$closest` parameter to **false**. In that case and if no supported color matches the exact coordinates you provided, a `UnsupportedCssColor` Exception will be thrown by default, unless you provide a `$fallback` or you set the `$throw` parameter to **false**.

```php
<?php

use matthieumastadenis\couleur\CssColor;

require 'vendor/autoload.php';

// Returns CssColor::red which is the closest to #FA1111:
CssColor::fromHexRgb('FA', '11', '11');

// Throws a UnsupportedCssColor Exception:
CssColor::fromHexRgb('FA', '11', '11', false);

// Returns CssColor::pink:
CssColor::fromHexRgb('FA', '11', '11', false, CssColor::pink);

// Returns null:
CssColor::fromHexRgb('FA', '11', '11', false, null, false);

// Returns CssColor::red which is the closest to rgb(250,10,10):
CssColor::fromRgb(250, 10, 10);

// Throws a UnsupportedCssColor Exception:
CssColor::fromRgb(250, 10, 10, false);

// Returns CssColor::pink:
CssColor::fromRgb(250, 10, 10, false, CssColor::pink);

// Returns null:
CssColor::fromRgb(250, 10, 10, false, null, false);

```

You can **stringify** a `CssColor` with the `toHexRgbString()` and `toRgbString` methods:

```php
<?php

use matthieumastadenis\couleur\CssColor;

require 'vendor/autoload.php';

// Returns '#F00':
CssColor::red->toHexRgbString();

// Returns '#f00' (using the $uppercase parameter):
CssColor::red->toHexRgbString(uppercase : false);

// Returns 'F00' (using the $sharp parameter):
CssColor::red->toHexRgbString(sharp : false);

// Returns '#F00F' (using the $alpha parameter):
CssColor::red->toHexRgbString(true);

// Returns '#FF0000' (using the $short parameter):
CssColor::red->toHexRgbString(short : false);

// Returns '#FF0000FF' (using $alpha and $short parameters):
CssColor::red->toHexRgbString(true, false);

// Returns '#ff0000ff' (using $alpha, $short and $uppercase parameters):
CssColor::red->toHexRgbString(true, false, false);

// Returns 'ff0000ff' (using $alpha, $short, $uppercase and $sharp parameters):
CssColor::red->toHexRgbString(true, false, false, false);

// Returns 'rgb(100% 0% 0%)':
CssColor::red->toRgbString();

// Returns 'rgb(100% 0% 0% / 100%)' (using the $alpha parameter):
CssColor::red->toRgbString(alpha : true);

// Returns 'rgb(255,0,0)' (using the $legacy parameter):
CssColor::red->toRgbString(true);

// Returns 'rgba(255,0,0,1)' (using the $legacy and $alpha parameters):
CssColor::red->toRgbString(true, true);

```

You can also get a new `Color` **object** from any `CssColor` by using the `toCss()`, `toHexRgb()` or `toRgb()` method:

```php
<?php

use matthieumastadenis\couleur\CssColor;

require 'vendor/autoload.php';

// Returns a new colors\Css instance:
CssColor::red->toCss();

// Returns a new colors\HexRgb instance:
CssColor::red->toHexRgb();

// Returns a new colors\Rgb instance:
CssColor::red->toRgb();

```

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

## 🌈 Color Spaces

**Couleur** currently supports the following **color spaces** and formats:

### CSS

In **Couleur**, the `Css` color space refers to the  **named colors** according to the [CSS specification](https://drafts.csswg.org/css-color-4/#named-colors). Because they are a predefined and standardized list of exact colors, they all can be accessed easily with [the CssColor Enum](#the-csscolor-enum).

> **Note** :
> `Css` colors **can not** have an opacity value. If you want to apply transparency to a `Css` color, you first **have to** convert it into another color space. In the same way, if you convert a color with transparency into its `Css` equivalent, it will **lose** the transparency.

- **ColorSpace enum case** : `ColorSpace::Css` ;
- **Color class** : `matthieumastadenis\couleur\colors\Css` ;
- **Dedicated functions namespace** : `matthieumastadenis\couleur\utils\css` ;
- **Accepted aliases** : `css`, `html`, `web` ;

### Hexadecimal RGB

- **ColorSpace** case: `ColorSpace::HexRgb` ;
- **Color class** : `matthieumastadenis\couleur\colors\HexRgb` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\hexRgb` ;
- **Accepted aliases** : `hex`, `hexrgb`, `hex-rgb`, `hex_rgb`, `hexadecimal` ;
- **Coordinates** : `red`, `green`, `blue` ;
  
### HSL

- **ColorSpace** case: `ColorSpace::Hsl` ;
- **Color class** : `matthieumastadenis\couleur\colors\Hsl` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\hsl` ;
- **Accepted aliases** : `hsl`, `hsla` ;
- **Coordinates** : `hue`, `saturation`, `lightness` ;
  
### HSV

- **ColorSpace** case: `ColorSpace::Hsv` ;
- **Color class** : `matthieumastadenis\couleur\colors\Hsv` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\hsv` ;
- **Accepted aliases** : `hsv`, `hsb` ;
- **Coordinates** : `hue`, `saturation`, `value` ;
  
### HWB

- **ColorSpace** case: `ColorSpace::Hwb` ;
- **Color class** : `matthieumastadenis\couleur\colors\Hwb` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\hwb` ;
- **Accepted aliases** : `hwb` ;
- **Coordinates** : `hue`, `whiteness`, `blackness` ;

### Lab

- **ColorSpace** case: `ColorSpace::Lab` ;
- **Color class** : `matthieumastadenis\couleur\colors\Lab` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\lab` ;
- **Accepted aliases** : `lab`, `cielab`, `cie-lab`, `cie_lab` ;
- **Coordinates** : `lightness`, `b`, `a` ;

### Lch

- **ColorSpace** case: `ColorSpace::Lch` ;
- **Color class** : `matthieumastadenis\couleur\colors\Lch` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\lch` ;
- **Accepted aliases** : `lch`, `cielch`, `cie-lch`, `cie_lch` ;
- **Coordinates** : `lightness`, `chroma`, `hue` ;

### Linear RGB

- **ColorSpace** case: `ColorSpace::LinRgb` ;
- **Color class** : `matthieumastadenis\couleur\colors\LinRgb` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\linRgb` ;
- **Accepted aliases** : `srgb-linear`, `linrgb`, `linsrgb`, `lin-rgb`, `lin_rgb`, `lin-srgb`, `lin_srgb` ;
- **Coordinates** : `red`, `green`, `blue` ;

### Linear P3

- **ColorSpace** case: `ColorSpace::LinP3` ;
- **Color class** : `matthieumastadenis\couleur\colors\LinP3` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\linP3` ;
- **Accepted aliases** : `p3-linear`, `p3_linear`, `linp3`, `lin-p3`, `lin_p3` ;
- **Coordinates** : `red`, `green`, `blue` ;

### Linear ProPhoto

- **ColorSpace** case: `ColorSpace::LinProPhoto` ;
- **Color class** : `matthieumastadenis\couleur\colors\LinProPhoto` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\linProPhoto` ;
- **Accepted aliases** : `prophoto-linear`, `prophoto_linear`, `linprophoto`, `lin-prophoto`, `lin_prophoto` ;
- **Coordinates** : `red`, `green`, `blue` ;

### OkLab

- **ColorSpace** case: `ColorSpace::OkLab` ;
- **Color class** : `matthieumastadenis\couleur\colors\OkLab` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\okLab` ;
- **Accepted aliases** : `oklab`, `ok-lab`, `ok_lab` ;
- **Coordinates** : `lightness`, `a`, `b` ;

### OkLch

- **ColorSpace** case: `ColorSpace::OkLch` ;
- **Color class** : `matthieumastadenis\couleur\colors\OkLch` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\okLch` ;
- **Accepted aliases** : `oklch`, `ok-lch`, `ok_lch` ;
- **Coordinates** : `lightness`, `chroma`, `hue` ;

### P3

- **ColorSpace** case: `ColorSpace::LinP3` ;
- **Color class** : `matthieumastadenis\couleur\colors\LinP3` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\linP3` ;
- **Accepted aliases** : `display-p3`, `display_p3`, `p3` ;
- **Coordinates** : `red`, `green`, `blue` ;

### ProPhoto

- **ColorSpace** case: `ColorSpace::ProPhoto` ;
- **Color class** : `matthieumastadenis\couleur\colors\ProPhoto` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\proPhoto` ;
- **Accepted aliases** : `prophoto`, `prophoto-rgb`, `prophoto_rgb` ;
- **Coordinates** : `red`, `green`, `blue` ;

### RGB

- **ColorSpace** case: `ColorSpace::Rgb` ;
- **Color class** : `matthieumastadenis\couleur\colors\Rgb` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\rgb` ;
- **Accepted aliases** : `rgb`, `rgba`, `srgb`, `s-rgb`, `s_rgb` ;
- **Coordinates** : `red`, `green`, `blue` ;

### XYZ-D50

- **ColorSpace** case: `ColorSpace::XyzD50` ;
- **Color class** : `matthieumastadenis\couleur\colors\XyzD50` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\xyzD50` ;
- **Accepted aliases** : `xyz-d50`, `xyz_d50`, `xyzd50` ;
- **Coordinates** : `x`, `y`, `z` ;

### XYZ-D65

- **ColorSpace** case: `ColorSpace::XyzD65` ;
- **Color class** : `matthieumastadenis\couleur\colors\XyzD65` ;
- **Dedicated functions** namespace : `matthieumastadenis\couleur\utils\xyzD65` ;
- **Accepted aliases** : `xyz-d65`, `xyz_d65`, `xyzd65`, `xyz` ;
- **Coordinates** : `x`, `y`, `z` ;

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

## 🤝 Contributing

You're welcome to contribute to this package by using [issues](https://github.com/matthieumastadenis/couleur/issues) and [pull requests](https://github.com/matthieumastadenis/couleur/pulls).

Before submitting any breaking change, please consider contacting me (either by directly [submitting an issue](https://github.com/matthieumastadenis/couleur/issues/new), or by sending me a DM on [Twitter](https://twitter.com/matthieu_masta) if you really feel it's more appropriate).

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

## 📜 License

**Couleur** is publicly shared under the **MIT License**. You can freely use it in any project. For more information, please read the included [License File](https://github.com/matthieumastadenis/couleur/blob/main/LICENSE).

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)

## ❤️ Thanks

A huge thanks to [Lea Verou](https://github.com/LeaVerou) and [Chris Lilley](https://github.com/svgeesus) for their incredible work and their precise articles on the subject. With a special thanks to Chris for the time and the answers he gave me during the implementation of this library.

[↑ Back to Top](#-couleur-a-modern-php-81-color-library)
