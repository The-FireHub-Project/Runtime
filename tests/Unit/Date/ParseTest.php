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
use FireHub\Runtime\Exception\{
    CannotParseTimestampException, ParseFromFormatException
};
use FireHub\Tests\Runtime\DataProviders\DateDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Group, Small, TestWith
};

/**
 * ### Test Date Parsing Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Date\Parse::class)]
final class ParseTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $datetime
     *
     * @return void
     */
    #[DataProviderExternal(DateDataProvider::class, 'stringToTime')]
    public function testDate (string $datetime):void {

        self::assertEmpty(Date\Parse::date($datetime)['errors']);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $format
     * @param non-empty-string $datetime
     *
     * @throws \FireHub\Runtime\Exception\ParseFromFormatException
     *
     * @return void
     */
    #[TestWith(['j.n.Y H:iP', '6.1.2009 13:00+01:00'])]
    public function testDateFromFormat (string $format, string $datetime):void {

        self::assertEmpty(Date\Parse::dateFromFormat($format, $datetime)['errors']);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $format
     * @param non-empty-string $datetime
     *
     * @return void
     */
    #[TestWith(['Y', "\0"])]
    public function testParseFromFormatContainsNulByte (string $format, string $datetime):void {

        $this->expectException(ParseFromFormatException::class);

        Date\Parse::dateFromFormat($format, $datetime);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $datetime
     *
     * @throws \FireHub\Runtime\Exception\CannotParseTimestampException
     *
     * @return void
     */
    #[DataProviderExternal(DateDataProvider::class, 'stringToTime')]
    public function testTimestamp (string $datetime):void {

        self::assertIsInt(Date\Parse::timestamp($datetime));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $datetime
     *
     * @return void
     */
    #[TestWith(['NotTime'])]
    public function testTimestampNotTime (string $datetime):void {

        $this->expectException(CannotParseTimestampException::class);

        Date\Parse::timestamp($datetime);

    }

}