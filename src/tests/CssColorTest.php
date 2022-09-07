<?php

namespace matthieumastadenis\couleur\tests;

use       matthieumastadenis\couleur\CssColor;
use       PHPUnit\Framework\TestCase;

class   CssColorTest 
extends TestCase {

    const COLORS = [        
        'lightpink' => [
            'case'   => CssColor::lightpink,
            'hexRgb' => [ 'FF', 'B6', 'C1' ],
            'rgb'    => [ 255,  182,  193  ],
        ],
        'lightsteelblue' => [
            'case'   => CssColor::lightsteelblue,
            'hexRgb' => [ 'B0', 'C4', 'DE' ],
            'rgb'    => [ 176,  196,  222  ],
        ],
        'mediumorchid' => [
            'case'   => CssColor::mediumorchid,
            'hexRgb' => [ 'BA', '55', 'D3' ],
            'rgb'    => [ 186,  85,   211  ],
        ],
        'papayawhip' => [
            'case'   => CssColor::papayawhip,
            'hexRgb' => [ 'FF', 'EF', 'D5' ],
            'rgb'    => [ 255,  239,  213  ],
        ],
        'red' => [
            'case'   => CssColor::red,
            'hexRgb' => [ 'FF', '00', '00' ],
            'rgb'    => [ 255,  0,    0    ],
        ],
        'slategray' => [
            'case'   => CssColor::slategray,
            'hexRgb' => [ '70', '80', '90' ],
            'rgb'    => [ 112,  128,  144  ],
        ],
    ];

    public function test_cases_returns148Cases(

    ) :void {
        $this->assertCount(148, CssColor::cases());
    }

    public function test_names_returns148ExistingCssColorNames(

    ) :void {
        $names = CssColor::names();

        $this->assertCount(148, $names);

        foreach ($names as $name) {
            $this->assertTrue(CssColor::exists($name));
        }
    }

    public function test_allHexRgbCoordinates_returnsAnArrayOfHexRgbCoordinatesMatchingCssNamedColors(

    ) :void {
        $coordinates = CssColor::allHexRgbCoordinates();

        foreach ($this::COLORS as $name => $data) {
            $this->assertArrayHasKey($name, $coordinates);
            $this->assertSame($data['hexRgb'], $coordinates[$name]);
        }
    }

    public function test_allRgbCoordinates_returnsAnArrayOfRgbCoordinatesMatchingCssNamedColors(

    ) :void {
        $coordinates = CssColor::allRgbCoordinates();

        foreach ($this::COLORS as $name => $data) {
            $this->assertArrayHasKey($name, $coordinates);
            $this->assertSame($data['rgb'], $coordinates[$name]);
        }
    }

    public function test_exists_returnsTrueForExistingCssColorNames(

    ) :void {
        foreach (\array_keys($this::COLORS) as $name) {
            $this->assertTrue(CssColor::exists($name));
        }
    }

    public function test_fromCss_returnsTheCssColorInstanceMatchingProvidedName(

    ) :void {
        foreach ($this::COLORS as $name => $data) {
            $this->assertSame($data['case'], CssColor::fromCss($name));
        }
    }

    public function test_fromHexRgb_returnsTheCssColorInstanceMatchingProvidedHexRgbCoordinates(

    ) :void {
        foreach ($this::COLORS as $name => $data) {
            $this->assertSame($data['case'], CssColor::fromHexRgb(... $data['hexRgb']));
        }
    }

    public function test_fromRgb_returnsTheCssColorInstanceMatchingProvidedRgbCoordinates(

    ) :void {
        foreach ($this::COLORS as $name => $data) {
            $this->assertSame($data['case'], CssColor::fromRgb(... $data['rgb']));
        }
    }

    public function test_toHexRgbCoordinates_returnsAnArrayOfHexRgbCoordinatesMatchingTheCurrentColor(

    ) :void {
        foreach ($this::COLORS as $name => $data) {
            $this->assertSame($data['hexRgb'], $data['case']->toHexRgbCoordinates());
        }
    }

    public function test_toRgbCoordinates_returnsAnArrayOfRgbCoordinatesMatchingTheCurrentColor(

    ) :void {
        foreach ($this::COLORS as $name => $data) {
            $this->assertSame($data['rgb'], $data['case']->toRgbCoordinates());
        }
    }



}