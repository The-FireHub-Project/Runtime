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
use FireHub\Core\Meta\Enum\Side;
use FireHub\Runtime\Exception\EmptyPadException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Multibyte String Runtime Wrapper Utility - Transform
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\MB\Transform::class)]
final class TransformTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param int $length
     * @param non-empty-string $pad
     * @param \FireHub\Core\Meta\Enum\Side $side
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @throws \FireHub\Runtime\Exception\EmptyPadException
     *
     * @return void
     */
    #[TestWith([
        '❤❓❇❤▶▶',
        '▶▶',
        6,
        '❤❓❇',
        Side::LEFT
    ])]
    #[TestWith([
        '▶▶❤❓❇❤',
        '▶▶',
        6,
        '❤❓❇'
    ])]
    #[TestWith([
        '❤❓▶▶❤❓',
        '▶▶',
        6,
        '❤❓❇',
        Side::BOTH
    ])]
    public function testPad (string $expected, string $string, int $length, string $pad = ' ', Side $side = Side::RIGHT, ?Encoding $encoding = null):void {

        self::assertSame($expected, Str\MB\Transform::pad($string, $length, $pad, $side, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param string $string
     * @param int $length
     * @param non-empty-string $pad
     * @param \FireHub\Core\Meta\Enum\Side $side
     *
     * @return void
     */
    #[TestWith([
        'The lazy fox jumped over the fence',
        50,
        '',
        Side::BOTH
    ])]
    public function testPadIsEmpty (string $string, int $length, string $pad = ' ', Side $side = Side::RIGHT):void {

        $this->expectException(EmptyPadException::class);

        Str\MB\Transform::pad($string, $length, $pad, $side);

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param \FireHub\Core\Meta\Enum\Side $side
     * @param null|string $characters
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @return void
     */
    #[TestWith([
        "ÈßÁ カタカナЙÈßÁ カタカナ :) ...  \n\r",
        "\t\tÈßÁ カタカナЙÈßÁ カタカナ :) ...  \n\r",
        Side::LEFT,
        " \n\r\t\v\x00"
    ])]
    #[TestWith([
        "\t\tÈßÁ カタカナЙÈßÁ カタカナ :) ...",
        "\t\tÈßÁ カタカナЙÈßÁ カタカナ :) ...",
        Side::RIGHT,
        " \n\r\t\v\x00"
    ])]
    #[TestWith([
        "ÈßÁ カタカナЙÈßÁ カタカナ :) ...",
        "\t\tÈßÁ カタカナЙÈßÁ カタカナ :) ...  \n\r",
        Side::BOTH,
        " \n\r\t\v\x00"
    ])]
    public function testTrim (string $expected, string $string, Side $side = Side::BOTH, ?string $characters = null, ?Encoding $encoding = null):void {

        self::assertSame($expected, Str\MB\Transform::trim($string, $side, $characters, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param string $string
     * @param \FireHub\Core\Type\Str\Encoding $to
     * @param null|\FireHub\Core\Type\Str\Encoding $from
     *
     * @return void
     */
    #[TestWith(['đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', Encoding::UTF_8, Encoding::UTF_8])]
    public function testConvertEncoding (string $string, Encoding $to, ?Encoding $from = null):void {

        self::assertSame($string, Str\MB\Transform::convertEncoding($string, $to, $from));
    }

}