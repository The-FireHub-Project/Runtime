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

namespace FireHub\Tests\Runtime\Unit\System;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\System;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small
};

/**
 * ### Test Runtime Clock Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(System\Clock::class)]
final class ClockTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testTime ():void {

        $before = time();

        $result = System\Clock::time();

        $after = time();

        self::assertIsInt($result);
        self::assertGreaterThan(0, $result);

        self::assertGreaterThanOrEqual($before, $result);
        self::assertLessThanOrEqual($after, $result);

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testMicrotime ():void {

        $before = microtime(true);

        $result = System\Clock::microtime();

        $after = microtime(true);

        self::assertIsFloat($result);
        self::assertGreaterThan(0, $result);

        self::assertGreaterThanOrEqual($before, $result);
        self::assertLessThanOrEqual($after, $result);

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testHighResolution ():void {

        $time = System\Clock::highResolution();

        self::assertIsArray($time);
        self::assertCount(2, $time);

        self::assertIsInt($time[0]);
        self::assertIsInt($time[1]);

        self::assertGreaterThanOrEqual(0, $time[0]);
        self::assertGreaterThanOrEqual(0, $time[1]);

    }

}