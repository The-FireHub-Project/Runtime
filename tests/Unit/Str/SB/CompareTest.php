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

namespace FireHub\Tests\Runtime\Unit\Str\SB;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Str;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Single-Byte String Runtime Wrapper Utility - Compare
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\SB\Compare::class)]
final class CompareTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param int<-1, 1> $expected
     * @param string $string_1
     * @param string $string_2
     * @param bool $case_sensitive
     *
     * @return void
     */
    #[TestWith([-1, 'a', 'z'])]
    #[TestWith([1, 'hello', 'Hello'])]
    #[TestWith([0, 'Hello', 'Hello'])]
    #[TestWith([1, 'a', 'A'])]
    #[TestWith([0, 'a', 'A', false])]
    public function testLexical (int $expected, string $string_1, string $string_2, bool $case_sensitive = true):void {

        self::assertSame($expected, Str\SB\Compare::lexical($string_1, $string_2, $case_sensitive));

    }

    /**
     * @since 1.0.0
     *
     * @param int<-1, 1> $expected
     * @param string $string_1
     * @param string $string_2
     * @param int $length
     *
     * @return void
     */
    #[TestWith([1, 'Hello John', 'Hello Doe', 50])]
    #[TestWith([0, 'Hello John', 'Hello Doe', 5])]
    public function testFirstN (int $expected, string $string_1, string $string_2, int $length):void {

        self::assertSame($expected, Str\SB\Compare::firstN($string_1, $string_2, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param int<-1, 1> $expected
     * @param string $string_1
     * @param string $string_2
     * @param int $offset
     * @param null|int $length
     * @param bool $case_sensitive
     *
     * @return void
     */
    #[TestWith([0, 'abcde', 'BC', 1, 2, false])]
    #[TestWith([1, 'abcde', 'BC', 1, 3])]
    #[TestWith([-1, 'abcde', 'cd', 1, 2])]
    public function testPart (int $expected, string $string_1, string $string_2, int $offset, ?int $length = null, bool $case_sensitive = true):void {

        self::assertSame($expected, Str\SB\Compare::part($string_1, $string_2, $offset, $length, $case_sensitive));

    }

}