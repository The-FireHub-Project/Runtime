<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.0
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\Unit\Date;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Date;
use FireHub\Tests\Runtime\DataProviders\DateDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Group, Small, TestWith
};

/**
 * ### Test Calendar Date Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Date\Calendar::class)]
final class CalendarTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param int<1, 32767> $year
     * @param int<1, 12> $month
     * @param int<1, 31> $day
     *
     * @return void
     */
    #[DataProviderExternal(DateDataProvider::class, 'validDates')]
    public function testCheckValid (int $year, int $month, int $day):void {

        self::assertTrue(Date\Calendar::check($year, $month, $day));

    }

    /**
     * @since 1.0.0
     *
     * @param string $info
     * @param mixed $expected
     * @param null|int $timestamp
     *
     * @return void
     */
    #[TestWith(['seconds', 0, 0])]
    #[TestWith(['minutes', 0, 0])]
    #[TestWith(['mday', 1, 0])]
    #[TestWith(['wday', 4, 0])]
    #[TestWith(['mon', 1, 0])]
    #[TestWith(['year', 1970, 0])]
    #[TestWith(['yday', 0, 0])]
    #[TestWith(['weekday', 'Thursday', 0])]
    #[TestWith(['month', 'January', 0])]
    #[TestWith(['timestamp', 0, 0])]
    #[TestWith(['timestamp', 0, 0])]
    public function testInfo (string $info, mixed $expected, ?int $timestamp):void {

        self::assertSame($expected, Date\Calendar::info($timestamp)[$info]);

    }

}