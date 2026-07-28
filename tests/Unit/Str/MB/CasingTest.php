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

namespace FireHub\Tests\Runtime\Unit\Str\MB;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Str;
use FireHub\Core\Type\Str\Encoding;
use FireHub\Runtime\Type\Str\CaseMode;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Multibyte String Runtime Wrapper Utility - Casing
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\MB\Casing::class)]
final class CasingTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param \FireHub\Runtime\Type\Str\CaseMode $case_mode
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @return void
     */
    #[TestWith(['ĐŠČĆŽ 诶杰艾玛 ЛЙ ÈSSÁ カタカナ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', CaseMode::UPPER])]
    #[TestWith(['đščćž 诶杰艾玛 лй èssá カタカナ', 'ĐŠČĆŽ 诶杰艾玛 ЛЙ ÈSSÁ カタカナ', CaseMode::LOWER])]
    #[TestWith(['Đščćž 诶杰艾玛 Лй Èßá カタカナ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', CaseMode::TITLE])]
    public function testConvert (string $expected, string $string, CaseMode $case_mode, ?Encoding $encoding = null):void {

        self::assertSame($expected, Str\MB\Casing::convert($string, $case_mode, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['Đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    public function testCapitalize (string $expected, string $string):void {

        self::assertSame($expected, Str\MB\Casing::capitalize($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', 'Đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    public function testUncapitalize (string $expected, string $string):void {

        self::assertSame($expected, Str\MB\Casing::uncapitalize($string));

    }

}