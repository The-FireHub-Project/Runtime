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
 * ### Test PHP Array Runtime Wrapper Utility - SetOperation
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Arr\SetOperation::class)]
final class SetOperationTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifference (array $expected, array $array, array ...$excludes):void {

        self::assertSame($expected, Arr\SetOperation::difference($array, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceUsing (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr\SetOperation::differenceUsing($array, $excludes,
                static function ($value_a, $value_b) {
                    if ($value_a === $value_b && $value_a !== 'two') return 0;
                    return ($value_a > $value_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['firstname' => 'Jane', 'lastname' => 'Doe', 'height' => '160cm']
    ])]
    public function testDifferenceKey (array $expected, array $array, array ...$excludes):void {

        self::assertSame($expected, Arr\SetOperation::differenceKey($array, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceUsingKey (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr\SetOperation::differenceUsingKey($array, $excludes,
                static function ($key_a, $key_b) {
                    if ($key_a === $key_b && $key_a !== 'lastname') return 0;
                    return ($key_a > $key_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceAssoc (array $expected, array $array, array ...$excludes):void {

        self::assertSame($expected, Arr\SetOperation::differenceAssoc($array, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['age' => 25]
    ])]
    public function testDifferenceAssocUsingValue (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr\SetOperation::differenceAssocUsingValue($array, $excludes,
                static function ($value_a, $value_b) {
                    if ($value_a === $value_b && $value_a !== 'Doe') return 0;
                    return ($value_a > $value_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceAssocUsingKey (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr\SetOperation::differenceAssocUsingKey($array, $excludes,
                static function ($key_a, $key_b) {
                    if ($key_a === $key_b && $key_a !== 'lastname') return 0;
                    return ($key_a > $key_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceAssocUsingKeyValue (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr\SetOperation::differenceAssocUsingKeyValue($array, $excludes,
                static function ($value_a, $value_b) {
                    if ($value_a === $value_b && $value_a !== 'Doe') return 0;
                    return ($value_a > $value_b) ? 1 : -1;
                }, static function ($key_a, $key_b) {
                    if ($key_a === $key_b && $key_a !== 'lastname') return 0;
                    return ($key_a > $key_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['lastname' => 'Doe', 'age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersect (array $expected, array $array, array ...$excludes):void {

        self::assertSame($expected, Arr\SetOperation::intersect($array, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['lastname' => 'Doe', 'age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectUsing (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr\SetOperation::intersectUsing($array, $excludes,
                static function ($value_a, $value_b) {
                    if ($value_a === $value_b && $value_a !== 'two') return 0;
                    return ($value_a > $value_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['firstname' => 'Jane', 'lastname' => 'Doe', 'height' => '160cm']
    ])]
    public function testIntersectUsingKey (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr\SetOperation::intersectUsingKey($array, $excludes,
                static function ($key_a, $key_b) {
                    if ($key_a === $key_b && $key_a !== 'lastname') return 0;
                    return ($key_a > $key_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['firstname' => 'Jane', 'lastname' => 'Doe', 'height' => '160cm']
    ])]
    public function testIntersectKey (array $expected, array $array, array ...$excludes):void {

        self::assertSame($expected, Arr\SetOperation::intersectKey($array, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['lastname' => 'Doe', 'age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectAssoc (array $expected, array $array, array ...$excludes):void {

        self::assertSame($expected, Arr\SetOperation::intersectAssoc($array, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectAssocUsingValue (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr\SetOperation::intersectAssocUsingValue($array, $excludes,
                static function ($value_a, $value_b) {
                    if ($value_a === $value_b && $value_a !== 'Doe') return 0;
                    return ($value_a > $value_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectAssocUsingKey (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr\SetOperation::intersectAssocUsingKey($array, $excludes,
                static function ($key_a, $key_b) {
                    if ($key_a === $key_b && $key_a !== 'lastname') return 0;
                    return ($key_a > $key_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectAssocUsingKeyValue (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr\SetOperation::intersectAssocUsingKeyValue($array, $excludes,
                static function ($value_a, $value_b) {
                    if ($value_a === $value_b && $value_a !== 'Doe') return 0;
                    return ($value_a > $value_b) ? 1 : -1;
                }, static function ($key_a, $key_b) {
                    if ($key_a === $key_b && $key_a !== 'lastname') return 0;
                    return ($key_a > $key_b) ? 1 : -1;
                }
            )
        );

    }

}