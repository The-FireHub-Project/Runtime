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
use FireHub\Runtime\Type\Arr\KeyCase;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Array Runtime Wrapper Utility - Transform
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Arr\Transform::class)]
final class TransformTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param mixed $expected
     * @param array<array-key, mixed> $array
     * @param mixed $initial
     *
     * @return void
     */
    #[TestWith([6, [1, 2, 3]])]
    #[TestWith([9, [1, 2, 3], 3])]
    public function testReduce (mixed $expected, array $array, mixed $initial = null):void {

        if ($initial === null)
            self::assertSame($expected, Arr\Transform::reduce($array, static fn($carry, $item) => $carry + $item));
        else
            self::assertSame($expected, Arr\Transform::reduce($array, static fn($carry, $item) => $carry + $item, $initial));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param \FireHub\Runtime\Type\Arr\KeyCase $style
     *
     * @return void
     */
    #[TestWith([['ONE' => 1, 'TWO' => 2, 'THREE' => 3], ['one' => 1, 'two' => 2, 'three' => 3], KeyCase::UPPER])]
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3], ['ONE' => 1, 'TWO' => 2, 'THREE' => 3], KeyCase::LOWER])]
    public function testFoldKeys (array $expected, array $array, KeyCase $style):void {

        self::assertSame($expected, Arr\Transform::keyCase($array, $style));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([['three' => 3], ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testFilter (array $expected, array $array):void {

        self::assertSame(
            $expected,
            Arr\Transform::filter($array, static function ($value, $key) {
                return $key !== 'one' && $value > 2;
            }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([[0 => 'foo', 2 => -1], [0 => 'foo', 1 => false, 2 => -1, 3 => null, 4 => '', 5 => '0', 6 => 0]])]
    public function testFilterWithoutCallback (array $expected, array $array):void {

        self::assertSame($expected, Arr\Transform::filter($array));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([[1 => 'one', 2 => 'two', 3 => 'three'], ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testFlip (array $expected, array $array):void {

        self::assertSame($expected, Arr\Transform::flip($array));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([['one' => '1-x', 'two' => '2-x', 'three' => '3-x'], ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testMap (array $expected, array $array):void {

        self::assertSame($expected, Arr\Transform::map($array, static fn($value) => $value.'-x'));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     *
     * @return void
     */
    #[TestWith([['0-x', '1-x', '2-x'], [0, 1, 2]])]
    public function testWalk (array $expected, array $actual):void {

        Arr\Transform::walk($actual, static fn(&$value, $key) => $value = $key.'-x');

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
    #[TestWith([[['a' => 'a-x', 'b' => 'b-x'], '1-x', '2-x'], [['a' => 'r','b' => 'g'], '1' => 'b', '2' => 'y']])]
    public function testWalkRecursive (array $expected, array $actual):void {

        Arr\Transform::walkRecursive($actual, static fn(&$value, $key) => $value = $key.'-x');

        self::assertSame($expected, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param bool $preserve_keys
     *
     * @return void
     */
    #[TestWith([[3, 2, 1], [1, 2, 3]])]
    #[TestWith([[2 => 3, 1 => 2, 0 => 1], [1, 2, 3], true])]
    public function testReverse (array $expected, array $array, bool $preserve_keys = false):void {

        self::assertSame($expected, Arr\Transform::reverse($array, $preserve_keys));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([[0 => 1, 3 => 2, 4 => 3], [1, 1, 1, 2, 3]])]
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3], ['one' => 1, 'one2' => 1, 'two' => 2, 'three' => 3]])]
    public function testUnique (array $expected, array $array):void {

        self::assertSame($expected, Arr\Transform::unique($array));

    }

}