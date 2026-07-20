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
 * ### Test PHP Single-Byte String Runtime Wrapper Utility - Escape
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\SB\Escape::class)]
final class EscapeTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(["O\\\\\\'Reilly", "O\'Reilly"])]
    #[TestWith(["O\'Reilly", "O'Reilly"])]
    #[TestWith(["O\\\\\\\"Reilly", 'O\"Reilly'])]
    #[TestWith(["O\\\\\\\"Reilly", 'O\"Reilly'])]
    #[TestWith(["O\\\\Reilly", 'O\\Reilly'])]
    #[TestWith(["O\\\\Reilly", 'O\Reilly'])]
    public function testAddStripSlashes (string $expected, string $string):void {

        self::assertSame($expected, Str\SB\Escape::addSlashes($string));
        self::assertSame($string, Str\SB\Escape::stripSlashes($expected));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param null|string $characters
     *
     * @return void
     */
    #[TestWith(["\\O\\\\Reilly", 'O\Reilly', 'A..Z'])]
    #[TestWith(["OR\\e\\i\\l\\l\\y", 'OReilly', 'a..z'])]
    public function testAddCStripSlashes (string $expected, string $string, ?string $characters = null):void {

        self::assertSame($expected, Str\SB\Escape::addCSlashes($string, $characters));
        self::assertSame($string, Str\SB\Escape::stripCSlashes($expected));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith([
        "PHP is a popular scripting language\. Fast, flexible, and pragmatic\.",
        'PHP is a popular scripting language. Fast, flexible, and pragmatic.'
    ])]
    public function testQuoteMeta (string $expected, string $string):void {

        self::assertSame($expected, Str\SB\Escape::quoteMeta($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param null|string|array<int, string> $allowed_tags
     *
     * @return void
     */
    #[TestWith([
        'Test paragraph. Other text',
        '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>'
    ])]
    #[TestWith([
        '<p>Test paragraph.</p> <a href="#fragment">Other text</a>',
        '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>',
        ['p', 'a']
    ])]
    public function testStripTags (string $expected, string $string, null|string|array $allowed_tags = null):void {

        self::assertSame($expected, Str\SB\Escape::stripTags($string, $allowed_tags));

    }

}