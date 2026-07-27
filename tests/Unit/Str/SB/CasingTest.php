<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=7.4
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\Unit\Str\SB;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Str;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Single-Byte String Runtime Wrapper Utility - Casing
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\SB\Casing::class)]
final class CasingTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['the lazy fox jumped over the fence', 'The lazy fox jumped over the fence'])]
    public function testToLower (string $expected, string $string):void {

        self::assertSame($expected, Str\SB\Casing::toLower($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['THE LAZY FOX JUMPED OVER THE FENCE', 'The lazy fox jumped over the fence'])]
    public function testToUpper (string $expected, string $string):void {

        self::assertSame($expected, Str\SB\Casing::toUpper($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['The Lazy Fox Jumped Over The Fence', 'The lazy fox jumped over the fence'])]
    public function testToTitle (string $expected, string $string):void {

        self::assertSame($expected, Str\SB\Casing::toTitle($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['The lazy fox jumped over the fence', 'the lazy fox jumped over the fence'])]
    public function testCapitalize (string $expected, string $string):void {

        self::assertSame($expected, Str\SB\Casing::capitalize($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['the lazy fox jumped over the fence', 'The lazy fox jumped over the fence'])]
    public function testUncapitalize (string $expected, string $string):void {

        self::assertSame($expected, Str\SB\Casing::uncapitalize($string));

    }

}