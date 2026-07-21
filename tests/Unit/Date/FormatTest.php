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
 * ### Test Date Formatting Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Date\Format::class)]
final class FormatTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $format
     * @param null|int $timestamp
     * @param bool $gmt
     *
     * @return void
     */
    #[TestWith(['1970-01-01T00:00:00+00:00', DATE_ATOM, 0, true])]
    #[TestWith(['Thursday, 01-Jan-1970 00:00:00 GMT', DATE_COOKIE, 0, true])]
    #[TestWith(['Thu, 01 Jan 1970 00:00:00 +0000', DATE_RSS, 0, true])]
    public function testString (string $expected, string $format, ?int $timestamp, bool $gmt):void {

        self::assertSame($expected, Date\Format::string($format, $timestamp, $gmt));

    }

    /**
     * @since 1.0.0
     *
     * @param int $expected
     * @param string $format
     * @param null|int $timestamp
     *
     * @throws \FireHub\Runtime\Exception\FailedToFormatTimestampAsIntException
     *
     * @return void
     */
    #[TestWith([70, 'y', 0])]
    #[TestWith([1970, 'Y', 0])]
    #[TestWith([1, 'd', 0])]
    #[TestWith([0, 'z', 0])]
    #[TestWith([1, 'W', 0])]
    #[TestWith([4, 'w', 0])]
    #[TestWith([0, 'U', 0])]
    #[TestWith([31, 't', 0])]
    #[TestWith([0, 's', 0])]
    #[TestWith([1, 'm', 0])]
    #[TestWith([0, 'i', 0])]
    public function testInteger (int $expected, string $format, ?int $timestamp):void {

        self::assertSame($expected, Date\Format::integer($format, $timestamp));

    }

}