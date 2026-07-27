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
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Unix Timestamp Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Date\Timestamp::class)]
final class TimestampTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param int<0, 24> $hour
     * @param null|int<0, 59> $minute
     * @param null|int<0, 59> $second
     * @param null|int $year
     * @param null|int<0, 12> $month
     * @param null|int<0, 31> $day
     * @param bool $gmt
     *
     * @throws \FireHub\Runtime\Exception\CannotCreateTimestampException
     *
     * @return void
     */
    #[TestWith([0, 0, 0, 1970, 1, 1])]
    #[TestWith([0, 0, 0, 1970, 1, 1, true])]
    public function testCreate (int $hour, ?int $minute = null, ?int $second = null, ?int $year = null, ?int $month =
    null, ?int $day = null, bool $gmt = false):void {

        self::assertIsInt(Date\Timestamp::create($hour, $minute, $second, $year, $month, $day, $gmt));

    }

}