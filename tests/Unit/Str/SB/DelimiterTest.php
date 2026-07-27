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
use FireHub\Runtime\Exception\EmptySeparatorException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP String Runtime Wrapper Utility - Delimiter
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\SB\Delimiter::class)]
final class DelimiterTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param array<array-key, null|scalar|\Stringable> $array
     * @param string $separator
     *
     * @throws \FireHub\Runtime\Exception\EmptySeparatorException
     *
     * @return void
     */
    #[TestWith([' ', ['', ''], ' '])]
    #[TestWith(['The lazy fox jumped over the fence', ['The', 'lazy', 'fox', 'jumped', 'over', 'the', 'fence'], ' '])]
    #[TestWith(['The lazy fox - over the fence', ['The lazy fox ', ' over the fence'], '-'])]
    public function testImplodeExplode (string $expected, array $array, string $separator = ''):void {

        self::assertSame($expected, Str\SB\Delimiter::implode($array, $separator));
        self::assertSame($array, Str\SB\Delimiter::explode($expected, $separator));

    }

    /**
     * @since 1.0.0
     *
     * @param string $string
     * @param string $separator
     *
     * @return void
     */
    #[TestWith(['The lazy fox jumped over the fence', ''])]
    public function testExplodeEmptyString (string $string, string $separator):void {

        $this->expectException(EmptySeparatorException::class);

        Str\SB\Delimiter::explode($string, $separator);

    }

}