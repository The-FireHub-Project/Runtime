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

namespace FireHub\Tests\Runtime\Unit\Math;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Math\LogBase;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small
};

/**
 * ### Test PHP Runtime Logarithmic Bases
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(LogBase::class)]
final class LogBaseTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testValue ():void {

        self::assertSame(
            M_E,
            LogBase::E->value()
        );

        self::assertSame(
            M_LOG2E,
            LogBase::LOG2E->value()
        );

        self::assertSame(
            M_LOG10E,
            LogBase::LOG10E->value()
        );

        self::assertSame(
            M_LN2,
            LogBase::LN2->value()
        );

        self::assertSame(
            M_LN10,
            LogBase::LN10->value()
        );

    }

}