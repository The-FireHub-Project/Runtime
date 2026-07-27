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
 * ### Test PHP Single-Byte String Runtime Wrapper Utility - Search
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\SB\Search::class)]
final class SearchTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $value
     * @param string $string
     *
     * @return void
     */
    #[TestWith([false, 'j', ''])]
    #[TestWith([true, 'j', 'ijk'])]
    public function testContains (bool $expected, string $value, string $string):void {

        self::assertSame($expected, Str\SB\Search::contains($value, $string));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $value
     * @param string $string
     *
     * @return void
     */
    #[TestWith([false, 'j', ''])]
    #[TestWith([true, 'i', 'ijk'])]
    public function testStartsWith (bool $expected, string $value, string $string):void {

        self::assertSame($expected, Str\SB\Search::startsWith($value, $string));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $value
     * @param string $string
     *
     * @return void
     */
    #[TestWith([false, 'j', ''])]
    #[TestWith([true, 'k', 'ijk'])]
    public function testEndsWith (bool $expected, string $value, string $string):void {

        self::assertSame($expected, Str\SB\Search::endsWith($value, $string));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int|false $expected
     * @param string $search
     * @param string $string
     * @param bool $case_sensitive
     * @param int $offset
     *
     * @return void
     */
    #[TestWith([false, 'Fox', 'The lazy fox jumped over the fence'])]
    #[TestWith([9, 'Fox', 'The lazy fox jumped over the fence', false])]
    #[TestWith([9, 'Fox', 'The lazy fox jumped over the fence', false, 9])]
    #[TestWith([0, 'T', 'The lazy fox jumped over the fence'])]
    #[TestWith([false, 'Fox', 'The lazy fox jumped over the fence', false, 10])]
    public function testFirstPosition (int|false $expected, string $search, string $string, bool $case_sensitive = true, int $offset = 0):void {

        self::assertSame($expected, Str\SB\Search::firstPosition($search, $string, $case_sensitive, $offset));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int|false $expected
     * @param string $search
     * @param string $string
     * @param bool $case_sensitive
     * @param int $offset
     *
     * @return void
     */
    #[TestWith([false, 'Fox', 'The lazy fox jumped over the fence'])]
    #[TestWith([9, 'Fox', 'The lazy fox jumped over the fence', false])]
    #[TestWith([9, 'Fox', 'The lazy fox jumped over the fence', false, 9])]
    #[TestWith([0, 'T', 'The lazy fox jumped over the fence'])]
    #[TestWith([false, 'Fox', 'The lazy fox jumped over the fence', false, 10])]
    public function testLastPosition (int|false $expected, string $search, string $string, bool $case_sensitive = true, int $offset = 0):void {

        self::assertSame($expected, Str\SB\Search::lastPosition($search, $string, $case_sensitive, $offset));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param string $string
     * @param string $characters
     * @param int $offset
     * @param null|int $length
     *
     * @return void
     */
    #[TestWith([0, 'The lazy fox jumped over the fence', 'lazy'])]
    #[TestWith([4, 'The lazy fox jumped over the fence', 'lazy',4])]
    #[TestWith([3, 'The lazy fox jumped over the fence', 'lazy',4, 3])]
    public function testSegmentLength (int $expected, string $string, string $characters, int $offset = 0, ?int $length = null):void {

        self::assertSame($expected, Str\SB\Search::segmentLength($string, $characters, $offset, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param string $string
     * @param string $characters
     * @param int $offset
     * @param null|int $length
     *
     * @return void
     */
    #[TestWith([4, 'The lazy fox jumped over the fence', 'lazy', 0])]
    #[TestWith([0, 'The lazy fox jumped over the fence', 'lazy', 4])]
    #[TestWith([2, 'The lazy fox jumped over the fence', 'lazy', 2, 4])]
    public function testSegmentNotLength (int $expected, string $string, string $characters, int $offset = 0, ?int $length = null):void {

        self::assertSame($expected, Str\SB\Search::segmentNotLength($string, $characters, $offset, $length));

    }

}