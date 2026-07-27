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
 * ### Test PHP Multibyte String Runtime Wrapper Utility - Inspection
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\MB\Inspection::class)]
final class InspectionTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param string $string
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @return void
     */
    #[TestWith([22, 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    public function testLength (int $expected, string $string, ?Encoding $encoding = null):void {

        self::assertSame($expected, Str\MB\Inspection::length($string, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $string
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @return void
     */
    #[TestWith([true, 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    #[TestWith([false, 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', Encoding::ASCII])]
    public function testCheckEncoding (bool $expected, string $string, ?Encoding $encoding = null):void {

        self::assertSame($expected, Str\MB\Inspection::checkEncoding($string, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param \FireHub\Core\Type\Str\Encoding $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith([Encoding::UTF_8, 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    public function testDetectEncoding (Encoding $expected, string $string):void {

        self::assertSame($expected, Str\MB\Inspection::detectEncoding($string));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testListEncoding ():void {

        self::assertIsArray(Str\MB\Inspection::listEncodings());

        self::assertNotEmpty(Str\MB\Inspection::listEncodings());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testEncodingEnumContainsOnlySupportedEncodings ():void {

        $supported = Str\MB\Inspection::listEncodings();

        foreach (Encoding::cases() as $encoding) {
            self::assertContains(
                $encoding->value,
                $supported,
                sprintf('Encoding "%s" is not supported by this PHP runtime.', $encoding->value),
            );
        }

    }

}