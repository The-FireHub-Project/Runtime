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

namespace FireHub\Tests\Runtime\Unit\Str\MB;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Str;
use FireHub\Core\Type\Str\Encoding;
use FireHub\Runtime\Exception\StringSplitLengthException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Multibyte String Runtime Wrapper Utility - Access
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\MB\Access::class)]
final class AccessTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param int $start
     * @param null|int $length
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @return void
     */
    #[TestWith(['诶杰艾玛 ЛЙ ÈßÁ カタカナ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', 6])]
    #[TestWith(['ЛЙ È', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', 11, 4])]
    #[TestWith(['カタカ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', -4, 3])]
    public function testPart (string $expected, string $string, int $start, ?int $length = null, ?Encoding $encoding = null):void {

        self::assertSame($expected, Str\MB\Access::part($string, $start, $length, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param string $string
     * @param string $search
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @return void
     */
    #[TestWith([2, 'ЛЙ ÈßÁ ЛЙ ÈßÁ', 'ЛЙ'])]
    public function testPartCount (int $expected, string $string, string $search, ?Encoding $encoding = null):void {

        self::assertSame($expected, Str\MB\Access::partCount($string, $search, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $character
     * @param string $string
     * @param bool $before_needle
     * @param bool $case_sensitive
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @return void
     */
    #[TestWith(['诶杰艾玛 ЛЙ ÈßÁ カタカナ', '诶杰艾玛', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    #[TestWith(['đščćž 诶杰艾玛', ' ЛЙ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', true])]
    #[TestWith(['čćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', 'Č', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false, false])]
    public function testLastCharacter (string $expected, string $character, string $string, bool $before_needle = false, bool $case_sensitive = true, ?Encoding $encoding = null):void {

        self::assertSame(
            $expected,
            Str\MB\Access::lastCharacter($string, $character, $before_needle, $case_sensitive, $encoding)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param string $find
     * @param bool $before_needle
     * @param bool $case_sensitive
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @return void
     */
    #[TestWith(['诶杰艾玛 ЛЙ ÈßÁ カタカナ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', '诶杰艾玛'])]
    #[TestWith(['đščćž 诶杰艾玛', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', ' ЛЙ', true])]
    #[TestWith(['čćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', 'Č', false, false])]
    public function testFirstOccurrence (string $expected, string $string, string $find, bool $before_needle = false, bool $case_sensitive = true, ?Encoding $encoding = null):void {

        self::assertSame($expected, Str\MB\Access::firstOccurrence($string, $find, $before_needle, $case_sensitive, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param list<non-empty-string> $expected
     * @param non-empty-string $string
     * @param positive-int $length
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @throws \FireHub\Runtime\Exception\StringSplitLengthException
     *
     * @return void
     */
    #[TestWith([
        [
            0 => 'đščćž',
            1 => ' 诶杰艾玛',
            2 => ' ЛЙ È',
            3 => 'ßÁ カタ',
            4 => 'カナ'
        ],
        'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ',
        5
    ])]
    public function testSplit (array $expected, string $string, int $length = 1, ?Encoding $encoding = null):void {

        self::assertSame($expected, Str\MB\Access::split($string, $length, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $string
     * @param positive-int $length
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @return void
     */
    #[TestWith(['The lazy fox jumped over the fence', 0])]
    public function testSplitLengthLessThanOne (string $string, int $length = 1, ?Encoding $encoding = null):void {

        $this->expectException(StringSplitLengthException::class);

        Str\MB\Access::split($string, $length, $encoding);

    }

}