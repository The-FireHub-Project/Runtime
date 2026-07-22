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

namespace FireHub\Tests\Runtime\Unit;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Random;
use FireHub\Runtime\Exception\ {
    RandomByteLengthTooSmallException, RandomMaximumBelowMinimumException, RandomNumberAboveGeneratorMaximumException,
    RandomNumberBelowMinimumException, SecureRandomBytesException, SecureNumberException
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime Random Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Random::class)]
final class RandomTest extends FireHubTestCase  {

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $min
     * @param null|non-negative-int $max
     *
     * @throws \FireHub\Runtime\Exception\RandomNumberBelowMinimumException
     * @throws \FireHub\Runtime\Exception\RandomMaximumBelowMinimumException
     * @throws \FireHub\Runtime\Exception\RandomNumberAboveGeneratorMaximumException
     *
     * @return void
     */
    #[TestWith([0, 100])]
    public function testNumber (int $min = 0, ?int $max = null):void {

        $actual = Random::number($min, $max);

        self::assertIsInt($actual);
        self::assertGreaterThanOrEqual($min, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param int $min
     * @param null|int $max
     *
     * @throws \FireHub\Runtime\Exception\RandomMaximumBelowMinimumException
     * @throws \FireHub\Runtime\Exception\RandomNumberAboveGeneratorMaximumException
     *
     * @return void
     */
    #[TestWith([-1])]
    public function testNumberLessThenMin (int $min = 0, ?int $max = null):void {

        $this->expectException(RandomNumberBelowMinimumException::class);

        Random::number($min, $max);

    }

    /**
     * @since 1.0.0
     *
     * @param int $min
     * @param null|int $max
     *
     * @throws \FireHub\Runtime\Exception\RandomNumberBelowMinimumException
     * @throws \FireHub\Runtime\Exception\RandomNumberAboveGeneratorMaximumException
     *
     * @return void
     */
    #[TestWith([10, 5])]
    public function testNumberMaxLessThenMin (int $min = 0, ?int $max = null):void {

        $this->expectException(RandomMaximumBelowMinimumException::class);

        Random::number($min, $max);

    }

    /**
     * @since 1.0.0
     *
     * @param int $min
     * @param null|int $max
     *
     * @throws \FireHub\Runtime\Exception\RandomNumberBelowMinimumException
     * @throws \FireHub\Runtime\Exception\RandomMaximumBelowMinimumException
     *
     * @return void
     */
    #[TestWith([0, PHP_INT_MAX])]
    public function testNumberGreaterThenMax (int $min = 0, ?int $max = null):void {

        $this->expectException(RandomNumberAboveGeneratorMaximumException::class);

        Random::number($min, $max);

    }
    /**
     * @since 1.0.0
     *
     * @param int $min
     * @param int $max
     *
     * @throws \FireHub\Runtime\Exception\RandomMaximumBelowMinimumException
     * @throws \FireHub\Runtime\Exception\SecureNumberException
     *
     * @return void
     */
    #[TestWith([0, 100])]
    public function testSecureNumber (int $min, int $max):void {

        $actual = Random::secureNumber($min, $max);

        self::assertIsInt($actual);
        self::assertGreaterThanOrEqual($min, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param int $min
     * @param int $max
     *
     * @throws \FireHub\Runtime\Exception\SecureNumberException
     *
     * @return void
     */
    #[TestWith([10, 5])]
    public function testSecureNumberMaxLessThenMin (int $min, int $max):void {

        $this->expectException(RandomMaximumBelowMinimumException::class);

        Random::secureNumber($min, $max);

    }

    /**
     * @since 1.0.0
     *
     * @param int $length
     *
     * @throws \FireHub\Runtime\Exception\RandomByteLengthTooSmallException
     * @throws \FireHub\Runtime\Exception\SecureRandomBytesException
     *
     * @return void
     */
    #[TestWith([20])]
    public function testBytes (int $length):void {

        $actual = Random::bytes($length);

        self::assertIsString($actual);

    }

    /**
     * @since 1.0.0
     *
     * @param int $length
     *
     * @throws \FireHub\Runtime\Exception\SecureRandomBytesException
     *
     * @return void
     */
    #[TestWith([0])]
    public function testBytesLengthLessThenMin (int $length):void {

        $this->expectException(RandomByteLengthTooSmallException::class);

        Random::bytes($length);

    }

}