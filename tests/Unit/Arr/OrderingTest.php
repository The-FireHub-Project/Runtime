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
use FireHub\Core\Meta\Enum\Order;
use FireHub\Runtime\Type\Arr\ {
    SortFlag, SortType
};
use FireHub\Tests\Runtime\DataProviders\ArrDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Group, Small, TestWith
};

/**
 * ### Test PHP Array Runtime Wrapper Utility - Ordering
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Arr\Ordering::class)]
final class OrderingTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param bool $preserve_keys
     * @param \FireHub\Core\Meta\Enum\Order $order
     * @param \FireHub\Runtime\Type\Arr\SortType $type
     * @param \FireHub\Runtime\Type\Arr\SortFlag ...$flags
     *
     * @return void
     */
    #[TestWith([
        ['Orange1', 'orange2', 'Orange3', 'orange20'],
        [1 => 'Orange1', 2 => 'orange2', 3 => 'Orange3', 4 => 'orange20'],
        false,
        Order::ASC,
        SortType::NATURAL,
        SortFlag::CASE_INSENSITIVE
    ])]
    #[TestWith([
        [1 => 'Orange1', 2 => 'orange2', 3 => 'Orange3', 4 => 'orange20'],
        [1 => 'Orange1', 4 => 'orange20', 2 => 'orange2', 3 => 'Orange3'],
        true,
        Order::ASC,
        SortType::NATURAL,
        SortFlag::CASE_INSENSITIVE
    ])]
    #[TestWith([
        ['orange20', 'Orange3', 'orange2', 'Orange1'],
        [1 => 'Orange1', 2 => 'orange2', 3 => 'Orange3', 4 => 'orange20'],
        false,
        Order::DESC,
        SortType::NATURAL,
        SortFlag::CASE_INSENSITIVE
    ])]
    #[TestWith([
        [4 => 'orange20', 3 => 'Orange3', 2 => 'orange2', 1 => 'Orange1'],
        [1 => 'Orange1', 4 => 'orange20', 2 => 'orange2', 3 => 'Orange3'],
        true,
        Order::DESC,
        SortType::NATURAL,
        SortFlag::CASE_INSENSITIVE
    ])]
    public function testSort (array $expected, array $actual, bool $preserve_keys = false, Order $order = Order::ASC, SortType $type = SortType::REGULAR, SortFlag ...$flags):void {

        Arr\Ordering::sort($actual, $preserve_keys, $order, $type, ...$flags);

        self::assertSame($expected, $actual);
    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param \FireHub\Core\Meta\Enum\Order $order
     * @param \FireHub\Runtime\Type\Arr\SortType $type
     * @param \FireHub\Runtime\Type\Arr\SortFlag ...$flags
     *
     * @return void
     */
    #[TestWith([
        ['age' => 25, 'firstname' => 'John', 'gender' => 'male', 'height' => '190cm', 'lastname' => 'Doe'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm', 'gender' => 'male']
    ])]
    #[TestWith([
        ['lastname' => 'Doe', 'height' => '190cm', 'gender' => 'male', 'firstname' => 'John', 'age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm', 'gender' => 'male'],
        Order::DESC,
        SortType::STRING
    ])]
    public function testSortByKeys (array $expected, array $actual, Order $order = Order::ASC, SortType $type = SortType::REGULAR, SortFlag ...$flags):void {

        Arr\Ordering::sortByKeys($actual, $order, $type, ...$flags);

        self::assertSame($expected, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param bool $preserve_keys
     *
     * @return void
     */
    #[TestWith([
        ['190cm', 25, 'Doe', 'John', 'male'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm', 'gender' => 'male']
    ])]
    #[TestWith([
        ['height' => '190cm', 'age' => 25, 'lastname' => 'Doe', 'firstname' => 'John', 'gender' => 'male'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm', 'gender' => 'male'],
        true
    ])]
    public function testSortBy (array $expected, array $actual, bool $preserve_keys = false):void {

        Arr\Ordering::sortBy($actual, static function ($current, $next) {
            if ($current === $next) return 0;
            return ($current < $next) ? -1 : 1;
        }, $preserve_keys);

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
    #[TestWith([
        ['age' => 25, 'firstname' => 'John', 'gender' => 'male', 'height' => '190cm', 'lastname' => 'Doe'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm', 'gender' => 'male']
    ])]
    public function testSortKeysBy (array $expected, array $actual):void {

        Arr\Ordering::sortKeysBy($actual, static function ($current, $next) {
            if ($current === $next) return 0;
            return ($current < $next) ? -1 : 1;
        });

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
    #[TestWith([
        [[0, 10, 100, 100], [4, 1, 2, 3]],
        [[10, 100, 100, 0], [1, 3, 2, 4]]]
    )]
    public function testMultiSort (array $expected, array $actual):void {

        Arr\Ordering::multiSort(...$actual);
        self::assertSame($expected, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $actual
     *
     * @return void
     */
    #[DataProviderExternal(ArrDataProvider::class, 'list')]
    public function testShuffle (array $actual):void {

        $expected = $actual;

        Arr\Ordering::shuffle($actual);

        self::assertEqualsCanonicalizing($expected, $actual);

    }

}