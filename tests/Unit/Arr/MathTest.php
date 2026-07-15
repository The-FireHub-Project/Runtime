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
 * ### Test PHP Array Runtime Wrapper Utility - Math
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Arr\Math::class)]
final class MathTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param int|float $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([6, ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testProduct (int|float $expected, array $array):void {

        self::assertSame($expected, Arr\Math::product($array));

    }

    /**
     * @since 1.0.0
     *
     * @param int|float $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([6, ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testSum (int|float $expected, array $array):void {

        self::assertSame($expected, Arr\Math::sum($array));

    }

}