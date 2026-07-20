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

namespace FireHub\Tests\Runtime\Unit\Str\SB;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Str;
use FireHub\Core\Meta\Enum\Side;
use FireHub\Runtime\Exception\ {
    EmptyPadException, InvalidChunkLengthException
};
use FireHub\Tests\Runtime\DataProviders\StrDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, DependsExternal, Group, Small, TestWith
};

/**
 * ### Test PHP Single-Byte String Runtime Wrapper Utility - Transform
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\SB\Transform::class)]
final class TransformTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param int $times
     * @param string $separator
     *
     * @return void
     */
    #[TestWith(['fox-fox', 'fox', 2, '-'])]
    public function testRepeat (string $expected, string $string, int $times, string $separator = ''):void {

        self::assertSame($expected, Str\SB\Transform::repeat($string, $times, $separator));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param int $length
     * @param non-empty-string $pad
     * @param \FireHub\Core\Meta\Enum\Side $side
     *
     * @throws \FireHub\Runtime\Exception\EmptyPadException
     *
     * @return void
     */
    #[TestWith([
        '----------------The lazy fox jumped over the fence',
        'The lazy fox jumped over the fence',
        50,
        '-',
        Side::LEFT
    ])]
    #[TestWith([
        'The lazy fox jumped over the fence----------------',
        'The lazy fox jumped over the fence',
        50,
        '-'
    ])]
    #[TestWith([
        '--------The lazy fox jumped over the fence--------',
        'The lazy fox jumped over the fence',
        50,
        '-',
        Side::BOTH
    ])]
    public function testPad (string $expected, string $string, int $length, string $pad = ' ', Side $side = Side::RIGHT):void {

        self::assertSame($expected, Str\SB\Transform::pad($string, $length, $pad, $side));

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

        Str\SB\Transform::pad($string, $length, $pad, $side);

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['ecnef eht revo depmuj xof yzal ehT', 'The lazy fox jumped over the fence'])]
    public function testReverse (string $expected, string $string):void {

        self::assertSame($expected, Str\SB\Transform::reverse($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $string
     *
     * @throws \FireHub\Runtime\Exception\StringSplitLengthException
     *
     * @return void
     */
    #[DependsExternal(InspectionTest::class, 'testLength')]
    #[DependsExternal(AccessTest::class, 'testSplit')]
    #[DataProviderExternal(StrDataProvider::class, 'stringsSB')]
    public function testShuffle (string $string):void {

        $shuffled = Str\SB\Transform::shuffle($string);

        self::assertSame(Str\SB\Inspection::length($string), Str\SB\Inspection::length($shuffled));

        self::assertEqualsCanonicalizing(Str\SB\Access::split($string), Str\SB\Access::split($shuffled));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param positive-int $length
     * @param string $separator
     *
     * @throws \FireHub\Runtime\Exception\InvalidChunkLengthException
     *
     * @return void
     */
    #[TestWith([
        'The lazy f-ox jumped -over the f-ence-',
        'The lazy fox jumped over the fence',
        10,
        '-'
    ])]
    public function testChunkSplit (string $expected, string $string, int $length = 76, string $separator = "\r\n"):void {

        self::assertSame($expected, Str\SB\Transform::chunkSplit($string, $length, $separator));

    }

    /**
     * @since 1.0.0
     *
     * @param string $string
     * @param positive-int $length
     * @param string $separator
     *
     * @return void
     */
    #[TestWith(['The lazy fox jumped over the fence', 0, '-'])]
    public function testChunkSplitLengthLessThanOne (string $string, int $length = 76, string $separator = "\r\n"):void {

        $this->expectException(InvalidChunkLengthException::class);

        Str\SB\Transform::chunkSplit($string, $length, $separator);

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param int $width
     * @param string $break
     * @param bool $cut_long_words
     *
     * @return void
     */
    #[TestWith(['The lazy fox jumped<br />over the fence', 'The lazy fox jumped over the fence', 20, '<br />', true])]
    #[TestWith(['A very<br />long<br />wooooooo<br />ooooord', 'A very long woooooooooooord', 8, '<br />', true])]
    public function testWrap (string $expected, string $string, int $width = 75, string $break = "\n", bool $cut_long_words = false):void {

        self::assertSame($expected, Str\SB\Transform::wrap($string, $width, $break, $cut_long_words));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $format
     * @param null|scalar...$values
     *
     * @return void
     */
    #[TestWith(['There are 5 monkeys in the tree', 'There are %d monkeys in the %s', 5, 'tree'])]
    public function testFormat (string $expected, string $format, null|bool|float|int|string ...$values):void {

        self::assertSame($expected, Str\SB\Transform::format($format, ...$values));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param \FireHub\Core\Meta\Enum\Side $side
     * @param string $characters
     *
     * @return void
     */
    #[TestWith([
        "These are a few words :) ...  \n\r",
        "\t\tThese are a few words :) ...  \n\r",
        Side::LEFT
    ])]
    #[TestWith([
        "\t\tThese are a few words :) ...",
        "\t\tThese are a few words :) ...",
        Side::RIGHT
    ])]
    #[TestWith([
        "These are a few words :) ...",
        "\t\tThese are a few words :) ...  \n\r"
    ])]
    public function testTrim (string $expected, string $string, Side $side = Side::BOTH, string $characters = " \n\r\t\v\x00"):void {

        self::assertSame($expected, Str\SB\Transform::trim($string, $side, $characters));

    }

}