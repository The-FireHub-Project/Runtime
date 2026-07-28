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
 * ### Test PHP Single-Byte String Runtime Wrapper Utility - Replace
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\SB\Replace::class)]
final class ReplaceTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string|list<string> $search
     * @param string|list<string> $replace
     * @param string $string
     * @param bool $case_sensitive
     * @param int $count_replaced
     *
     * @return void
     */
    #[TestWith([
        'The lazy mouse jumped over the fence',
        'fox',
        'mouse',
        'The lazy fox jumped over the fence',
        true,
        1
    ])]
    #[TestWith([
        'The lazy fox jumped over the fence',
        'Fox',
        'mouse',
        'The lazy fox jumped over the fence',
        true,
        0
    ])]
    #[TestWith([
        'The lazy fox, the lazy fox, the lazy fox',
        'mouse',
        'fox',
        'The lazy mouse, the lazy mouse, the lazy mouse',
        true,
        3
    ])]
    #[TestWith([
        'The lazy mouse jumped over the fence',
        'Fox',
        'mouse',
        'The lazy fox jumped over the fence',
        false,
        1
    ])]
    #[TestWith([
        'An lazy mouse jumped over the fence',
        ['The', 'fox'],
        ['An',  'mouse'],
        'The lazy fox jumped over the fence',
        true,
        2
    ])]
    public function testReplace (string $expected, string|array $search, string|array $replace, string $string, bool $case_sensitive, int $count_replaced):void {

        self::assertSame($expected, Str\SB\Replace::replace($search, $replace, $string, $case_sensitive, $count));
        self::assertSame($count, $count_replaced);

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param string $replace
     * @param int $offset
     * @param null|int $length
     *
     * @return void
     */
    #[TestWith([
        'An lazy fox jumped over the fence',
        'The lazy fox jumped over the fence',
        'An',
        0,
        3
    ])]
    #[TestWith([
        'The lazy fox jumped over the bush',
        'The lazy fox jumped over the fence',
        'bush',
        -5,
        5
    ])]
    public function testPart (string $expected, string $string, string $replace, int $offset, ?int $length = null):void {

        self::assertSame($expected, Str\SB\Replace::part($string, $replace, $offset, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param array<non-empty-string, string> $replace_pairs
     *
     * @return void
     */
    #[TestWith(['Hello World', 'Hillo Warld', ['il' => 'el', 'ar' => 'or']])]
    public function testTranslate (string $expected, string $string, array $replace_pairs):void {

        self::assertSame($expected, Str\SB\Replace::translate($string, $replace_pairs));

    }

}