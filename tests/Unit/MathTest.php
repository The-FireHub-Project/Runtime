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

namespace FireHub\Tests\Runtime\Unit;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Math;
use FireHub\Runtime\Math\ {
    LogBase, RoundMode
};
use FireHub\Tests\Runtime\DataProviders\NumDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Depends, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime Math Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Math::class)]
final class MathTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param bool $excepted
     * @param float $number
     *
     * @return void
     */
    #[TestWith([true, 10])]
    #[TestWith([false, NAN])]
    #[TestWith([false, INF])]
    public function testIsFinite (bool $excepted, float $number):void {

        self::assertSame($excepted, Math::isFinite($number));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $excepted
     * @param float $number
     *
     * @return void
     */
    #[TestWith([true, INF])]
    #[TestWith([false, 10.5])]
    public function testIsInfinite (bool $excepted, float $number):void {

        self::assertSame($excepted, Math::isInfinite($number));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $excepted
     * @param float $number
     *
     * @return void
     */
    #[TestWith([true, NAN])]
    #[TestWith([false, 10.5])]
    #[TestWith([false, INF])]
    public function testIsNan (bool $excepted, float $number):void {

        self::assertSame($excepted, Math::isNan($number));

    }

    /**
     * @since 1.0.0
     *
     * @param int $expected
     * @param int $dividend
     * @param non-zero-int $divisor
     *
     * @return void
     */
    #[TestWith([1, 3, 2])]
    #[TestWith([-1, -3, 2])]
    #[TestWith([-1, 3, -2])]
    #[TestWith([1, -3, -2])]
    #[TestWith([0, PHP_INT_MAX, PHP_INT_MIN])]
    #[TestWith([-1, PHP_INT_MIN, PHP_INT_MAX])]
    public function testDivideInt (int $expected, int $dividend, int $divisor):void {

        self::assertSame($expected, Math::divideInt($dividend, $divisor));

    }

    /**
     * @since 1.0.0
     *
     * @param float $result
     * @param float $dividend
     * @param float $divisor
     *
     * @return void
     */
    #[TestWith([2.0, 4, 2])]
    #[TestWith([INF, 1.0, 0.0])]
    #[TestWith([-INF, -1.0, 0.0])]
    #[TestWith([4.384615384615385, 5.7, 1.3])]
    #[Depends('testRound')]
    public function testDivideFloats (float $result, float $dividend, float $divisor):void {

        self::assertSame(Math::round($result, 5), Math::round(Math::divideFloat($dividend, $divisor), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $dividend
     * @param float $divisor
     *
     * @return void
     */
    #[TestWith([0.5, 5.7, 1.3])]
    public function testRemainder (float $expected, float $dividend, float $divisor):void {

        self::assertSame($expected, Math::remainder($dividend, $divisor));

    }

    /**
     * @since 1.0.0
     *
     * @param float|int $float
     *
     * @return void
     */
    #[DataProviderExternal(NumDataProvider::class, 'positiveInt')]
    #[DataProviderExternal(NumDataProvider::class, 'negativeInt')]
    #[DataProviderExternal(NumDataProvider::class, 'positiveFloat')]
    #[DataProviderExternal(NumDataProvider::class, 'negativeFloat')]
    #[DataProviderExternal(NumDataProvider::class, 'null')]
    public function testAbs (float|int $float):void {

        self::assertTrue(Math::abs($float) >= 0);

    }

    /**
     * @since 1.0.0
     *
     * @param int $expected
     * @param float|int $number
     *
     * @return void
     */
    #[TestWith([5, 4.3])]
    #[TestWith([10, 9.999])]
    #[TestWith([-3, -3.14])]
    public function testCeil (int $expected, float|int $number):void {

        self::assertSame($expected, Math::ceil($number));

    }

    /**
     * @since 1.0.0
     *
     * @param int $expected
     * @param float|int $number
     *
     * @return void
     */
    #[TestWith([4, 4.3])]
    #[TestWith([9, 9.999])]
    #[TestWith([-4, -3.14])]
    public function testFloor (int $expected, float|int $number):void {

        self::assertSame($expected, Math::floor($number));

    }

    /**
     * @since 1.0.0
     *
     * @param int|float $expected
     * @param int|float $number
     * @param int $precision
     * @param \FireHub\Runtime\Math\RoundMode $mode
     *
     * @return void
     */
    #[TestWith([2, 1.5, 0, RoundMode::HALF_AWAY_FROM_ZERO])]
    #[TestWith([1, 0.5, 0, RoundMode::HALF_AWAY_FROM_ZERO])]
    #[TestWith([0, 0.49, 0, RoundMode::HALF_AWAY_FROM_ZERO])]
    #[TestWith([-0.4, -0.35, 1, RoundMode::HALF_AWAY_FROM_ZERO])]
    #[TestWith([0.46, 0.455, 2, RoundMode::HALF_AWAY_FROM_ZERO])]
    #[TestWith([1, 1.5, 0, RoundMode::HALF_TOWARDS_ZERO])]
    #[TestWith([0, 0.5, 0, RoundMode::HALF_TOWARDS_ZERO])]
    #[TestWith([0, 0.49, 0, RoundMode::HALF_TOWARDS_ZERO])]
    #[TestWith([-0.3, -0.35, 1, RoundMode::HALF_TOWARDS_ZERO])]
    #[TestWith([0.45, 0.455, 2, RoundMode::HALF_TOWARDS_ZERO])]
    #[TestWith([1, 1.5, 0, RoundMode::HALF_ODD])]
    #[TestWith([1, 0.5, 0, RoundMode::HALF_ODD])]
    #[TestWith([0, 0.49, 0, RoundMode::HALF_ODD])]
    #[TestWith([-0.3, -0.35, 1, RoundMode::HALF_ODD])]
    #[TestWith([0.45, 0.455, 2, RoundMode::HALF_ODD])]
    #[TestWith([2, 1.5, 0, RoundMode::HALF_EVEN])]
    #[TestWith([0, 0.5, 0, RoundMode::HALF_EVEN])]
    #[TestWith([0, 0.49, 0, RoundMode::HALF_EVEN])]
    #[TestWith([-0.4, -0.35, 1, RoundMode::HALF_EVEN])]
    #[TestWith([0.46, 0.455, 2, RoundMode::HALF_EVEN])]
    #[TestWith([1, 1.5, 0, RoundMode::TOWARDS_ZERO])]
    #[TestWith([0, 0.5, 0, RoundMode::TOWARDS_ZERO])]
    #[TestWith([0, 0.49, 0, RoundMode::TOWARDS_ZERO])]
    #[TestWith([-0.3, -0.35, 1, RoundMode::TOWARDS_ZERO])]
    #[TestWith([0.45, 0.455, 2, RoundMode::TOWARDS_ZERO])]
    #[TestWith([2, 1.5, 0, RoundMode::AWAY_FROM_ZERO])]
    #[TestWith([1, 0.5, 0, RoundMode::AWAY_FROM_ZERO])]
    #[TestWith([1, 0.49, 0, RoundMode::AWAY_FROM_ZERO])]
    #[TestWith([-0.4, -0.35, 1, RoundMode::AWAY_FROM_ZERO])]
    #[TestWith([0.46, 0.455, 2, RoundMode::AWAY_FROM_ZERO])]
    #[TestWith([1, 1.5, 0, RoundMode::NEGATIVE_INFINITY])]
    #[TestWith([0, 0.5, 0, RoundMode::NEGATIVE_INFINITY])]
    #[TestWith([0, 0.49, 0, RoundMode::NEGATIVE_INFINITY])]
    #[TestWith([-0.4, -0.35, 1, RoundMode::NEGATIVE_INFINITY])]
    #[TestWith([0.45, 0.455, 2, RoundMode::NEGATIVE_INFINITY])]
    public function testRound (int|float $expected, float|int $number, int $precision = 0, RoundMode $mode = RoundMode::HALF_AWAY_FROM_ZERO):void {

        self::assertSame($expected, Math::round($number, $precision, $mode));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float|int $number
     * @param float|\FireHub\Runtime\Math\LogBase $base
     *
     * @return void
     */
    #[TestWith([2.302585092994046, 10, LogBase::E])]
    #[TestWith([6.282411788757109, 10, LogBase::LOG2E])]
    #[TestWith([-2.7607859935346917, 10, LogBase::LOG10E])]
    #[TestWith([-6.282411788757108, 10, LogBase::LN2])]
    #[TestWith([2.7607859935346912, 10, LogBase::LN10])]
    #[TestWith([0.28893129185221283, 1.335, LogBase::E])]
    #[TestWith([0.788324982905575, 1.335, LogBase::LOG2E])]
    #[TestWith([-0.34642692079720505, 1.335, LogBase::LOG10E])]
    #[TestWith([-0.7883249829055747, 1.335, LogBase::LN2])]
    #[TestWith([0.346426920797205, 1.335, LogBase::LN10])]
    #[Depends('testRound')]
    public function testLog (float $expected, float|int $number, float|LogBase $base = LogBase::E):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::log($number, $base), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float|int $number
     *
     * @return void
     */
    #[TestWith([2.3978952727983707, 10])]
    #[TestWith([0.8480118911208606, 1.335])]
    #[Depends('testRound')]
    public function testLog1p (float $expected, float|int $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::log1p($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float|int $number
     *
     * @return void
     */
    #[TestWith([1.0, 10])]
    #[TestWith([0.125481265700594, 1.335])]
    #[Depends('testRound')]
    public function testLog10 (float $expected, float|int $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::log10($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $expected
     * @param array<array-key, mixed> $values
     *
     * @return void
     */
    #[TestWith([8, [2, 6, 8]])]
    #[TestWith([4.23544, [2.345, 4.23544, 4.1214]])]
    public function testMax (mixed $expected, array $values):void {

        self::assertSame($expected, Math::max(...$values));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $expected
     * @param array<array-key, mixed> $values
     *
     * @return void
     */
    #[TestWith([2, [2, 6, 8]])]
    #[TestWith([2.345, [2.345, 4.23544, 4.1214]])]
    public function testMin (mixed $expected, array $values):void {

        self::assertSame($expected, Math::min(...$values));

    }

    /**
     * @since 1.0.0
     *
     * @param float|int $expected
     * @param float|int $base
     * @param float|int $exponent
     *
     * @return void
     */
    #[TestWith([256, 2, 8])]
    #[TestWith([0.1, 10, -1])]
    public function testPow (float|int $expected, float|int $base, float|int $exponent):void {

        self::assertSame($expected, Math::pow($base, $exponent));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param int|float $number
     *
     * @return void
     */
    #[TestWith([0.4031710572106902, 23.1])]
    #[TestWith([0.7853981633974483, 45])]
    #[Depends('testRound')]
    public function testDeg2rad (float $expected, int|float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::deg2rad($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param int|float $number
     *
     * @return void
     */
    #[TestWith([23.099939426289396, 0.40317])]
    #[TestWith([45.0, 0.7853981633974483])]
    #[Depends('testRound')]
    public function testRad2deg (float $expected, int|float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::rad2deg($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param int|float $number
     *
     * @return void
     */
    #[TestWith([298.8674009670603, 5.7])]
    #[TestWith([9744803446.2489, 23])]
    #[Depends('testRound')]
    public function testExp (float $expected, int|float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::exp($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param int|float $number
     *
     * @return void
     */
    #[TestWith([4839126178.743089, 22.3])]
    #[TestWith([9744803445.248903, 23])]
    #[Depends('testRound')]
    public function testExpm1 (float $expected, int|float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::expm1($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param int|float $x
     * @param int|float $y
     *
     * @return void
     */
    #[TestWith([2.6832815729997477, 1.2, 2.4])]
    #[TestWith([2.23606797749979, 1, 2])]
    #[Depends('testRound')]
    public function testHypot (float $expected, int|float $x, int|float $y):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::hypot($x, $y), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param int|float $number
     *
     * @return void
     */
    #[TestWith([3.03315017762062, 9.2])]
    #[TestWith([3.0, 9])]
    #[Depends('testRound')]
    public function testSqrt (float $expected, int|float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::sqrt($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([-1.0, M_PI])]
    public function testCos (float $expected, float $number):void {

        self::assertSame($expected, Math::cos($number));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([1.0471975511965979, 0.5])]
    #[Depends('testRound')]
    public function testAcos (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::acos($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([1.1276259652063807, 0.5])]
    #[Depends('testRound')]
    public function testCosh (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::cosh($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([0.4435682543851153, 1.1])]
    #[Depends('testRound')]
    public function testAcosh (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::acosh($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([0.479425538604203, 0.5])]
    #[Depends('testRound')]
    public function testSin (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::sin($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([1.5707963267948966, 1])]
    #[Depends('testRound')]
    public function testAsin (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::asin($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([1.1752011936438014, 1])]
    #[Depends('testRound')]
    public function testSinh (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::sinh($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([0.881373587019543, 1])]
    #[Depends('testRound')]
    public function testAsinh (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::asinh($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([1.5574077246549023, 1])]
    #[Depends('testRound')]
    public function testTan (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::tan($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([0.7853981633974483, 1])]
    #[Depends('testRound')]
    public function testAtan (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::atan($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $x
     * @param float $y
     *
     * @return void
     */
    #[TestWith([0.7853981633974483, 1, 1])]
    public function testAtan2 (float $expected, float $x, float $y):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::atan2($x, $y), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([0.7615941559557649, 1])]
    #[Depends('testRound')]
    public function testTanh (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::tanh($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([0.5493061443340549, 0.5])]
    #[Depends('testRound')]
    public function testAtanh (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::atanh($number), 5));

    }

}