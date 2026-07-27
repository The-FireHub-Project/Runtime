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
use FireHub\Runtime\Exception\InvalidPatternException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Regular Expression Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\SB\Regex::class)]
final class RegexTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $pattern
     * @param string $string
     * @param int $offset
     * @param bool $all
     * @param null|string[] &$result_out
     *
     * @throws \FireHub\Runtime\Exception\InvalidPatternException
     *
     * @return void
     */
    #[TestWith([true, '/php/i', 'PHP is the web scripting language of choice.', 0, false, [0 => 'PHP']])]
    #[TestWith([false, '/php/i', 'PHP is the web scripting language of choice.', 10, false, []])]
    #[TestWith([true, '/\bweb\b/i', 'PHP is the web scripting language of choice.', 0, false, [0 => 'web']])]
    #[TestWith([true, '/Web/','FireHub Web App FireHub Web App', 0, true, [0 => [0 => 'Web', 1 => 'Web']]])]
    public function testMatch (bool $expected, string $pattern, string $string, int $offset = 0, bool $all = false, ?array $result_out = null):void {

        self::assertSame($expected, Str\SB\Regex::match($pattern, $string, $offset, $all, $result));
        self::assertSame($result_out, $result);

    }

    /**
     * @since 1.0.0
     *
     * @param string $pattern
     * @param string $string
     * @param int $offset
     * @param bool $all
     * @param null|string[] &$result
     *
     * @return void
     */
    #[TestWith(['-1', ''])]
    public function testMatchInvalidPattern (string $pattern, string $string, int $offset = 0, bool $all = false, ?array &$result = null):void {

        $this->expectException(InvalidPatternException::class);

        $this->suppressPhpErrors(
            fn() => Str\SB\Regex::match($pattern, $string, $offset, $all, $result)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $pattern
     * @param string $replacement
     * @param string $string
     * @param int $limit
     *
     * @throws \FireHub\Runtime\Exception\InvalidPatternException
     *
     * @return void
     */
    #[TestWith(['April1,2003', '/(\w+) (\d+), (\d+)/i', '${1}1,$3', 'April 15, 2003'])]
    public function testReplace (string $expected, string $pattern, string $replacement, string $string, int $limit = -1):void {

        self::assertSame($expected, Str\SB\Regex::replace($pattern, $replacement, $string, $limit));

    }

    /**
     * @since 1.0.0
     *
     * @param string $pattern
     * @param string $replacement
     * @param string $string
     * @param int $limit
     *
     * @return void
     */
    #[TestWith(['-1', '', ''])]
    public function testReplaceInvalidPattern (string $pattern, string $replacement, string $string, int $limit = -1):void {

        $this->expectException(InvalidPatternException::class);

        $this->suppressPhpErrors(
            fn() => Str\SB\Regex::replace($pattern, $replacement, $string, $limit)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $pattern
     * @param string $string
     * @param int $limit
     *
     * @throws \FireHub\Runtime\Exception\InvalidPatternException
     *
     * @return void
     */
    #[TestWith([
        'April fools day is 04/01/2003 and last christmas was 12/24/2002.',
        '|(\d{2}/\d{2}/)(\d{4})|',
        'April fools day is 04/01/2002 and last christmas was 12/24/2001.'
    ])]
    public function testReplaceUsing (string $expected, string $pattern, string $string, int $limit = -1):void {

        self::assertSame(
            $expected,
            Str\SB\Regex::replaceUsing($pattern, static fn($matches) => $matches[1].($matches[2]+1),
                $string,
                $limit
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $pattern
     * @param string $string
     * @param int $limit
     *
     * @return void
     */
    #[TestWith([
        '-1',
        'April fools day is 04/01/2002 and last christmas was 12/24/2001.'
    ])]
    public function testReplaceUsingInvalidPattern (string $pattern, string $string, int $limit = -1):void {

        $this->expectException(InvalidPatternException::class);

        $this->suppressPhpErrors(
            fn() => Str\SB\Regex::replaceUsing($pattern, static fn($matches) => $matches[1].($matches[2]+1),
                $string,
                $limit
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param list<string> $expected
     * @param string $pattern
     * @param string $string
     * @param int $limit
     * @param bool $remove_empty
     *
     * @throws \FireHub\Runtime\Exception\InvalidPatternException
     *
     * @return void
     */
    #[TestWith([['Fire', 'ub'], '/H/', 'FireHub'])]
    public function testSplit (array $expected, string $pattern, string $string, int $limit = -1, bool $remove_empty = false):void {

        self::assertSame($expected, Str\SB\Regex::split($pattern, $string, $limit, $remove_empty));

    }

    /**
     * @since 1.0.0
     *
     * @param string $pattern
     * @param string $string
     * @param int $limit
     * @param bool $remove_empty
     *
     * @return void
     */
    #[TestWith(['-1', 'FireHub'])]
    public function testSplitInvalidPattern (string $pattern, string $string, int $limit = -1, bool $remove_empty = false):void {

        $this->expectException(InvalidPatternException::class);

        $this->suppressPhpErrors(
            fn() => Str\SB\Regex::split($pattern, $string, $limit, $remove_empty)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param null|string $delimiter
     *
     * @return void
     */
    #[TestWith(['Fire\Hub', 'FireHub', 'H'])]
    public function testQuote (string $expected, string $string, ?string $delimiter = null):void {

        self::assertSame($expected, Str\SB\Regex::quote($string, $delimiter));

    }

}