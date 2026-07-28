<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.0
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\Unit\Arr;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Arr;
use FireHub\Tests\Runtime\DataProviders\ArrDataProvider;
use FireHub\Tests\Runtime\Stubs\CountableClass;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Group, Small, TestWith
};
use Countable;

/**
 * ### Test PHP Array Runtime Wrapper Utility - Inspection
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Arr\Inspection::class)]
final class InspectionTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param array<array-key, mixed> $array
     * @param mixed $result
     *
     * @return void
     */
    #[TestWith([true, [1, 2, 3], 0.5])]
    #[TestWith([true, ['x', 'y', 'z'], 'e'])]
    #[TestWith([false, ['x', 'y', 'z'], 'y'])]
    public function testAll (bool $expected, array $array, mixed $result):void {

        self::assertSame($expected, Arr\Inspection::all($array, static fn($value) => $value >= $result));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param array<array-key, mixed> $array
     * @param mixed $result
     *
     * @return void
     */
    #[TestWith([true, [1, 2, 3], 2])]
    #[TestWith([false, [1, 2, 3], 2.5])]
    #[TestWith([true, ['x', 'y', 'z'], 'y'])]
    #[TestWith([false, ['x', 'y', 'z'], 'e'])]
    public function testAny (bool $expected, array $array, mixed $result):void {

        self::assertSame($expected, Arr\Inspection::any($array, static fn($value) => $value === $result));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param array<array-key, mixed> $array
     * @param mixed $value
     *
     * @return void
     */
    #[TestWith([true, [1, 2, 3], 2])]
    #[TestWith([false, [1, 2, 3], 4])]
    #[TestWith([true, [null, 2, 3], null])]
    public function testInArray (bool $expected, array $array, mixed $value):void {

        self::assertSame($expected, Arr\Inspection::inArray($array, $value));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[DataProviderExternal(ArrDataProvider::class, 'list')]
    public function testIsList (array $array):void {

        self::assertTrue(Arr\Inspection::isList($array));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[DataProviderExternal(ArrDataProvider::class, 'associative')]
    #[DataProviderExternal(ArrDataProvider::class, 'multidimensional')]
    public function testIsNotList (array $array):void {

        self::assertFalse(Arr\Inspection::isList($array));

    }

    /**
     * @since 1.0.0
     *
     * @param int $expected
     * @param array<array-key, mixed>|Countable $value
     * @param bool $recursive
     *
     * @return void
     */
    #[TestWith([2, [1, 2]])]
    #[TestWith([0, []])]
    #[TestWith([5, [1, 2, [1, 1]], true])]
    public function testCount (int $expected, array|Countable $value, bool $recursive = false):void {

        self::assertSame($expected, Arr\Inspection::count($value, $recursive));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testCountWithCountable ():void {

        self::assertSame(10, Arr\Inspection::count(new CountableClass()));

    }

    /**
     * @since 1.0.0
     *
     * @param positive-int[] $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([[1 => 1, 2 => 1], [1, 2]])]
    #[TestWith([[], []])]
    public function testCountValues (array $expected, array $array):void {

        self::assertSame($expected, Arr\Inspection::countValues($array));

    }

}