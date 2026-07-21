<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.0
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\Unit;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Json;
use FireHub\Runtime\Json\ {
    Flag, Flag\Decode, Flag\Encode, Flag\Validate
};
use FireHub\Runtime\Exception\ {
    JsonDecodeException, JsonEncodeException
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime JSON Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Json::class)]
final class JsonTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param mixed $value
     * @param positive-int $depth
     * @param \FireHub\Runtime\Json\Flag|\FireHub\Runtime\Json\Flag\Encode ...$flags
     *
     * @throws \FireHub\Runtime\Exception\JsonEncodeException
     *
     * @return void
     */
    #[TestWith(['"firehub"', 'firehub'])]
    #[TestWith(['[1,2,3]', [1,2,3]])]
    #[TestWith(['{"a":1,"b":2,"c":3,"d":4,"e":5}', ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5]])]
    #[TestWith(['12', 12.0])]
    #[TestWith(['12.0', 12.0, 512, Encode::PRESERVE_ZERO_FRACTION])]
    public function testEncode (string $expected, mixed $value, int $depth = 512, Flag|Encode ...$flags):void {

        self::assertSame($expected, JSON::encode($value, $depth, ...$flags));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param positive-int $depth
     * @param \FireHub\Runtime\Json\Flag|\FireHub\Runtime\Json\Flag\Encode ...$flags
     *
     * @return void
     */
    #[TestWith(["\xB1\x31"])]
    public function testEncodeException (mixed $value, int $depth = 512, Flag|Encode ...$flags):void {

        $this->expectException(JsonEncodeException::class);

        JSON::encode($value, $depth, ...$flags);

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $expected
     * @param string $json
     * @param bool $as_array
     * @param positive-int $depth
     * @param \FireHub\Runtime\Json\Flag|\FireHub\Runtime\Json\Flag\Decode ...$flags
     *
     * @throws \FireHub\Runtime\Exception\JsonDecodeException
     *
     * @return void
     */
    #[TestWith(['firehub', '"firehub"'])]
    #[TestWith([[1,2,3], '[1,2,3]'])]
    #[TestWith([['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5], '{"a":1,"b":2,"c":3,"d":4,"e":5}', true])]
    #[TestWith([12.0, '12.0'])]
    #[TestWith([1.2345678901234567E+19, "12345678901234567890"])]
    #[TestWith(['12345678901234567890', "12345678901234567890", false, 512, Decode::BIGINT_AS_STRING])]
    public function testDecode (mixed $expected, string $json, bool $as_array = false, int $depth = 512, Flag|Decode ...$flags):void {

        self::assertSame($expected, JSON::decode($json, $as_array, $depth, ...$flags));

    }

    /**
     * @since 1.0.0
     *
     * @param string $json
     * @param bool $as_array
     * @param positive-int $depth
     * @param \FireHub\Runtime\Json\Flag|\FireHub\Runtime\Json\Flag\Decode ...$flags
     *
     * @return void
     */
    #[TestWith(["\xB1\x31"])]
    public function testDecodeException (string $json, bool $as_array = false, int $depth = 512, Flag|Decode ...$flags):void {

        $this->expectException(JsonDecodeException::class);

        JSON::decode($json, $as_array, $depth, ...$flags);

    }

    /**
     * @since 1.0.0
     *
     * @param string $json
     * @param positive-int $depth
     * @param \FireHub\Runtime\Json\Flag\Validate ...$flags
     *
     * @return void
     */
    #[TestWith(['"firehub"'])]
    #[TestWith(['[1,2,3]'])]
    #[TestWith(['{"a":1,"b":2,"c":3,"d":4,"e":5}'])]
    #[TestWith(['12.0'])]
    #[TestWith(["12345678901234567890"])]
    public function testValidate (string $json, int $depth = 512, Validate ...$flags):void {

        self::assertTrue(JSON::validate($json, $depth, ...$flags));

    }

}