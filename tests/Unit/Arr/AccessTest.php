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
use FireHub\Runtime\Exception\ {
    EmptyArrayException, InvalidRangeException
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Array Runtime Wrapper Utility - Access
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Arr\Access::class)]
final class AccessTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param array-key $key
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([true, 2, [1, 2, 3]])]
    #[TestWith([false, 3, [1, 2, 3]])]
    #[TestWith([false, 'x', [null, 2, 3]])]
    public function testKeyExists (bool $expected, int|string $key, array $array):void {

        self::assertSame($expected, Arr\Access::keyExists($key, $array));

    }

    /**
     * @since 1.0.0
     *
     * @param int|string|false $expected
     * @param array<array-key, mixed> $array
     * @param mixed $value
     *
     * @return void
     */
    #[TestWith(['two', ['one' => 1, 'two' => 2, 'three' => 3], 2])]
    #[TestWith([false, ['one' => 1, 'two' => 2, 'three' => 3], 5])]
    public function testSearch (int|string|false $expected, array $array, mixed $value):void {

        self::assertSame($expected, Arr\Access::search($array, $value));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array-key $key
     * @param null|array-key $index
     *
     * @return void
     */
    #[TestWith([[3 => 2, 6 => 5, 9 => 8], ['one' => [1, 2, 3], 'two' => [4, 5, 6], 'three' => [7, 8, 9]], 1, 2])]
    public function testColumn (array $expected, array $array, int|string $key, null|int|string $index = null):void {

        self::assertSame($expected, Arr\Access::column($array, $key, $index));

    }

    /**
     * @since 1.0.0
     *
     * @param null|array-key $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([1, ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testFirst (mixed $expected, array $array):void {

        self::assertSame($expected, Arr\Access::first($array));

    }

    /**
     * @since 1.0.0
     *
     * @param null|array-key $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([3, ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testLast (mixed $expected, array $array):void {

        self::assertSame($expected, Arr\Access::last($array));

    }

    /**
     * @since 1.0.0
     *
     * @param null|array-key $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith(['one', ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testFirstKey (null|int|string $expected, array $array):void {

        self::assertSame($expected, Arr\Access::firstKey($array));

    }

    /**
     * @since 1.0.0
     *
     * @param null|array-key $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith(['three', ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testLastKey (null|int|string $expected, array $array):void {

        self::assertSame($expected, Arr\Access::lastKey($array));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param mixed $filter
     *
     * @return void
     */
    #[TestWith([['one', 'two', 'three'], ['one' => 1, 'two' => 2, 'three' => 3], null])]
    #[TestWith([[''], ['' => 3], null])]
    #[TestWith([['two'], ['one' => 1, 'two' => 2, 'three' => 3], 2])]
    public function testKeys (array $expected, array $array, mixed $filter):void {

        self::assertSame($expected, Arr\Access::keys($array, $filter));

    }

    /**
     * @since 1.0.0
     *
     * @param list[] $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([[1, 2, 3], ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testValues (array $expected, array $array):void {

        self::assertSame($expected, Arr\Access::values($array));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([2, ['one' => 1, 'two' => 2, 'three' => 3]])]
    #[TestWith([null, ['one' => 1, 'three' => 3]])]
    public function testFind (mixed $expected, array $array):void {

        self::assertSame(
            $expected,
            Arr\Access::find($array, static fn($value, $key) => $value === 2)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param null|array-key $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith(['two', ['one' => 1, 'two' => 2, 'three' => 3]])]
    #[TestWith([null, ['one' => 1, 'three' => 3]])]
    public function testFindKey (mixed $expected, array $array):void {

        self::assertSame(
            $expected,
            Arr\Access::findKey($array, static fn($value, $key) => $value === 2)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     *
     * @throws \FireHub\Runtime\Exception\EmptyArrayException
     * @throws \FireHub\Runtime\Exception\InvalidRangeException
     *
     * @return void
     */
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testRandom (array $array):void {

        self::assertArrayHasKey(Arr\Access::random($array), $array);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     * @param positive-int $number
     *
     * @throws \FireHub\Runtime\Exception\EmptyArrayException
     * @throws \FireHub\Runtime\Exception\InvalidRangeException
     *
     * @return void
     */
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3], 2])]
    public function testRandomMultiple (array $array, int $number):void {

        $expected = Arr\Access::random($array, $number);

        self::assertIsArray($expected);
        self::assertCount($number, $expected);

        foreach ($expected as $key)
            self::assertArrayHasKey($key, $array);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     * @param positive-int $number
     *
     * @throws \FireHub\Runtime\Exception\InvalidRangeException
     *
     * @return void
     */
    #[TestWith([[], 1])]
    public function testRandomEmptyArray (array $array, int $number):void {

        $this->expectException(EmptyArrayException::class);

        Arr\Access::random($array, $number);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     * @param positive-int $number
     *
     * @throws \FireHub\Runtime\Exception\EmptyArrayException
     *
     * @return void
     */
    #[TestWith([[1, 1, 1, 2, 3], 0])]
    #[TestWith([[1, 1, 1, 2, 3], 10])]
    public function testRandomInvalidRange (array $array, int $number):void {

        $this->expectException(InvalidRangeException::class);

        Arr\Access::random($array, $number);

    }

}