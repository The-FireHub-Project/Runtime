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
use FireHub\Core\Type\Date\Zone;
use FireHub\Tests\Runtime\DataProviders\DateDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Group, Small, TestWith
};

/**
 * ### Test Time Zone Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Date\Timezone::class)]
final class TimezoneTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param \FireHub\Core\Type\Date\Zone $expected
     *
     * @throws \FireHub\Runtime\Exception\FailedToGetTimezoneException
     * @throws \FireHub\Runtime\Exception\FailedToSetTimezoneException
     *
     * @return void
     */
    #[DataProviderExternal(DateDataProvider::class, 'timezones')]
    public function testSetAndGetDefaultTimezone (Zone $expected):void {

        self::assertTrue(Date\Timezone::setDefault($expected));
        self::assertSame($expected, Date\Timezone::getDefault());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testAbbreviationList ():void {

        self::assertIsArray(Date\Timezone::abbreviationList());

    }

}