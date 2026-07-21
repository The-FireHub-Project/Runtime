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

namespace FireHub\Tests\Runtime\Unit;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\ {
    Shutdown, Tick
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small
};

/**
 * ### Test PHP Runtime Shutdown and Tick Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Shutdown::class)]
#[CoversClass(Tick::class)]
final class ShutdownTickTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Runtime\Exception\RegisterTickFailedException
     *
     * @return void
     */
    public function testRegisterFunctions ():void {

        $func = static fn() => 'x';

        self::assertTrue(Tick::register($func));

        Tick::unregister($func);

        Shutdown::register($func);

    }

}