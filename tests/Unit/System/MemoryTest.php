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
 * ### Test PHP Runtime Memory Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(System\Memory::class)]
final class MemoryTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testGetUsage ():void {

        self::assertIsInt(System\Memory::getUsage());
        self::assertTrue(System\Memory::getUsage() > 0);

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testGetPeakUsage ():void {

        self::assertIsInt(System\Memory::getPeakUsage());
        self::assertTrue(System\Memory::getPeakUsage() > 0);

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testResetPeakUsage ():void {

        System\Memory::resetPeakUsage();

        self::assertTrue(true);

    }

}