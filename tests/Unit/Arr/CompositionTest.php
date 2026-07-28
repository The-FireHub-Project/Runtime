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
use FireHub\Runtime\Exception\ArrayKeysAndValuesCountMismatchException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Array Runtime Wrapper Utility - Composition
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Arr\Composition::class)]
final class CompositionTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $keys
     * @param array<array-key, mixed> $values
     *
     * @throws \FireHub\Runtime\Exception\ArrayKeysAndValuesCountMismatchException
     *
     * @return void
     */
    #[TestWith([[1 => 1, 2 => 2, 3 => 3], [1, 2, 3], ['one' => 1, 'two' => 2, 'three' => 3]])]
    #[TestWith([['' => 3], [2 => '', 'x' => null, 5 => false], ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testCombine (array $expected, array $keys, array $values):void {

        self::assertSame($expected, Arr\Composition::combine($keys, $values));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $keys
     * @param array<array-key, mixed> $values
     *
     * @return void
     */
    #[TestWith([[], ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testCombineDiffElementNumber (array $keys, array $values):void {

        $this->expectException(ArrayKeysAndValuesCountMismatchException::class);

        Arr\Composition::combine($keys, $values);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> ...$array
     *
     * @return void
     */
    #[TestWith([
        [1, 2, 3, 'one' => 1, 'two' => 2, 'three' => 3],
        [1, 2, 3],
        ['one' => 1, 'two' => 2, 'three' => 3]
    ])]
    public function testMerge (array $expected, array ...$array):void {

        self::assertSame($expected, Arr\Composition::merge(...$array));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> ...$arrays
     *
     * @return void
     */
    #[TestWith([
        ['one' => [1, 1], 'two' => [2, 2], 'three' => [3, 3]],
        ['one' => 1, 'two' => 2, 'three' => 3],
        ['one' => 1, 'two' => 2, 'three' => 3]
    ])]
    public function testMergeRecursive (array $expected, array ...$arrays):void {

        self::assertSame($expected, Arr\Composition::mergeRecursive(...$arrays));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$replacements
     *
     * @return void
     */
    #[TestWith([
        ['one' => 6, 'two' => 7, 'three' => 3],
        ['one' => 1, 'two' => 2, 'three' => 3],
        ['one' => 6, 'two' => 7]
    ])]
    public function testReplace (array $expected, array $array, array ...$replacements):void {

        self::assertSame($expected, Arr\Composition::replace($array, ...$replacements));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$replacements
     *
     * @return void
     */
    #[TestWith([
        ['one' => [4, 2, 3], 'two' => [4, 5, 6], 'three' => [7, 8, 9]],
        ['one' => [1, 2, 3], 'two' => [4, 5, 6], 'three' => [7, 8, 9]],
        ['one' => [4]]
    ])]
    public function testReplaceRecursive (array $expected, array $array, array ...$replacements):void {

        self::assertSame($expected, Arr\Composition::replaceRecursive($array, ...$replacements));

    }

}