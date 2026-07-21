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
    CoversClass, Group, Small
};

/**
 * ### Test Clock and Current Time Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Date\Clock::class)]
final class ClockTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testTime ():void {

        self::assertIsInt(Date\Clock::time());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testMicrotime ():void {

        self::assertIsFloat(Date\Clock::microtime());

    }

}