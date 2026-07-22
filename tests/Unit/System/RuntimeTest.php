<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.1
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\Unit\System;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\System;
use FireHub\Core\Type\Version\Constraint;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime Introspection Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(System\Runtime::class)]
final class RuntimeTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Runtime\Exception\SapiUnavailableException
     *
     * @return void
     */
    public function testServerAPI ():void {

        self::assertIsString(System\Runtime::serverAPI());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testPhpVersion ():void {

        self::assertSame(System\Runtime::phpVersion(), System\Runtime::phpVersion('Core'));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testZendVersion ():void {

        self::assertIsString(System\Runtime::zendVersion());

    }

    /**
     * @since 1.0.0
     *
     * @param int-mask<-1, 0, 1>|bool $excepted
     * @param string $first
     * @param string $second
     * @param null|\FireHub\Core\Type\Version\Constraint $comparison
     *
     * @return void
     */
    #[TestWith([-1, '1.0.0', '1.0.1'])]
    #[TestWith([0, '1.0.0', '1.0.0'])]
    #[TestWith([1, '2.0.0', '1.0.0'])]
    #[TestWith([true, '2.0.0', '1.0.0', Constraint::GREATER])]
    #[TestWith([false, '2.0.0', '3.0.0', Constraint::GREATER])]
    public function testCompareVersion (int|bool $excepted, string $first, string $second, ?Constraint $comparison = null):void {

        self::assertSame($excepted, System\Runtime::compareVersion($first, $second, $comparison));

    }

}