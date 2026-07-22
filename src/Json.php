<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.4
 * @package Runtime
 */

namespace FireHub\Runtime;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Json\ {
    Flag, Flag\Decode, Flag\Encode, Flag\Validate
};
use FireHub\Runtime\Exception\ {
    JsonDecodeException, JsonEncodeException
};
use JsonException;

use function json_decode;
use function json_encode;
use function json_validate;

/**
 * ### PHP Runtime JSON Utilities
 *
 * Provides low-level wrappers for encoding, decoding, and validating JSON data using native PHP JSON functions
 * while preserving native runtime behavior.
 *
 * This component exposes JSON processing capabilities through a consistent FireHub Runtime API
 * without altering PHP JSON semantics.
 * @since 1.0.0
 */
final class Json extends NativeRuntime {

    /**
     * ### JSON representation of a value
     *
     * Returns a string containing the JSON representation of the supplied value.
     *
     * If the parameter is an array or object, it will be serialized recursively.
     *
     * If a value to be serialized is an object, then by default only publicly visible properties will be included.
     *
     * Alternatively, a class may implement JsonSerializable to control how its values are serialized to JSON.
     *
     * The encoding is affected by the supplied flags, and additionally, the encoding of float values depends on the
     * value of serialize_precision.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Arr\Transform::reduce() To reduce flags.
     * @uses \FireHub\Runtime\Arr\Transform::unique() To get unique flags.
     *
     * @param mixed $value <p>
     * The value being encoded.
     *
     * Can be any type except a resource.
     * </p>
     * @param positive-int $depth [optional] <p>
     * Set the maximum depth.
     * </p>
     * @param \FireHub\Runtime\Json\Flag|\FireHub\Runtime\Json\Flag\Encode ...$flags <p>
     * JSON flags.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\JsonEncodeException If JSON encoding throws an error.
     *
     * @return non-empty-string JSON encoded string.
     *
     * @note All string data for $value parameter must be UTF-8 encoded.
     * @note Method always uses Flag::THROW_ON_ERROR internally.
     */
    public static function encode (mixed $value, int $depth = 512, Flag|Encode ...$flags):string {

        try {

            return json_encode($value, Arr\Transform::reduce(
                    Arr\Transform::unique($flags),
                    static fn(null|int $carry, Flag|Encode $flag) => $flag !== Flag::THROW_ON_ERROR
                        ? $carry | $flag->value
                        : $carry,
                    0
                ) | Flag::THROW_ON_ERROR->value, $depth)
                ?: throw new JsonEncodeException('Failed to encode JSON.');

        } catch (JsonException $error) {

            throw new JsonEncodeException(previous: $error);

        }

    }

    /**
     * ### Decodes a JSON string
     *
     * Takes a JSON-encoded string and converts it into a PHP value.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Arr\Transform::reduce() To reduce flags.
     * @uses \FireHub\Runtime\Arr\Transform::unique() To get unique flags.
     *
     * @param string $json <p>
     * The JSON string being decoded.
     * </p>
     * @param bool $as_array [optional] <p>
     * If true, the method will return a decoded JSON string as an associative array, otherwise it will return an object.
     * </p>
     * @param positive-int $depth [optional] <p>
     * Set the maximum depth.
     * </p>
     * @param \FireHub\Runtime\Json\Flag|\FireHub\Runtime\Json\Flag\Decode ...$flags <p>
     * JSON flags.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\JsonDecodeException If JSON decoding throws an error.
     *
     * @return mixed Value encoded in JSON as an appropriate PHP type, or null is returned if the JSON can't be decoded
     * or if the encoded data is deeper than the nesting limit.
     *
     * @note All string data for $json parameter must be UTF-8 encoded.
     * @note Method always uses Flag::THROW_ON_ERROR internally.
     * @tip This method already performs validation during decoding, so calling Json#validate immediately before
     * Json#decode will unnecessarily parse the string twice.
     */
    public static function decode (string $json, bool $as_array = false, int $depth = 512, Flag|Decode ...$flags):mixed {

        try {

            return json_decode($json, $as_array, $depth, Arr\Transform::reduce(
                    Arr\Transform::unique($flags),
                    static fn(null|int $carry, Flag|Decode $flag) => $flag !== Flag::THROW_ON_ERROR
                        ? $carry | $flag->value
                        : $carry,
                    0
                ) | Flag::THROW_ON_ERROR->value)
                ?: throw new JsonDecodeException;

        } catch (JsonException $error) {

            throw new JsonDecodeException(previous: $error);

        }

    }

    /**
     * ### Checks if a string contains valid JSON
     *
     * Json#validate() uses less memory than Json#decode if the decoded JSON payload is not used because it doesn't
     * need to build the array or object structure containing the payload.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Arr\Transform::reduce() To reduce flags.
     * @uses \FireHub\Runtime\Arr\Transform::unique() To get unique flags.
     *
     * @param string $json <p>
     * The string to validate.
     * </p>
     * @param positive-int $depth [optional] <p>
     * Set the maximum depth.
     * </p>
     * @param \FireHub\Runtime\Json\Flag\Validate ...$flags <p>
     * JSON flags.
     * </p>
     *
     * @return bool True if the given string is syntactically valid JSON, false otherwise.
     *
     * @caution Calling Json#validate immediately before Json#decode will unnecessarily parse the string twice, as
     * Json#decode implicitly performs validation during decoding.
     * Json#validate should therefore only be used if the decoded JSON payload is not immediately used and knowing
     * whether the string contains valid JSON is needed.
     */
    public static function validate (string $json, int $depth = 512, Validate ...$flags):bool {

        return json_validate($json, $depth, Arr\Transform::reduce( // @phpstan-ignore argument.type
            Arr\Transform::unique($flags),
            static fn(null|int $carry, Validate $flag) => $carry | $flag->value,
            0
        ));

    }

}