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
use FireHub\Runtime\Exception\StringSplitLengthException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Byte-Oriented String Runtime Wrapper Utility - Access
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\SB\Access::class)]
final class AccessTest extends FireHubTestCase {


    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param int $start
     * @param null|int $length
     *
     * @return void
     */
    #[TestWith(['azy fox jumped over the fence', 'The lazy fox jumped over the fence', 5])]
    #[TestWith(['ox j', 'The lazy fox jumped over the fence', 10, 4])]
    #[TestWith(['fen', 'The lazy fox jumped over the fence', -5, 3])]
    public function testPart (string $expected, string $string, int $start, ?int $length = null):void {

        self::assertSame($expected, Str\SB\Access::part($string, $start, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param string $string
     * @param string $search
     * @param int $start
     * @param null|int $length
     *
     * @return void
     */
    #[TestWith([2, 'This is a test', 'is'])]
    #[TestWith([1, 'This is a test', 'is', 3])]
    #[TestWith([0, 'This is a test', 'is', 3, 3])]
    public function testPartCount (int $expected, string $string, string $search, int $start = 0, ?int $length = null):void {

        self::assertSame($expected, Str\SB\Access::partCount($string, $search, $start, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param string|false $expected
     * @param string $characters
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['ox jumped over the fence', 'xov', 'The lazy fox jumped over the fence'])]
    #[TestWith([false, 'bqg', 'The lazy fox jumped over the fence'])]
    public function testPartFrom (string|false $expected, string $characters, string $string):void {

        self::assertSame($expected, Str\SB\Access::firstCharacterFrom($characters, $string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param string $character
     * @param bool $before_needle
     *
     * @return void
     */
    #[TestWith(['jumped over the fence', 'jumped', 'The lazy fox jumped over the fence'])]
    public function testLastCharacter (string $expected, string $character, string $string, bool $before_needle = false):void {

        self::assertSame($expected, Str\SB\Access::lastCharacter($string, $character, $before_needle));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param string $find
     * @param bool $before_needle
     * @param bool $case_sensitive
     *
     * @return void
     */
    #[TestWith(['fox jumped over the fence', 'The lazy fox jumped over the fence', 'fox'])]
    #[TestWith(['The lazy', 'The lazy fox jumped over the fence', ' fox', true])]
    #[TestWith([' fox jumped over the fence', 'The lazy fox jumped over the fence', ' Fox', false, false])]
    public function testFirstOccurrence (string $expected, string $string, string $find, bool $before_needle = false, bool $case_sensitive = true):void {

        self::assertSame($expected, Str\SB\Access::firstOccurrence($string, $find, $before_needle, $case_sensitive));

    }

    /**
     * @since 1.0.0
     *
     * @param list<non-empty-string> $expected
     * @param non-empty-string $string
     * @param positive-int $length
     *
     * @throws \FireHub\Runtime\Exception\StringSplitLengthException
     *
     * @return void
     */
    #[TestWith([
        [
            0 => 'The l',
            1 => 'azy f',
            2 => 'ox ju',
            3 => 'mped ',
            4 => 'over ',
            5 => 'the f',
            6 => 'ence'
        ],
        'The lazy fox jumped over the fence',
        5
    ])]
    public function testSplit (array $expected, string $string, int $length = 1):void {

        self::assertSame($expected, Str\SB\Access::split($string, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $string
     * @param positive-int $length
     *
     * @return void
     */
    #[TestWith(['The lazy fox jumped over the fence', 0])]
    public function testSplitLengthLessThanOne (string $string, int $length = 1):void {

        $this->expectException(StringSplitLengthException::class);

        Str\SB\Access::split($string, $length);

    }

}