<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=74
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\Unit\Math;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Math\DecimalEngine;
use FireHub\Runtime\Math\RoundMode;
use FireHub\Runtime\Exception\ {
    InvalidDecimalNumberException, InvalidScaleNumberException
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};
use DivisionByZeroError;

/**
 * ### Test Arbitrary-precision decimal arithmetic
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(DecimalEngine::class)]
final class DecimalEngineTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param non-empty-string $left
     * @param non-empty-string $right
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException
     *
     * @return void
     */
    #[TestWith(['5', '2', '3'])]
    #[TestWith(['123', '0', '123'])]
    #[TestWith(['18', '12.34', '5.66'])]
    #[TestWith(['17.978', '12.3', '5.678'])]
    #[TestWith(['1.1', '0.9', '0.2'])]
    #[TestWith(['1000', '999', '1'])]
    #[TestWith(['1000000000000000000', '999999999999999999', '1'])]
    #[TestWith(['7', '10', '-3'])]
    #[TestWith(['-7', '-10', '3'])]
    #[TestWith(['-13', '-10', '-3'])]
    #[TestWith(['0', '123.456', '-123.456'])]
    #[TestWith(['0', '-0', '0'])]
    #[TestWith(['20', '000012.30', '0007.70'])]
    #[TestWith(['4', '1.2300', '2.7700'])]
    #[TestWith(['0.000000000000003', '0.000000000000001', '0.000000000000002'])]
    public function testAdd (string $expected, string $left, string $right):void {

        self::assertSame($expected, DecimalEngine::add($left, $right));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $left
     *
     * @return void
     */
    #[TestWith(['12abc'])]
    #[TestWith(['12.34.56'])]
    #[TestWith(['.5'])]
    #[TestWith(['12.'])]
    #[TestWith(['1e10'])]
    #[TestWith([' 12'])]
    #[TestWith([''])]
    #[TestWith(['+-12'])]
    public function testInvalidDecimal (string $left):void {

        $this->expectException(InvalidDecimalNumberException::class);

        DecimalEngine::add($left, '1');

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param non-empty-string $left
     * @param non-empty-string $right
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException
     *
     * @return void
     */
    #[TestWith(['2', '5', '3'])]
    #[TestWith(['123', '123', '0'])]
    #[TestWith(['7', '12.34', '5.34'])]
    #[TestWith(['10.045', '12.345', '2.3'])]
    #[TestWith(['0.9', '1', '0.1'])]
    #[TestWith(['999', '1000', '1'])]
    #[TestWith(['999999999999999999', '1000000000000000000', '1'])]
    #[TestWith(['-7', '3', '10'])]
    #[TestWith(['-13', '-10', '3'])]
    #[TestWith(['13', '10', '-3'])]
    #[TestWith(['-7', '-10', '-3'])]
    #[TestWith(['0', '123.456', '123.456'])]
    #[TestWith(['100', '000100.50', '000000.50'])]
    #[TestWith(['10', '10.5000', '0.5000'])]
    #[TestWith(['0.000000000000002', '0.000000000000003', '0.000000000000001'])]
    public function testSubtract (string $expected, string $left, string $right):void {

        self::assertSame($expected, DecimalEngine::subtract($left, $right));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param non-empty-string $left
     * @param non-empty-string $right
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException
     *
     * @return void
     */
    #[TestWith(['6', '2', '3'])]
    #[TestWith(['0', '0', '123456789'])]
    #[TestWith(['24.68', '12.34', '2'])]
    #[TestWith(['30.85', '12.34', '2.50'])]
    #[TestWith(['0.02', '0.1', '0.2'])]
    #[TestWith(['9801', '99', '99'])]
    #[TestWith(['99.8001', '9.99', '9.99'])]
    #[TestWith(['999999999999999998000000000000000001', '999999999999999999', '999999999999999999'])]
    #[TestWith(['-25', '12.5', '-2'])]
    #[TestWith(['-25', '-12.5', '2'])]
    #[TestWith(['25', '-12.5', '-2'])]
    #[TestWith(['25', '000012.50', '0002'])]
    #[TestWith(['3', '1.2000', '2.5000'])]
    #[TestWith(['0.000000000002', '0.000001', '0.000002'])]
    public function testMultiply (string $expected, string $left, string $right):void {

        self::assertSame($expected, DecimalEngine::multiply($left, $right));

    }

    /**
     * @param string $expected
     * @param non-empty-string $left
     * @param non-empty-string $right
     * @param positive-int $scale
     *
     * @return void
     *@throws \FireHub\Runtime\Exception\InvalidScaleNumberException
     * @throws \DivisionByZeroError
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException
     * @since 1.0.0
     *
     */
    #[TestWith(['5', '10', '2', 18])]
    #[TestWith(['2.5', '10', '4', 18])]
    #[TestWith(['6.17', '12.34', '2', 18])]
    #[TestWith(['0.3333333333', '1', '3', 10])]
    #[TestWith(['0.6666666666', '2', '3', 10])]
    #[TestWith(['0.142857142857', '1', '7', 12])]
    #[TestWith(['0.25', '0.5', '2', 18])]
    #[TestWith(['20', '10', '0.5', 18])]
    #[TestWith(['2.5', '1.25', '0.5', 18])]
    #[TestWith(['-2.5', '-10', '4', 18])]
    #[TestWith(['-2.5', '10', '-4', 18])]
    #[TestWith(['2.5', '-10', '-4', 18])]
    #[TestWith(['0', '0', '123', 18])]
    #[TestWith(['25', '00100', '0004', 18])]
    #[TestWith(['500000000000000000', '1000000000000000000', '2', 18])]
    #[TestWith(['3.33', '10', '3', 2])]
    #[TestWith(['3', '10', '3', 0])]
    #[TestWith(['0.0000000000000005', '0.000000000000001', '2', 18])]
    public function testDivide (string $expected, string $left, string $right, int $scale):void {

        self::assertSame($expected, DecimalEngine::divide($left, $right, $scale));

    }

    /**
     * @return void
     *@throws \FireHub\Runtime\Exception\InvalidScaleNumberException
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException
     * @since 1.0.0
     *
     */
    public function testDivideByZero ():void {

        $this->expectException(DivisionByZeroError::class);

        DecimalEngine::divide('10', '0');

    }

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException
     * @throws \DivisionByZeroError
     *
     * @return void
     */
    public function testNegativeScale ():void {

        $this->expectException(InvalidScaleNumberException::class);

        DecimalEngine::divide('10', '3', -1);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $expected
     * @param non-empty-string $value
     * @param non-negative-int $precision
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException
     *
     * @return void
     */
    #[TestWith(['1', '1.4', 0])]
    #[TestWith(['2', '1.5', 0])]
    #[TestWith(['2', '1.6', 0])]
    #[TestWith(['-1', '-1.4', 0])]
    #[TestWith(['-2', '-1.5', 0])]
    #[TestWith(['-2', '-1.6', 0])]
    #[TestWith(['12.35', '12.345', 2])]
    #[TestWith(['12.36', '12.355', 2])]
    #[TestWith(['-12.35', '-12.345', 2])]
    #[TestWith(['-12.36', '-12.355', 2])]
    #[TestWith(['100', '99.5', 0])]
    #[TestWith(['1000', '999.5', 0])]
    public function testHalfAwayFromZero (string $expected, string $value, int $precision):void {

        self::assertSame(
            $expected,
            DecimalEngine::round(
                $value,
                $precision,
                RoundMode::HALF_AWAY_FROM_ZERO
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $expected
     * @param non-empty-string $value
     * @param non-negative-int $precision
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException
     *
     * @return void
     */
    #[TestWith(['1', '1.4', 0])]
    #[TestWith(['1', '1.5', 0])]
    #[TestWith(['2', '1.6', 0])]
    #[TestWith(['-1', '-1.4', 0])]
    #[TestWith(['-1', '-1.5', 0])]
    #[TestWith(['-2', '-1.6', 0])]
    #[TestWith(['12.34', '12.345', 2])]
    #[TestWith(['12.36', '12.356', 2])]
    #[TestWith(['-12.34', '-12.345', 2])]
    #[TestWith(['-12.36', '-12.356', 2])]
    public function testHalfTowardsZero (string $expected, string $value, int $precision):void {

        self::assertSame(
            $expected,
            DecimalEngine::round(
                $value,
                $precision,
                RoundMode::HALF_TOWARDS_ZERO
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $expected
     * @param non-empty-string $value
     * @param non-negative-int $precision
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException
     *
     * @return void
     */
    #[TestWith(['2', '1.5', 0])]
    #[TestWith(['2', '2.5', 0])]
    #[TestWith(['4', '3.5', 0])]
    #[TestWith(['4', '4.5', 0])]
    #[TestWith(['-2', '-1.5', 0])]
    #[TestWith(['-2', '-2.5', 0])]
    #[TestWith(['-4', '-3.5', 0])]
    #[TestWith(['-4', '-4.5', 0])]
    #[TestWith(['12.34', '12.345', 2])]
    #[TestWith(['12.36', '12.355', 2])]
    #[TestWith(['12.36', '12.365', 2])]
    #[TestWith(['12.38', '12.375', 2])]
    #[TestWith(['-12.34', '-12.345', 2])]
    #[TestWith(['-12.36', '-12.355', 2])]
    public function testHalfEven (string $expected, string $value, int $precision):void {

        self::assertSame(
            $expected,
            DecimalEngine::round(
                $value,
                $precision,
                RoundMode::HALF_EVEN
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $expected
     * @param non-empty-string $value
     * @param non-negative-int $precision
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException
     *
     * @return void
     */
    #[TestWith(['1', '1.5', 0])]
    #[TestWith(['3', '2.5', 0])]
    #[TestWith(['3', '3.5', 0])]
    #[TestWith(['5', '4.5', 0])]
    #[TestWith(['-1', '-1.5', 0])]
    #[TestWith(['-3', '-2.5', 0])]
    #[TestWith(['-3', '-3.5', 0])]
    #[TestWith(['-5', '-4.5', 0])]
    #[TestWith(['12.35', '12.345', 2])]
    #[TestWith(['12.35', '12.355', 2])]
    #[TestWith(['12.37', '12.365', 2])]
    #[TestWith(['12.37', '12.375', 2])]
    #[TestWith(['-12.35', '-12.345', 2])]
    #[TestWith(['-12.35', '-12.355', 2])]
    public function testHalfOdd (string $expected, string $value, int $precision):void {

        self::assertSame(
            $expected,
            DecimalEngine::round(
                $value,
                $precision,
                RoundMode::HALF_ODD
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $expected
     * @param non-empty-string $value
     * @param non-negative-int $precision
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException
     *
     * @return void
     */
    #[TestWith(['1', '1.1', 0])]
    #[TestWith(['1', '1.5', 0])]
    #[TestWith(['1', '1.9', 0])]
    #[TestWith(['-1', '-1.1', 0])]
    #[TestWith(['-1', '-1.5', 0])]
    #[TestWith(['-1', '-1.9', 0])]
    #[TestWith(['12.34', '12.349', 2])]
    #[TestWith(['12.34', '12.345', 2])]
    #[TestWith(['12.34', '12.341', 2])]
    #[TestWith(['-12.34', '-12.349', 2])]
    #[TestWith(['-12.34', '-12.345', 2])]
    #[TestWith(['-12.34', '-12.341', 2])]
    #[TestWith(['1', '1.501', 0])]
    #[TestWith(['-1', '-1.501', 0])]
    public function testTowardsZero (string $expected, string $value, int $precision):void {

        self::assertSame(
            $expected,
            DecimalEngine::round(
                $value,
                $precision,
                RoundMode::TOWARDS_ZERO
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $expected
     * @param non-empty-string $value
     * @param non-negative-int $precision
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException
     *
     * @return void
     */
    #[TestWith(['2', '1.1', 0])]
    #[TestWith(['2', '1.5', 0])]
    #[TestWith(['2', '1.9', 0])]
    #[TestWith(['-2', '-1.1', 0])]
    #[TestWith(['-2', '-1.5', 0])]
    #[TestWith(['-2', '-1.9', 0])]
    #[TestWith(['12.35', '12.341', 2])]
    #[TestWith(['12.35', '12.345', 2])]
    #[TestWith(['12.35', '12.349', 2])]
    #[TestWith(['-12.35', '-12.341', 2])]
    #[TestWith(['-12.35', '-12.345', 2])]
    #[TestWith(['-12.35', '-12.349', 2])]
    #[TestWith(['2', '1.501', 0])]
    #[TestWith(['2', '1.5001', 0])]
    #[TestWith(['1.51', '1.505', 2])]
    #[TestWith(['-2', '-1.501', 0])]
    #[TestWith(['-2', '-1.5001', 0])]
    #[TestWith(['-1.51', '-1.505', 2])]
    public function testAwayFromZero (string $expected, string $value, int $precision):void {

        self::assertSame(
            $expected,
            DecimalEngine::round(
                $value,
                $precision,
                RoundMode::AWAY_FROM_ZERO
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $expected
     * @param non-empty-string $value
     * @param non-negative-int $precision
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException
     *
     * @return void
     */
    #[TestWith(['1', '1.1', 0])]
    #[TestWith(['1', '1.5', 0])]
    #[TestWith(['1', '1.9', 0])]
    #[TestWith(['-2', '-1.1', 0])]
    #[TestWith(['-2', '-1.5', 0])]
    #[TestWith(['-2', '-1.9', 0])]
    #[TestWith(['12.34', '12.349', 2])]
    #[TestWith(['12.34', '12.345', 2])]
    #[TestWith(['12.34', '12.341', 2])]
    #[TestWith(['-12.35', '-12.349', 2])]
    #[TestWith(['-12.35', '-12.345', 2])]
    #[TestWith(['-12.35', '-12.341', 2])]
    #[TestWith(['1', '1.501', 0])]
    #[TestWith(['-2', '-1.501', 0])]
    public function testNegativeInfinity (string $expected, string $value, int $precision):void {

        self::assertSame(
            $expected,
            DecimalEngine::round(
                $value,
                $precision,
                RoundMode::NEGATIVE_INFINITY
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $expected
     * @param non-empty-string $value
     * @param non-negative-int $precision
     *
     * @throws \FireHub\Runtime\Exception\InvalidDecimalNumberException
     *
     * @return void
     */
    #[TestWith(['2', '1.1', 0])]
    #[TestWith(['2', '1.5', 0])]
    #[TestWith(['2', '1.9', 0])]
    #[TestWith(['-1', '-1.1', 0])]
    #[TestWith(['-1', '-1.5', 0])]
    #[TestWith(['-1', '-1.9', 0])]
    #[TestWith(['12.35', '12.349', 2])]
    #[TestWith(['12.35', '12.345', 2])]
    #[TestWith(['12.35', '12.341', 2])]
    #[TestWith(['-12.34', '-12.349', 2])]
    #[TestWith(['-12.34', '-12.345', 2])]
    #[TestWith(['-12.34', '-12.341', 2])]
    #[TestWith(['2', '1.501', 0])]
    #[TestWith(['-1', '-1.501', 0])]
    public function testPositiveInfinity (string $expected, string $value, int $precision):void {

        self::assertSame(
            $expected,
            DecimalEngine::round(
                $value,
                $precision,
                RoundMode::POSITIVE_INFINITY
            )
        );

    }

}