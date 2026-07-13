<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=7.0
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\Unit\Arr;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Arr;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Array Runtime Wrapper Utility - Pointer
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Arr\Pointer::class)]
final class PointerTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testInternalPointers (array $array):void {

        Arr\Pointer::reset($array);

        self::assertSame(1, Arr\Pointer::current($array));

        self::assertSame(2, Arr\Pointer::next($array));

        self::assertSame(1, Arr\Pointer::prev($array));

        self::assertSame(3, Arr\Pointer::end($array));

        self::assertSame('three', Arr\Pointer::key($array));

    }

}