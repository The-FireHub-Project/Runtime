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

namespace FireHub\Tests\Runtime\Unit\Date;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Date;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Solar Calculation Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Date\Solar::class)]
final class SolarTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param int $timestamp
     * @param float $latitude
     * @param float $longitude
     *
     * @return void
     */
    #[TestWith([0, 40.730610, -73.935242])]
    public function testInfo (int $timestamp, float $latitude, float $longitude):void {

        $get = Date\Solar::info($timestamp, $latitude, $longitude);

        self::assertIsInt($get['sunrise']);
        self::assertIsInt($get['sunset']);
        self::assertIsInt($get['transit']);
        self::assertIsInt($get['civil_twilight_begin']);
        self::assertIsInt($get['civil_twilight_end']);
        self::assertIsInt($get['nautical_twilight_begin']);
        self::assertIsInt($get['nautical_twilight_end']);
        self::assertIsInt($get['astronomical_twilight_begin']);
        self::assertIsInt($get['astronomical_twilight_end']);

    }

}