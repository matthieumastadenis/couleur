<?php

namespace matthieumastadenis\couleur\tests\utils\hexRgb;

use       matthieumastadenis\couleur\utils\hexRgb;
use       PHPUnit\Framework\TestCase;

class   StringifyTest 
extends TestCase {

    const LOOPS = 30;
    const CHARS = [ 
        '0', '1', '2', '3', 
        '4', '5', '6', '7', 
        '8', '9', 'A', 'B', 
        'C', 'D', 'E', 'F',
    ];

    protected function randomChar(
        string|null $not = null,
    ) :string {
        $char = null;

        while (\in_array($char, [ null, $not ], true)) {
            $char = $this::CHARS[\array_rand($this::CHARS)];
        }

        return $char;
    }

    protected function randomNumber(
        bool        $same = false,
        string|null $not  = null,
    ) :string {
        $c1     = $this->randomChar();
        $number = $same
            ? $c1.$c1
            : $c1.$this->randomChar($c1)
        ;

        while ($number === $not) {
            $number = $this->randomNumber($same);
        }

        return $number;
    }

    public function test_resultStartsWithSharpByDefault(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $same = (bool) $i % 2;
            $r    = $this->randomNumber($same);
            $g    = $this->randomNumber($same);
            $b    = $this->randomNumber($same);

            $this->assertStringStartsWith(
                prefix : '#',
                string : hexRgb\stringify($r, $g, $b),
            );
        }
    }

    public function test_resultStartsWithSharpIfSharpParamIsTrue(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $same = (bool) $i % 2;
            $r    = $this->randomNumber($same);
            $g    = $this->randomNumber($same);
            $b    = $this->randomNumber($same);

            $this->assertStringStartsWith(
                prefix : '#',
                string : hexRgb\stringify($r, $g, $b, sharp : true),
            );
        }
    }

    public function test_resultDoesNotStartWithSharpIfSharpParamIsFalse(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $same = (bool) $i % 2;
            $r    = $this->randomNumber($same);
            $g    = $this->randomNumber($same);
            $b    = $this->randomNumber($same);

            $this->assertStringStartsNotWith(
                prefix : '#',
                string : hexRgb\stringify($r, $g, $b, sharp : false),
            );
        }
    }

    public function test_resultDoesNotIncludeOpacityByDefault(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $same = (bool) $i % 2;
            $r    = $this->randomNumber($same);
            $g    = $this->randomNumber($same);
            $b    = $this->randomNumber($same);

            $this->assertSame(
                expected : $same ? 4 : 7,
                actual   : \strlen(hexRgb\stringify($r, $g, $b)),
            );
        }
    }

    public function test_resultDoesNotIncludeOpacityIfItsFFByDefault(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $same = (bool) $i % 2;
            $r    = $this->randomNumber($same);
            $g    = $this->randomNumber($same);
            $b    = $this->randomNumber($same);
            $o    = $same ? 'FF' : 'ff';

            $this->assertSame(
                expected : $same ? 4 : 7,
                actual   : \strlen(hexRgb\stringify($r, $g, $b, $o)),
            );
        }
    }

    public function test_resultIncludesOpacityIfItsNotFFByDefault(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $same = (bool) $i % 2;
            $r    = $this->randomNumber($same);
            $g    = $this->randomNumber($same);
            $b    = $this->randomNumber($same);
            $o    = $this->randomNumber($same, 'FF');
            $hex  = hexRgb\stringify($r, $g, $b, $o);

            $this->assertSame(
                expected : $same ? 5 : 9,
                actual   : \strlen($hex),
            );

            $this->assertStringEndsWith(
                suffix : $same ? $o[0] : $o,
                string : $hex,
            );
        }
    }

    public function test_resultDoesNotIncludeOpacityIfAlphaParamIsFalse(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $same = (bool) $i % 2;
            $r    = $this->randomNumber($same);
            $g    = $this->randomNumber($same);
            $b    = $this->randomNumber($same);
            $o    = $this->randomNumber($same);

            $this->assertSame(
                expected : $same ? 4 : 7,
                actual   : \strlen(hexRgb\stringify($r, $g, $b, $o, alpha : false)),
            );
        }
    }

    public function test_resultAlwaysIncludeOpacityIfAlphaParamIsTrue(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $same = (bool) $i % 2;
            $r    = $this->randomNumber($same);
            $g    = $this->randomNumber($same);
            $b    = $this->randomNumber($same);
            $o    = $i ? $this->randomNumber($same) : 'FF';
            $hex  = hexRgb\stringify($r, $g, $b, $o, alpha : true);

            $this->assertSame(
                expected : $same ? 5 : 9,
                actual   : \strlen($hex),
            );

            $this->assertStringEndsWith(
                suffix : $same ? $o[0] : $o,
                string : $hex,
            );
        }
    }

    public function test_shortValuesProduceTheSameResultAsLongValuesByDefault(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $r = $this->randomChar();
            $g = $this->randomChar();
            $b = $this->randomChar();

            $this->assertSame(
                expected : hexRgb\stringify($r, $g, $b),
                actual   : hexRgb\stringify($r.$r, $g.$g, $b.$b),
            );
        }
    }

    public function test_shortValuesProduceTheSameResultAsLongValuesIfShortParamMatches(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $r     = $this->randomChar();
            $g     = $this->randomChar();
            $b     = $this->randomChar();
            $short = (bool) $i % 2;

            $this->assertSame(
                expected : hexRgb\stringify($r, $g, $b, short : $short),
                actual   : hexRgb\stringify($r.$r, $g.$g, $b.$b, short : $short),
            );
        }
    }

    public function test_returnsShortValuesIfPossibleByDefault(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $r1 = $this->randomNumber(true);
            $g1 = $this->randomNumber(true);
            $b1 = $this->randomNumber(true);
            $r2 = $this->randomNumber(false);
            $g2 = $this->randomNumber(false);
            $b2 = $this->randomNumber(false);

            $this->assertSame(
                expected : 4,
                actual   : \strlen(hexRgb\stringify($r1, $g1, $b1)),
            );

            $this->assertSame(
                expected : 7,
                actual   : \strlen(hexRgb\stringify($r2, $g2, $b2)),
            );
        }
    }

    public function test_alwaysReturnsShortValuesIfPossibleAndIfShortParamIsTrue(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $r1 = $this->randomNumber(true);
            $g1 = $this->randomNumber(true);
            $b1 = $this->randomNumber(true);
            $r2 = $this->randomNumber(false);
            $g2 = $this->randomNumber(false);
            $b2 = $this->randomNumber(false);

            $this->assertSame(
                expected : 4,
                actual   : \strlen(hexRgb\stringify($r1, $g1, $b1, short : true)),
            );

            $this->assertSame(
                expected : 7,
                actual   : \strlen(hexRgb\stringify($r2, $g2, $b2, short : true)),
            );
        }
    }

    public function test_alwaysReturnsLongValuesIfShortParamIsFalse(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $r1 = $this->randomNumber(true);
            $g1 = $this->randomNumber(true);
            $b1 = $this->randomNumber(true);
            $r2 = $this->randomNumber(false);
            $g2 = $this->randomNumber(false);
            $b2 = $this->randomNumber(false);

            $this->assertSame(
                expected : 7,
                actual   : \strlen(hexRgb\stringify($r1, $g1, $b1, short : false)),
            );

            $this->assertSame(
                expected : 7,
                actual   : \strlen(hexRgb\stringify($r2, $g2, $b2, short : false)),
            );
        }
    }

    public function test_resultCaseMatchesInputCaseByDefault(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $upper = (bool) $i % 2;
            $r1    = $this->randomNumber(true);
            $g1    = $this->randomNumber(true);
            $b1    = $this->randomNumber(true);

            if ($upper) {
                $r1   = \strtoupper($r1);
                $g1   = \strtoupper($g1);
                $b1   = \strtoupper($b1);
            }
            else {
                $r1   = \strtolower($r1);
                $g1   = \strtolower($g1);
                $b1   = \strtolower($b1);
            }

            $hex = hexRgb\stringify($r1, $g1, $b1);

            $this->assertSame(
                expected : $hex,
                actual   : $upper ? \strtoupper($hex) : \strtolower($hex),
            );
        }
    }

    public function test_resultIsInUppercaseIfUppercaseParamIsTrue(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $upper = (bool) $i % 2;
            $r1    = $this->randomNumber(true);
            $g1    = $this->randomNumber(true);
            $b1    = $this->randomNumber(true);

            if ($upper) {
                $r1   = \strtoupper($r1);
                $g1   = \strtoupper($g1);
                $b1   = \strtoupper($b1);
            }
            else {
                $r1   = \strtolower($r1);
                $g1   = \strtolower($g1);
                $b1   = \strtolower($b1);
            }

            $hex = hexRgb\stringify($r1, $g1, $b1, uppercase : true);

            $this->assertSame(
                expected : $hex,
                actual   : \strtoupper($hex),
            );
        }
    }

    public function test_resultIsInLowercaseIfUppercaseParamIsFalse(

    ) :void {
        for ($i = 0; $i < $this::LOOPS; $i++) {
            $upper = (bool) $i % 2;
            $r1    = $this->randomNumber(true);
            $g1    = $this->randomNumber(true);
            $b1    = $this->randomNumber(true);

            if ($upper) {
                $r1   = \strtoupper($r1);
                $g1   = \strtoupper($g1);
                $b1   = \strtoupper($b1);
            }
            else {
                $r1   = \strtolower($r1);
                $g1   = \strtolower($g1);
                $b1   = \strtolower($b1);
            }
            
            $hex = hexRgb\stringify($r1, $g1, $b1, uppercase : false);

            $this->assertSame(
                expected : $hex,
                actual   : \strtolower($hex),
            );
        }
    }

}