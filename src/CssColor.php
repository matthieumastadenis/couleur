<?php

namespace matthieumastadenis\couleur;

use       matthieumastadenis\couleur\colors\Css;
use       matthieumastadenis\couleur\colors\HexRgb;
use       matthieumastadenis\couleur\colors\Rgb;
use       matthieumastadenis\couleur\exceptions\UnsupportedCssColor;

/**
 * Represents a named color according to the CSS specification (https://drafts.csswg.org/css-color-4/#named-colors).
 * It can be converted to RGB or Hexadecimal RGB coordinates, or directly to an instance of colors\Rgb or colors\HexRgb.
 */
enum CssColor {

    /* #region Cases */

    case aliceblue;
    case antiquewhite;
    case aqua;
    case aquamarine;
    case azure;
    case beige;
    case bisque;
    case black;
    case blanchedalmond;
    case blue;
    case blueviolet;
    case brown;
    case burlywood;
    case cadetblue;
    case chartreuse;
    case chocolate;
    case coral;
    case cornflowerblue;
    case cornsilk;
    case crimson;
    case cyan;
    case darkblue;
    case darkcyan;
    case darkgoldenrod;
    case darkgray;
    case darkgreen;
    case darkgrey;
    case darkkhaki;
    case darkmagenta;
    case darkolivegreen;
    case darkorange;
    case darkorchid;
    case darkred;
    case darksalmon;
    case darkseagreen;
    case darkslateblue;
    case darkslategray;
    case darkslategrey;
    case darkturquoise;
    case darkviolet;
    case deeppink;
    case deepskyblue;
    case dimgray;
    case dimgrey;
    case dodgerblue;
    case firebrick;
    case floralwhite;
    case forestgreen;
    case fuchsia;
    case gainsboro;
    case ghostwhite;
    case gold;
    case goldenrod;
    case gray;
    case green;
    case greenyellow;
    case grey;
    case honeydew;
    case hotpink;
    case indianred;
    case indigo;
    case ivory;
    case khaki;
    case lavender;
    case lavenderblush;
    case lawngreen;
    case lemonchiffon;
    case lightblue;
    case lightcoral;
    case lightcyan;
    case lightgoldenrodyellow;
    case lightgray;
    case lightgreen;
    case lightgrey;
    case lightpink;
    case lightsalmon;
    case lightseagreen;
    case lightskyblue;
    case lightslategray;
    case lightslategrey;
    case lightsteelblue;
    case lightyellow;
    case lime;
    case limegreen;
    case linen;
    case magenta;
    case maroon;
    case mediumaquamarine;
    case mediumblue;
    case mediumorchid;
    case mediumpurple;
    case mediumseagreen;
    case mediumslateblue;
    case mediumspringgreen;
    case mediumturquoise;
    case mediumvioletred;
    case midnightblue;
    case mintcream;
    case mistyrose;
    case moccasin;
    case navajowhite;
    case navy;
    case oldlace;
    case olive;
    case olivedrab;
    case orange;
    case orangered;
    case orchid;
    case palegoldenrod;
    case palegreen;
    case paleturquoise;
    case palevioletred;
    case papayawhip;
    case peachpuff;
    case peru;
    case pink;
    case plum;
    case powderblue;
    case purple;
    case rebeccapurple;
    case red;
    case rosybrown;
    case royalblue;
    case saddlebrown;
    case salmon;
    case sandybrown;
    case seagreen;
    case seashell;
    case sienna;
    case silver;
    case skyblue;
    case slateblue;
    case slategray;
    case slategrey;
    case snow;
    case springgreen;
    case steelblue;
    case tan;
    case teal;
    case thistle;
    case tomato;
    case turquoise;
    case violet;
    case wheat;
    case white;
    case whitesmoke;
    case yellow;
    case yellowgreen;

    /* #endregion */

    /* #region Public Static Methods */

    /**
     * Returns an array containing Hexadecimal RGB coordinates for all supported CSS colors.
     *
     * @return array
     */
    public static function allHexRgbCoordinates(

    ) :array {
        return [
            static::aliceblue->name            => [ 'F0', 'F8', 'FF' ],
            static::antiquewhite->name         => [ 'FA', 'EB', 'D7' ],
            static::aqua->name                 => [ '00', 'FF', 'FF' ],
            static::aquamarine->name           => [ '7F', 'FF', 'D4' ],
            static::azure->name                => [ 'F0', 'FF', 'FF' ],
            static::beige->name                => [ 'F5', 'F5', 'DC' ],
            static::bisque->name               => [ 'FF', 'E4', 'C4' ],
            static::black->name                => [ '00', '00', '00' ],
            static::blanchedalmond->name       => [ 'FF', 'EB', 'CD' ],
            static::blue->name                 => [ '00', '00', 'FF' ],
            static::blueviolet->name           => [ '8A', '2B', 'E2' ],
            static::brown->name                => [ 'A5', '2A', '2A' ],
            static::burlywood->name            => [ 'DE', 'B8', '87' ],
            static::cadetblue->name            => [ '5F', '9E', 'A0' ],
            static::chartreuse->name           => [ '7F', 'FF', '00' ],
            static::chocolate->name            => [ 'D2', '69', '1E' ],
            static::coral->name                => [ 'FF', '7F', '50' ],
            static::cornflowerblue->name       => [ '64', '95', 'ED' ],
            static::cornsilk->name             => [ 'FF', 'F8', 'DC' ],
            static::crimson->name              => [ 'DC', '14', '3C' ],
            static::cyan->name                 => [ '00', 'FF', 'FF' ],
            static::darkblue->name             => [ '00', '00', '8B' ],
            static::darkcyan->name             => [ '00', '8B', '8B' ],
            static::darkgoldenrod->name        => [ 'B8', '86', '0B' ],
            static::darkgray->name             => [ 'A9', 'A9', 'A9' ],
            static::darkgreen->name            => [ '00', '64', '00' ],
            static::darkgrey->name             => [ 'A9', 'A9', 'A9' ],
            static::darkkhaki->name            => [ 'BD', 'B7', '6B' ],
            static::darkmagenta->name          => [ '8B', '00', '8B' ],
            static::darkolivegreen->name       => [ '55', '6B', '2F' ],
            static::darkorange->name           => [ 'FF', '8C', '00' ],
            static::darkorchid->name           => [ '99', '32', 'CC' ],
            static::darkred->name              => [ '8B', '00', '00' ],
            static::darksalmon->name           => [ 'E9', '96', '7A' ],
            static::darkseagreen->name         => [ '8F', 'BC', '8F' ],
            static::darkslateblue->name        => [ '48', '3D', '8B' ],
            static::darkslategray->name        => [ '2F', '4F', '4F' ],
            static::darkslategrey->name        => [ '2F', '4F', '4F' ],
            static::darkturquoise->name        => [ '00', 'CE', 'D1' ],
            static::darkviolet->name           => [ '94', '00', 'D3' ],
            static::deeppink->name             => [ 'FF', '14', '93' ],
            static::deepskyblue->name          => [ '00', 'BF', 'FF' ],
            static::dimgray->name              => [ '69', '69', '69' ],
            static::dimgrey->name              => [ '69', '69', '69' ],
            static::dodgerblue->name           => [ '1E', '90', 'FF' ],
            static::firebrick->name            => [ 'B2', '22', '22' ],
            static::floralwhite->name          => [ 'FF', 'FA', 'F0' ],
            static::forestgreen->name          => [ '22', '8B', '22' ],
            static::fuchsia->name              => [ 'FF', '00', 'FF' ],
            static::gainsboro->name            => [ 'DC', 'DC', 'DC' ],
            static::ghostwhite->name           => [ 'F8', 'F8', 'FF' ],
            static::gold->name                 => [ 'FF', 'D7', '00' ],
            static::goldenrod->name            => [ 'DA', 'A5', '20' ],
            static::gray->name                 => [ '80', '80', '80' ],
            static::green->name                => [ '00', '80', '00' ],
            static::greenyellow->name          => [ 'AD', 'FF', '2F' ],
            static::grey->name                 => [ '80', '80', '80' ],
            static::honeydew->name             => [ 'F0', 'FF', 'F0' ],
            static::hotpink->name              => [ 'FF', '69', 'B4' ],
            static::indianred->name            => [ 'CD', '5C', '5C' ],
            static::indigo->name               => [ '4B', '00', '82' ],
            static::ivory->name                => [ 'FF', 'FF', 'F0' ],
            static::khaki->name                => [ 'F0', 'E6', '8C' ],
            static::lavender->name             => [ 'E6', 'E6', 'FA' ],
            static::lavenderblush->name        => [ 'FF', 'F0', 'F5' ],
            static::lawngreen->name            => [ '7C', 'FC', '00' ],
            static::lemonchiffon->name         => [ 'FF', 'FA', 'CD' ],
            static::lightblue->name            => [ 'AD', 'D8', 'E6' ],
            static::lightcoral->name           => [ 'F0', '80', '80' ],
            static::lightcyan->name            => [ 'E0', 'FF', 'FF' ],
            static::lightgoldenrodyellow->name => [ 'FA', 'FA', 'D2' ],
            static::lightgray->name            => [ 'D3', 'D3', 'D3' ],
            static::lightgreen->name           => [ '90', 'EE', '90' ],
            static::lightgrey->name            => [ 'D3', 'D3', 'D3' ],
            static::lightpink->name            => [ 'FF', 'B6', 'C1' ],
            static::lightsalmon->name          => [ 'FF', 'A0', '7A' ],
            static::lightseagreen->name        => [ '20', 'B2', 'AA' ],
            static::lightskyblue->name         => [ '87', 'CE', 'FA' ],
            static::lightslategray->name       => [ '77', '88', '99' ],
            static::lightslategrey->name       => [ '77', '88', '99' ],
            static::lightsteelblue->name       => [ 'B0', 'C4', 'DE' ],
            static::lightyellow->name          => [ 'FF', 'FF', 'E0' ],
            static::lime->name                 => [ '00', 'FF', '00' ],
            static::limegreen->name            => [ '32', 'CD', '32' ],
            static::linen->name                => [ 'FA', 'F0', 'E6' ],
            static::magenta->name              => [ 'FF', '00', 'FF' ],
            static::maroon->name               => [ '80', '00', '00' ],
            static::mediumaquamarine->name     => [ '66', 'CD', 'AA' ],
            static::mediumblue->name           => [ '00', '00', 'CD' ],
            static::mediumorchid->name         => [ 'BA', '55', 'D3' ],
            static::mediumpurple->name         => [ '93', '70', 'DB' ],
            static::mediumseagreen->name       => [ '3C', 'B3', '71' ],
            static::mediumslateblue->name      => [ '7B', '68', 'EE' ],
            static::mediumspringgreen->name    => [ '00', 'FA', '9A' ],
            static::mediumturquoise->name      => [ '48', 'D1', 'CC' ],
            static::mediumvioletred->name      => [ 'C7', '15', '85' ],
            static::midnightblue->name         => [ '19', '19', '70' ],
            static::mintcream->name            => [ 'F5', 'FF', 'FA' ],
            static::mistyrose->name            => [ 'FF', 'E4', 'E1' ],
            static::moccasin->name             => [ 'FF', 'E4', 'B5' ],
            static::navajowhite->name          => [ 'FF', 'DE', 'AD' ],
            static::navy->name                 => [ '00', '00', '80' ],
            static::oldlace->name              => [ 'FD', 'F5', 'E6' ],
            static::olive->name                => [ '80', '80', '00' ],
            static::olivedrab->name            => [ '6B', '8E', '23' ],
            static::orange->name               => [ 'FF', 'A5', '00' ],
            static::orangered->name            => [ 'FF', '45', '00' ],
            static::orchid->name               => [ 'DA', '70', 'D6' ],
            static::palegoldenrod->name        => [ 'EE', 'E8', 'AA' ],
            static::palegreen->name            => [ '98', 'FB', '98' ],
            static::paleturquoise->name        => [ 'AF', 'EE', 'EE' ],
            static::palevioletred->name        => [ 'DB', '70', '93' ],
            static::papayawhip->name           => [ 'FF', 'EF', 'D5' ],
            static::peachpuff->name            => [ 'FF', 'DA', 'B9' ],
            static::peru->name                 => [ 'CD', '85', '3F' ],
            static::pink->name                 => [ 'FF', 'C0', 'CB' ],
            static::plum->name                 => [ 'DD', 'A0', 'DD' ],
            static::powderblue->name           => [ 'B0', 'E0', 'E6' ],
            static::purple->name               => [ '80', '00', '80' ],
            static::rebeccapurple->name        => [ '66', '33', '99' ],
            static::red->name                  => [ 'FF', '00', '00' ],
            static::rosybrown->name            => [ 'BC', '8F', '8F' ],
            static::royalblue->name            => [ '41', '69', 'E1' ],
            static::saddlebrown->name          => [ '8B', '45', '13' ],
            static::salmon->name               => [ 'FA', '80', '72' ],
            static::sandybrown->name           => [ 'F4', 'A4', '60' ],
            static::seagreen->name             => [ '2E', '8B', '57' ],
            static::seashell->name             => [ 'FF', 'F5', 'EE' ],
            static::sienna->name               => [ 'A0', '52', '2D' ],
            static::silver->name               => [ 'C0', 'C0', 'C0' ],
            static::skyblue->name              => [ '87', 'CE', 'EB' ],
            static::slateblue->name            => [ '6A', '5A', 'CD' ],
            static::slategray->name            => [ '70', '80', '90' ],
            static::slategrey->name            => [ '70', '80', '90' ],
            static::snow->name                 => [ 'FF', 'FA', 'FA' ],
            static::springgreen->name          => [ '00', 'FF', '7F' ],
            static::steelblue->name            => [ '46', '82', 'B4' ],
            static::tan->name                  => [ 'D2', 'B4', '8C' ],
            static::teal->name                 => [ '00', '80', '80' ],
            static::thistle->name              => [ 'D8', 'BF', 'D8' ],
            static::tomato->name               => [ 'FF', '63', '47' ],
            static::turquoise->name            => [ '40', 'E0', 'D0' ],
            static::violet->name               => [ 'EE', '82', 'EE' ],
            static::wheat->name                => [ 'F5', 'DE', 'B3' ],
            static::white->name                => [ 'FF', 'FF', 'FF' ],
            static::whitesmoke->name           => [ 'F5', 'F5', 'F5' ],
            static::yellow->name               => [ 'FF', 'FF', '00' ],
            static::yellowgreen->name          => [ '9A', 'CD', '32' ],
        ];
    }

    /**
     * Returns an array containing RGB coordinates for all supported CSS colors.
     *
     * @return array
     */
    public static function allRgbCoordinates(

    ) :array {
        return [
            static::aliceblue->name            => [ 240, 248, 255 ],
            static::antiquewhite->name         => [ 250, 235, 215 ],
            static::aqua->name                 => [ 0,   255, 255 ],
            static::aquamarine->name           => [ 127, 255, 212 ],
            static::azure->name                => [ 240, 255, 255 ],
            static::beige->name                => [ 245, 245, 220 ],
            static::bisque->name               => [ 255, 228, 196 ],
            static::black->name                => [ 0,   0,   0   ],
            static::blanchedalmond->name       => [ 255, 235, 205 ],
            static::blue->name                 => [ 0,   0,   255 ],
            static::blueviolet->name           => [ 138, 43,  226 ],
            static::brown->name                => [ 165, 42,  42  ],
            static::burlywood->name            => [ 222, 184, 135 ],
            static::cadetblue->name            => [ 95,  158, 160 ],
            static::chartreuse->name           => [ 127, 255, 0   ],
            static::chocolate->name            => [ 210, 105, 30  ],
            static::coral->name                => [ 255, 127, 80  ],
            static::cornflowerblue->name       => [ 100, 149, 237 ],
            static::cornsilk->name             => [ 255, 248, 220 ],
            static::crimson->name              => [ 220, 20,  60  ],
            static::cyan->name                 => [ 0,   255, 255 ],
            static::darkblue->name             => [ 0,   0,   139 ],
            static::darkcyan->name             => [ 0,   139, 139 ],
            static::darkgoldenrod->name        => [ 184, 134, 11  ],
            static::darkgray->name             => [ 169, 169, 169 ],
            static::darkgreen->name            => [ 0,   100, 0   ],
            static::darkgrey->name             => [ 169, 169, 169 ],
            static::darkkhaki->name            => [ 189, 183, 107 ],
            static::darkmagenta->name          => [ 139, 0,   139 ],
            static::darkolivegreen->name       => [ 85,  107, 47  ],
            static::darkorange->name           => [ 255, 140, 0   ],
            static::darkorchid->name           => [ 153, 50,  204 ],
            static::darkred->name              => [ 139, 0,   0   ],
            static::darksalmon->name           => [ 233, 150, 122 ],
            static::darkseagreen->name         => [ 143, 188, 143 ],
            static::darkslateblue->name        => [ 72,  61,  139 ],
            static::darkslategray->name        => [ 47,  79,  79  ],
            static::darkslategrey->name        => [ 47,  79,  79  ],
            static::darkturquoise->name        => [ 0,   206, 209 ],
            static::darkviolet->name           => [ 148, 0,   211 ],
            static::deeppink->name             => [ 255, 20,  147 ],
            static::deepskyblue->name          => [ 0,   191, 255 ],
            static::dimgray->name              => [ 105, 105, 105 ],
            static::dimgrey->name              => [ 105, 105, 105 ],
            static::dodgerblue->name           => [ 30,  144, 255 ],
            static::firebrick->name            => [ 178, 34,  34  ],
            static::floralwhite->name          => [ 255, 250, 240 ],
            static::forestgreen->name          => [ 34,  139, 34  ],
            static::fuchsia->name              => [ 255, 0,   255 ],
            static::gainsboro->name            => [ 220, 220, 220 ],
            static::ghostwhite->name           => [ 248, 248, 255 ],
            static::gold->name                 => [ 255, 215, 0   ],
            static::goldenrod->name            => [ 218, 165, 32  ],
            static::gray->name                 => [ 128, 128, 128 ],
            static::green->name                => [ 0,   128, 0   ],
            static::greenyellow->name          => [ 173, 255, 47  ],
            static::grey->name                 => [ 128, 128, 128 ],
            static::honeydew->name             => [ 240, 255, 240 ],
            static::hotpink->name              => [ 255, 105, 180 ],
            static::indianred->name            => [ 205, 92,  92  ],
            static::indigo->name               => [ 75,  0,   130 ],
            static::ivory->name                => [ 255, 255, 240 ],
            static::khaki->name                => [ 240, 230, 140 ],
            static::lavender->name             => [ 230, 230, 250 ],
            static::lavenderblush->name        => [ 255, 240, 245 ],
            static::lawngreen->name            => [ 124, 252, 0   ],
            static::lemonchiffon->name         => [ 255, 250, 205 ],
            static::lightblue->name            => [ 173, 216, 230 ],
            static::lightcoral->name           => [ 240, 128, 128 ],
            static::lightcyan->name            => [ 224, 255, 255 ],
            static::lightgoldenrodyellow->name => [ 250, 250, 210 ],
            static::lightgray->name            => [ 211, 211, 211 ],
            static::lightgreen->name           => [ 144, 238, 144 ],
            static::lightgrey->name            => [ 211, 211, 211 ],
            static::lightpink->name            => [ 255, 182, 193 ],
            static::lightsalmon->name          => [ 255, 160, 122 ],
            static::lightseagreen->name        => [ 32,  178, 170 ],
            static::lightskyblue->name         => [ 135, 206, 250 ],
            static::lightslategray->name       => [ 119, 136, 153 ],
            static::lightslategrey->name       => [ 119, 136, 153 ],
            static::lightsteelblue->name       => [ 176, 196, 222 ],
            static::lightyellow->name          => [ 255, 255, 224 ],
            static::lime->name                 => [ 0,   255, 0   ],
            static::limegreen->name            => [ 50,  205, 50  ],
            static::linen->name                => [ 250, 240, 230 ],
            static::magenta->name              => [ 255, 0,   255 ],
            static::maroon->name               => [ 128, 0,   0   ],
            static::mediumaquamarine->name     => [ 102, 205, 170 ],
            static::mediumblue->name           => [ 0,   0,   205 ],
            static::mediumorchid->name         => [ 186, 85,  211 ],
            static::mediumpurple->name         => [ 147, 112, 219 ],
            static::mediumseagreen->name       => [ 60,  179, 113 ],
            static::mediumslateblue->name      => [ 123, 104, 238 ],
            static::mediumspringgreen->name    => [ 0,   250, 154 ],
            static::mediumturquoise->name      => [ 72,  209, 204 ],
            static::mediumvioletred->name      => [ 199, 21,  133 ],
            static::midnightblue->name         => [ 25,  25,  112 ],
            static::mintcream->name            => [ 245, 255, 250 ],
            static::mistyrose->name            => [ 255, 228, 225 ],
            static::moccasin->name             => [ 255, 228, 181 ],
            static::navajowhite->name          => [ 255, 222, 173 ],
            static::navy->name                 => [ 0,   0,   128 ],
            static::oldlace->name              => [ 253, 245, 230 ],
            static::olive->name                => [ 128, 128, 0   ],
            static::olivedrab->name            => [ 107, 142, 35  ],
            static::orange->name               => [ 255, 165, 0   ],
            static::orangered->name            => [ 255, 69,  0   ],
            static::orchid->name               => [ 218, 112, 214 ],
            static::palegoldenrod->name        => [ 238, 232, 170 ],
            static::palegreen->name            => [ 152, 251, 152 ],
            static::paleturquoise->name        => [ 175, 238, 238 ],
            static::palevioletred->name        => [ 219, 112, 147 ],
            static::papayawhip->name           => [ 255, 239, 213 ],
            static::peachpuff->name            => [ 255, 218, 185 ],
            static::peru->name                 => [ 205, 133, 63  ],
            static::pink->name                 => [ 255, 192, 203 ],
            static::plum->name                 => [ 221, 160, 221 ],
            static::powderblue->name           => [ 176, 224, 230 ],
            static::purple->name               => [ 128, 0,   128 ],
            static::rebeccapurple->name        => [ 102, 51,  153 ],
            static::red->name                  => [ 255, 0,   0   ],
            static::rosybrown->name            => [ 188, 143, 143 ],
            static::royalblue->name            => [ 65,  105, 225 ],
            static::saddlebrown->name          => [ 139, 69,  19  ],
            static::salmon->name               => [ 250, 128, 114 ],
            static::sandybrown->name           => [ 244, 164, 96  ],
            static::seagreen->name             => [ 46,  139, 87  ],
            static::seashell->name             => [ 255, 245, 238 ],
            static::sienna->name               => [ 160, 82,  45  ],
            static::silver->name               => [ 192, 192, 192 ],
            static::skyblue->name              => [ 135, 206, 235 ],
            static::slateblue->name            => [ 106, 90,  205 ],
            static::slategray->name            => [ 112, 128, 144 ],
            static::slategrey->name            => [ 112, 128, 144 ],
            static::snow->name                 => [ 255, 250, 250 ],
            static::springgreen->name          => [ 0,   255, 127 ],
            static::steelblue->name            => [ 70,  130, 180 ],
            static::tan->name                  => [ 210, 180, 140 ],
            static::teal->name                 => [ 0,   128, 128 ],
            static::thistle->name              => [ 216, 191, 216 ],
            static::tomato->name               => [ 255, 99,  71  ],
            static::turquoise->name            => [ 64,  224, 208 ],
            static::violet->name               => [ 238, 130, 238 ],
            static::wheat->name                => [ 245, 222, 179 ],
            static::white->name                => [ 255, 255, 255 ],
            static::whitesmoke->name           => [ 245, 245, 245 ],
            static::yellow->name               => [ 255, 255, 0   ],
            static::yellowgreen->name          => [ 154, 205, 50  ],
        ];
    }

    /**
     * Returns true if the $name CSS color exists, false otherwise.
     *
     * @param  \Stringable|string $name The named CSS color you're looking for
     *
     * @return boolean                  True if $name is an existing CSS color, false otherwise
     */
    public static function exists(
        \Stringable|string $name,
    ) :bool {
        return \in_array(
            needle   : (string) $name,
            haystack : static::names(),
        );
    }

    /**
     * Returns the instance of the CssColor enum corresponding to the color $name if it exists.
     *
     * If $name does not correspond to an existing CSS color, a new UnsupportedCssColor Exception will be thrown by default,
     * except if a $fallback is provided or if the $throw parameter is set to false. In that case, the method will retun $fallback.
     *
     * @param  \Stringable|string $name     Name of the desired CSS color. It should correspond to one of the enum's cases
     * @param  CssColor|null      $fallback Instance of the CssColor enum to return in case of failure (null by default)
     * @param  boolean|null       $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return static|null
     */
    public static function fromCss(
        \Stringable|string $name,
        CssColor|null      $fallback = null,
        bool|null          $throw    = null,
    ) :static|null {
        $throw ??= !((bool) $fallback);
        $name    = \strtolower(\trim((string) $name));

        foreach (static::cases() as $color) {
            if ($color->name === $name) {
                return $color;
            }
        }

        return $throw
            ? throw new UnsupportedCssColor($name)
            : $fallback
        ;
    }

    /**
     * Returns the instance of the CssColor enum corresponding to the provided Hexadecimal RGB coordinates, if it exists.
     *
     * By default and if the $closest parameter is true, the supported color which has the closest coordinates will be returned.
     *
     * If $closest is false and no supported color matches the provided coordinates, a new UnsupportedCssColor Exception will be
     * thrown by default, except if a $fallback is provided or if the $throw parameter is set to false. In that case, the
     * method will return $fallback.
     *
     * @param  string        $red      Red coordinate of the desired CSS color. It should be a string containing an hexadecimal number between '00' and 'FF'
     * @param  string        $green    Green coordinate of the desired CSS color. It should be a string containing an hexadecimal number between '00' and 'FF'
     * @param  string        $blue     Blue coordinate of the desired CSS color. It should be a string containing an hexadecimal number between '00' and 'FF'
     * @param  boolean       $closest  If true, returns the supported CSS color which is the closest from provided coordinates. If false, throws an Exception or returns $fallback
     * @param  CssColor|null $fallback Instance of the CssColor enum to return in case of failure (null by default)
     * @param  boolean|null  $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return static|null
     */
    public static function fromHexRgb(
        string        $red,
        string        $green,
        string        $blue,
        bool          $closest  = true,
        CssColor|null $fallback = null,
        bool|null     $throw    = null,
    ) :static|null {
        $red       = utils\cleanHexValue($red);
        $green     = utils\cleanHexValue($green);
        $blue      = utils\cleanHexValue($blue);
        $array     = [ $red, $green, $blue ];
        $distances = [];
        $value     = null;

        foreach (static::allHexRgbCoordinates() as $color => $values) {
            if ($array === $values) {
                $value = $color;
                break;
            }

            if (!$closest) {
                continue;
            }

            $distances[$color] = \abs(\hexDec($values[0]) - \hexDec($red))
                + \abs(\hexDec($values[1]) - \hexDec($green))
                + \abs(\hexDec($values[2]) - \hexDec($blue))
            ;
        }

        if (\count($distances)) {
            $value ??= \array_search(
                needle   : \min($distances),
                haystack : $distances,
            );
        }

        if (!$value) {
            $value = '#'.\implode('', $array);
        }

        return static::fromCss($value, $fallback, $throw);
    }

    /**
     * Returns the instance of the CssColor enum corresponding to the provided RGB coordinates, if it exists.
     *
     * By default and if the $closest parameter is true, the supported color which has the closest coordinates will be returned.
     *
     * If $closest is false and no supported color matches the provided coordinates, a new UnsupportedCssColor Exception will be
     * thrown by default, except if a $fallback is provided or if the $throw parameter is set to false. In that case, the
     * method will return $fallback.
     *
     * @param  string        $red      Red coordinate of the desired CSS color. It should be a number between 0 and 255
     * @param  string        $green    Green coordinate of the desired CSS color. It should be a number between 0 and 255
     * @param  string        $blue     Blue coordinate of the desired CSS color. It should be a number between 0 and 255
     * @param  boolean       $closest  If true, returns the supported CSS color which is the closest from provided coordinates. If false, throws an Exception or returns $fallback
     * @param  CssColor|null $fallback Instance of the CssColor enum to return in case of failure (null by default)
     * @param  boolean|null  $throw    If false the method will not throw exceptions, $fallback will be returned instead
     *
     * @return static|null
     */
    public static function fromRgb(
        int           $red,
        int           $green,
        int           $blue,
        bool          $closest  = true,
        CssColor|null $fallback = null,
        bool|null     $throw    = null,
    ) :static|null {
        $array     = [ $red, $green, $blue ];
        $distances = [];
        $value     = null;

        foreach (static::allRgbCoordinates() as $color => $values) {
            if ($array === $values) {
                $value = $color;
                break;
            }

            if (!$closest) {
                continue;
            }

            $distances[$color] = \abs($values[0] - $red)
                + \abs($values[1] - $green)
                + \abs($values[2] - $blue)
            ;
        }

        if (\count($distances)) {
            $value ??= \array_search(
                needle   : \min($distances),
                haystack : $distances,
            );
        }

        if (!$value) {
            $value = 'rgb('.\implode(',', $array).')';
        }

        return static::fromCss($value, $fallback, $throw);
    }

    /**
     * Returns an array containing all supported CSS color names.
     *
     * @return array
     */
    public static function names(

    ) :array {
        return \array_map(
            callback : fn ($color) => $color->name,
            array    : static::cases(),
        );
    }

    /* #endregion */

    /* #region Public Methods */

    /**
     * Returns a new instance of matthieumastadenis\couleur\colors\Css corresponding to the current CssColor.
     *
     * @param  Css|null     $fallback An instance of matthieumastadenis\couleur\colors\Css used as a fallback in case of error
     * @param  boolean|null $throw    If false no exception will be thrown, $fallback will be returned instead
     *
     * @return Css|null
     */
    public function toCss(
        Css|null  $fallback  = null,
        bool|null $throw     = null,
    ) :Css|null {
        return ColorFactory::newCss(
            value     : $this->name,
            from      : ColorSpace::Css,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Returns a new instance of matthieumastadenis\couleur\colors\HexRgb corresponding to the current CssColor.
     *
     * @param HexRgb|null  $fallback An instance of matthieumastadenis\couleur\colors\HexRgb used as a fallback in case of error
     * @param boolean|null $throw    If false no exception will be thrown, $fallback will be returned instead
     *
     * @return HexRgb|null
     */
    public function toHexRgb(
        HexRgb|null $fallback  = null,
        bool|null   $throw     = null,
    ) :HexRgb|null {
        return ColorFactory::newHexRgb(
            value     : $this->toHexRgbCoordinates(),
            from      : ColorSpace::HexRgb,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Return an array containing Hexadecimal RGB coordinates corresponding to the current CssColor.
     *
     * @return array
     */
    public function toHexRgbCoordinates(

    ) :array {
        return static::allHexRgbCoordinates()[$this->name];
    }

    /**
     * Returns a string corresponding to the current CssColor exprimed in Hexadecimal RGB according to the CSS syntax.
     *
     * @param  boolean|null $alpha     If true opacity will always be included, if false it will never be included, if null it will be included only if different from FF
     * @param  boolean      $short     If true a short value (like #F00) will be returned if possible, if false the method will always return a long value (like #FF0000)
     * @param  boolean      $uppercase If true the returned string will be in uppercase, if false in lowercase
     * @param  boolean      $sharp     If true the returned string will start with a sharp character (#), if false it won't
     *
     * @return string
     */
    public function toHexRgbString(
        bool|null $alpha     = null,
        bool      $short     = true,
        bool      $uppercase = true,
        bool      $sharp     = true,
    ) :string {
        $values = $this->toHexRgbCoordinates();

        return utils\hexRgb\stringify(
            red       : $values[0],
            green     : $values[1],
            blue      : $values[2],
            opacity   : 'FF',
            alpha     : $alpha,
            short     : $short,
            uppercase : $uppercase,
            sharp     : $sharp,
        );
    }

    /**
     * Returns a new instance of matthieumastadenis\couleur\colors\Rgb corresponding to the current CssColor.
     *
     * @param Rgb|null     $fallback An instance of matthieumastadenis\couleur\colors\Rgb used as a fallback in case of error
     * @param boolean|null $throw    If false no exception will be thrown, $fallback will be returned instead
     *
     * @return Rgb|null
     */
    public function toRgb(
        Rgb|null  $fallback  = null,
        bool|null $throw     = null,
    ) :Rgb|null {
        return ColorFactory::newRgb(
            value     : $this->toRgbCoordinates(),
            from      : ColorSpace::Rgb,
            fallback  : $fallback,
            throw     : $throw,
        );
    }

    /**
     * Return an array containing RGB coordinates corresponding to the current CssColor.
     *
     * @return array
     */
    public function toRgbCoordinates(

    ) :array {
        return static::allRgbCoordinates()[$this->name];
    }

    /**
     * Returns a string corresponding to the current CssColor exprimed in RGB according to the CSS syntax.
     *
     * @param  boolean|null $legacy    If true the returned string will use the old CSS syntax (like rgb(255,0,0)), if false the modern one (rgb(100% 0% 0% / 100%)), if null it will depend on the value of the COULEUR_LEGACY constant
     * @param  boolean|null $alpha     If true opacity will always be included, if false it will never be included, if null it will be included only if different from FF
     *
     * @return string
     */
    public function toRgbString(
        bool|null $legacy = null,
        bool|null $alpha  = null,
    ) :string {
        $values = $this->toRgbCoordinates();

        return utils\rgb\stringify(
            red       : $values[0],
            green     : $values[1],
            blue      : $values[2],
            opacity   : 255,
            legacy    : $legacy,
            alpha     : $alpha,
            precision : 0,
        );
    }

    /* #endregion */

}
