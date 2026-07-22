<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.1
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\Unit\Math;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Math\RoundMode;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small
};
use RoundingMode;

/**
 * ### Test PHP Runtime Number Rounding Modes
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(RoundMode::class)]
final class RoundModeTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testToNative ():void {

        self::assertSame(
            RoundingMode::HalfAwayFromZero,
            RoundMode::HALF_AWAY_FROM_ZERO->toNative()
        );

        self::assertSame(
            RoundingMode::HalfTowardsZero,
            RoundMode::HALF_TOWARDS_ZERO->toNative()
        );

        self::assertSame(
            RoundingMode::HalfEven,
            RoundMode::HALF_EVEN->toNative()
        );

        self::assertSame(
            RoundingMode::HalfOdd,
            RoundMode::HALF_ODD->toNative()
        );

        self::assertSame(
            RoundingMode::TowardsZero,
            RoundMode::TOWARDS_ZERO->toNative()
        );

        self::assertSame(
            RoundingMode::AwayFromZero,
            RoundMode::AWAY_FROM_ZERO->toNative()
        );

        self::assertSame(
            RoundingMode::NegativeInfinity,
            RoundMode::NEGATIVE_INFINITY->toNative()
        );

        self::assertSame(
            RoundingMode::PositiveInfinity,
            RoundMode::POSITIVE_INFINITY->toNative()
        );

    }

}