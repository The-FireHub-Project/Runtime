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
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Multibyte String Runtime Wrapper Utility - Searc
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\MB\Search::class)]
final class SearchTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param non-negative-int|false $expected
     * @param string $search
     * @param string $string
     * @param bool $case_sensitive
     * @param int $offset
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @return void
     */
    #[TestWith([false, 'лй', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    #[TestWith([11, 'лй', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false])]
    #[TestWith([11, 'ЛЙ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false, 9])]
    #[TestWith([0, 'đ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    #[TestWith([false, 'ЛЙ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false, 20])]
    public function testFirstPosition (int|false $expected, string $search, string $string, bool $case_sensitive = true, int $offset = 0, ?Encoding $encoding = null):void {

        self::assertSame($expected, Str\MB\Search::firstPosition($search, $string, $case_sensitive, $offset, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int|false $expected
     * @param string $search
     * @param string $string
     * @param bool $case_sensitive
     * @param int $offset
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @return void
     */
    #[TestWith([false, 'лй', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    #[TestWith([11, 'лй', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false])]
    #[TestWith([11, 'ЛЙ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false, 9])]
    #[TestWith([0, 'đ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    #[TestWith([false, 'ЛЙ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false, 20])]
    public function testLastPosition (int|false $expected, string $search, string $string, bool $case_sensitive = true, int $offset = 0, ?Encoding $encoding = null):void {

        self::assertSame($expected, Str\MB\Search::lastPosition($search, $string, $case_sensitive, $offset, $encoding));

    }

}