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
use FireHub\Runtime\Exception\InvalidCharacterCodepointException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Single-Byte Character Runtime Wrapper Utility - SB
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Char\SB::class)]
final class SBTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $string
     * @param int<0, 255> $codepoint
     *
     * @throws \FireHub\Runtime\Exception\InvalidCharacterCodepointException
     *
     * @return void
     */
    #[TestWith(['!', 33])]
    #[TestWith(['@', 64])]
    #[TestWith(['a', 97])]
    public function testChr (string $string, int $codepoint):void {

        self::assertSame($string, Char\SB::chr($codepoint));

    }

    /**
     * @since 1.0.0
     *
     * @param int<0, 255> $codepoint
     *
     * @return void
     */
    #[TestWith([-1])]
    #[TestWith([256])]
    public function testChrOutsideValidRange (int $codepoint):void {

        $this->expectException(InvalidCharacterCodepointException::class);

        Char\SB::chr($codepoint);

    }

    /**
     * @since 1.0.0
     *
     * @param string $string
     * @param int<0, 255> $codepoint
     *
     * @return void
     */
    #[TestWith(['!', 33])]
    #[TestWith(['@', 64])]
    #[TestWith(['a', 97])]
    #[TestWith(['', 0])]
    public function testOrd (string $string, int $codepoint):void {

        self::assertSame($codepoint, Char\SB::ord($string));

    }

}