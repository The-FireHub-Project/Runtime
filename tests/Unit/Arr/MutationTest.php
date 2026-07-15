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

namespace FireHub\Tests\Runtime\Unit\Arr;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Arr;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Array Runtime Wrapper Utility - Mutation
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Arr\Mutation::class)]
final class MutationTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     *
     * @return void
     */
    #[TestWith([[1, 2], [1, 2, 3]])]
    public function testPop (array $expected, array $actual):void {

        Arr\Mutation::pop($actual);

        self::assertSame($expected, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param mixed ...$values
     *
     * @return void
     */
    #[TestWith([[1, 2, 3, 4], [1, 2, 3], 4])]
    public function testPush (array $expected, array $actual, mixed ...$values):void {

        Arr\Mutation::push($actual, ...$values);

        self::assertSame($expected, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     *
     * @return void
     */
    #[TestWith([[2, 3], [1, 2, 3]])]
    public function testShift (array $expected, array $actual):void {

        Arr\Mutation::shift($actual);

        self::assertSame($expected, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param mixed ...$values
     *
     * @return void
     */
    #[TestWith([[0, 1, 2, 3], [1, 2, 3], 0])]
    public function testUnshift (array $expected, array $actual, mixed ...$values):void {

        Arr\Mutation::unshift($actual, ...$values);

        self::assertSame($expected, $actual);

    }

}