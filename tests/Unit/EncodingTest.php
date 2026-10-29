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

namespace FireHub\Tests\Runtime\Unit;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Encoding;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Depends, Group, Small, TestWith
};

/**
 * ### Test binary-to-text encoding runtime utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Encoding::class)]
final class EncodingTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $data
     *
     * @return void
     */
    #[TestWith(['', ''])]
    #[TestWith(['ZmlyZWh1Yg==', 'firehub'])]
    #[TestWith(['AP8=', "\x00\xFF"])]
    public function testBase64Encode (string $expected, string $data):void {

        self::assertSame($expected, Encoding::base64Encode($data));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $data
     *
     * @return void
     */
    #[TestWith(['', ''])]
    #[TestWith(['firehub', 'ZmlyZWh1Yg=='])]
    #[TestWith(["\x00\xFF", 'AP8='])]
    public function testBase64Decode (string $expected, string $data):void {

        self::assertSame($expected, Encoding::base64Decode($data));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testBase64DecodeStrictness ():void {

        self::assertFalse(Encoding::base64Decode('Zmly!ZWh1Yg=='));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $data
     *
     * @return void
     */
    #[TestWith(['', ''])]
    #[TestWith(['66697265687562', 'firehub'])]
    #[TestWith(['00ff', "\x00\xFF"])]
    public function testHexEncode (string $expected, string $data):void {

        self::assertSame($expected, Encoding::hexEncode($data));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $data
     *
     * @return void
     */
    #[TestWith(['', ''])]
    #[TestWith(['firehub', '66697265687562'])]
    #[TestWith(["\x00\xFF", '00FF'])]
    public function testHexDecode (string $expected, string $data):void {

        self::assertSame($expected, Encoding::hexDecode($data));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $data
     *
     * @return void
     */
    #[TestWith(['firehub', 'firehub'])]
    #[TestWith(['=00=FF', "\x00\xFF"])]
    public function testQuotedPrintableEncode (string $expected, string $data):void {

        self::assertSame($expected, Encoding::quotedPrintableEncode($data));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $data
     *
     * @return void
     */
    #[TestWith(['firehub', 'firehub'])]
    #[TestWith(["\x00\xFF", '=00=FF'])]
    #[TestWith(['Hello World', "Hello=\r\n World"])]
    public function testQuotedPrintableDecode (string $expected, string $data):void {

        self::assertSame($expected, Encoding::quotedPrintableDecode($data));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testUuEncodeDecode ():void {

        $data = "FireHub\x00\xFF";

        $encoded = Encoding::uuEncode($data);

        self::assertSame(convert_uuencode($data), $encoded);
        self::assertSame($data, Encoding::uuDecode($encoded));

    }

}