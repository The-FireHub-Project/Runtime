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

namespace FireHub\Tests\Runtime\Unit\Char;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Char;
use FireHub\Core\Type\Str\Encoding;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Multibyte Character Runtime Wrapper Utility - MB
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Char\MB::class)]
final class MBTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param int $codepoint
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @return void
     */
    #[TestWith(['A', 65, Encoding::UTF_8])]
    #[TestWith(['?', 63])]
    #[TestWith(['€', 0x20AC])]
    #[TestWith(['🐘', 128024])]
    public function testChr (string $expected, int $codepoint, ?Encoding $encoding = null):void {

        self::assertSame($expected, Char\MB::chr($codepoint, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param string $string
     * @param int $expected
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @return void
     */
    #[TestWith(['A', 65, Encoding::UTF_8])]
    #[TestWith(['?', 63])]
    #[TestWith(['€', 0x20AC])]
    #[TestWith(['🐘', 128024])]
    public function testOrd (string $string, int $expected, ?Encoding $encoding = null):void {

        self::assertSame($expected, Char\MB::ord($string, $encoding));

    }

}