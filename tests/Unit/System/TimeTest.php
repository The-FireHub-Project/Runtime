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
use FireHub\Runtime\Exception\InvalidSleepDurationException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime Time Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(System\Time::class)]
final class TimeTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $seconds
     * @param non-negative-int $nanoseconds
     *
     * @throws \FireHub\Runtime\Exception\InvalidSleepDurationException
     *
     * @return void
     */
    #[TestWith([0])]
    #[TestWith([0, 2])]
    public function testSleep (int $seconds, int $nanoseconds = 0):void {

        self::assertTrue(System\Time::sleep($seconds, $nanoseconds));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $seconds
     *
     * @throws \FireHub\Runtime\Exception\InvalidSleepDurationException
     *
     * @return void
     */
    #[TestWith([-1])]
    public function testSleepInvalidSeconds (int $seconds):void {

        $this->expectException(InvalidSleepDurationException::class);

        System\Time::sleep($seconds);

    }

    /**
     * @since 1.0.0
     *
     * @param int<0, 999999> $microseconds
     *
     * @throws \FireHub\Runtime\Exception\InvalidSleepDurationException
     *
     * @return void
     */
    #[TestWith([1])]
    public function testSleepMicroseconds (int $microseconds):void {

        System\Time::sleepMicroseconds($microseconds);

        self::assertTrue(true);

    }

    /**
     * @since 1.0.0
     *
     * @param int $value
     *
     * @return void
     */
    #[TestWith([-1])]
    #[TestWith([1_000_000])]
    public function testSleepMicrosecondsInvalidMicroseconds (int $value):void {

        $this->expectException(InvalidSleepDurationException::class);

        System\Time::sleepMicroseconds($value);

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testSleepUntil ():void {

        self::assertTrue(System\Time::sleepUntil(time() - 10));

    }

}