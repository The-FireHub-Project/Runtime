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
 * ### Test PHP Byte-Oriented String Runtime Wrapper Utility - Inspection
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\SB\Inspection::class)]
final class InspectionTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith([34, 'The lazy fox jumped over the fence'])]
    #[TestWith([0, ''])]
    public function testLength (int $expected, string $string):void {

        self::assertSame($expected, Str\SB\Inspection::length($string));

    }

    /**
     * @since 1.0.0
     *
     * @param int $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith([2191738434, 'The quick brown fox jumped over the lazy dog.'])]
    public function testCrc32 (int $expected, string $string):void {

        self::assertSame($expected, Str\SB\Inspection::crc32($string));

    }

}