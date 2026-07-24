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
use FireHub\Runtime\Number;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Number Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Number::class)]
final class NumberTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param int|float $number
     * @param non-negative-int $decimals
     * @param string $decimal_separator
     * @param string $thousands_separator
     *
     * @return void
     */
    #[TestWith(['5,000', 5000, 0, '.', ','])]
    #[TestWith(['456', 456, 0, ',', '.'])]
    #[TestWith(['45656,560', 45656.56, 3, ',', ''])]
    public function testFormat (string $expected, int|float $number, int $decimals, string $decimal_separator = '.', string $thousands_separator = ','):void {

        self::assertSame($expected, Number::format($number, $decimals, $decimal_separator, $thousands_separator));

    }

}