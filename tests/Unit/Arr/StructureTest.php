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
    InvalidArrayLengthException, InvalidChunkLengthException, InvalidRangeStepException
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Array Runtime Wrapper Utility - Structure
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Arr\Structure::class)]
final class StructureTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param positive-int $length
     * @param bool $preserve_keys
     *
     * @throws \FireHub\Runtime\Exception\InvalidChunkLengthException
     *
     * @return void
     */
    #[TestWith([[[1, 2], [3]], ['one' => 1, 'two' => 2, 'three' => 3], 2])]
    #[TestWith([[['one' => 1], ['two' => 2], ['three' => 3]], ['one' => 1, 'two' => 2, 'three' => 3], 1, true])]
    public function testChunk (array $expected, array $array, int $length, bool $preserve_keys = false):void {

        self::assertSame($expected, Arr\Structure::chunk($array, $length, $preserve_keys));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     * @param positive-int $length
     * @param bool $preserve_keys
     *
     * @return void
     */
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3], 0])]
    public function testChunkLengthLessThenZero (array $array, int $length, bool $preserve_keys = false):void {

        $this->expectException(InvalidChunkLengthException::class);

        Arr\Structure::chunk($array, $length, $preserve_keys);

    }

    /**
     * @since 1.0.0
     *
     * @param array<int, mixed> $expected
     * @param mixed $value
     * @param int $start_index
     * @param positive-int $length
     *
     * @throws \FireHub\Runtime\Exception\InvalidArrayLengthException
     *
     * @return void
     */
    #[TestWith([[1, 1, 1, 1, 1], 1, 0, 5])]
    #[TestWith([[-2 => 1, -1 => 1, 0 => 1], 1, -2, 3])]
    public function testFill (array $expected, mixed $value, int $start_index, int $length):void {

        self::assertSame($expected, Arr\Structure::fill($value, $start_index, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param int $start_index
     * @param positive-int $length
     *
     * @return void
     */
    #[TestWith([1, 0, -5])]
    public function testFillOutOfRangeWithNegativeNumber (mixed $value, int $start_index, int $length):void {

        $this->expectException(InvalidArrayLengthException::class);

        Arr\Structure::fill($value, $start_index, $length);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $keys
     * @param mixed $value
     *
     * @return void
     */
    #[TestWith([[1 => 1, 2 => 1, 3 => 1, '' => 1], [1, 2, 3, null], 1])]
    public function testFillKeys (array $expected, array $keys, mixed $value):void {

        self::assertSame($expected, Arr\Structure::fillKeys($keys, $value));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param int $length
     * @param mixed $value
     *
     * @return void
     */
    #[TestWith([[1, 2, 3, 'x', 'x'], [1, 2, 3], 5, 'x'])]
    #[TestWith([['x', 'x', 1, 2, 3], [1, 2, 3], -5, 'x'])]
    #[TestWith([[1, 2, 3], [1, 2, 3], 2, 'x'])]
    public function testPad (array $expected, array $array, int $length, mixed $value):void {

        self::assertSame($expected, Arr\Structure::pad($array, $length, $value));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param int $offset
     * @param null|int $length
     * @param bool $preserve_keys
     *
     * @return void
     */
    #[TestWith([[2, 3], [1, 2, 3], 1])]
    #[TestWith([[1 => 2, 2 => 3], [1, 2, 3], 1, null, true])]
    #[TestWith([[0 => 3], [1, 2, 3], -1])]
    public function testSlice (array $expected, array $array, int $offset, ?int $length = null, bool $preserve_keys =
    false):void {

        self::assertSame($expected, Arr\Structure::slice($array, $offset, $length, $preserve_keys));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param int $offset
     * @param null|int $length
     * @param array<array-key, mixed> $replacement
     *
     * @return void
     */
    #[TestWith([[3], [1, 2, 3], 0, 2, []])]
    #[TestWith([[5, 3], [1, 2, 3], 0, 2, [5]])]
    #[TestWith([[1, 3], [1, 2, 3], -2, 1, []])]
    #[TestWith([[1, 3], [1, 2, 3], -2, 1, []])]
    public function testSplice (array $expected, array $array, int $offset, ?int $length = null, mixed $replacement = []):void {

        Arr\Structure::splice($array, $offset, $length, $replacement);

        self::assertSame($expected, $array);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param int|float|string $start
     * @param int|float|string $end
     * @param positive-int|float $step
     *
     * @throws \FireHub\Runtime\Exception\InvalidRangeStepException
     *
     * @return void
     */
    #[TestWith([[1, 3, 5, 7, 9], 1, 10, 2])]
    public function testRange (array $expected, int|float|string $start, int|float|string $end, int|float $step = 1):void {

        self::assertSame($expected, Arr\Structure::range($start, $end, $step));

    }

    /**
     * @since 1.0.0
     *
     * @param int|float|string $start
     * @param int|float|string $end
     * @param positive-int|float $step
     *
     * @return void
     */
    #[TestWith([1, 10, 0])]
    #[TestWith([1, 10, -2])]
    public function testInvalidRange (int|float|string $start, int|float|string $end, int|float $step):void {

        $this->expectException(InvalidRangeStepException::class);

        Arr\Structure::range($start, $end, $step);

    }

}