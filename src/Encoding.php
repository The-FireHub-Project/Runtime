<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.2
 * @package Runtime
 */

namespace FireHub\Runtime;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function base64_encode;
use function base64_decode;
use function bin2hex;
use function convert_uuencode;
use function convert_uudecode;
use function hex2bin;
use function quoted_printable_encode;
use function quoted_printable_decode;
use function rawurlencode;
use function rawurldecode;
use function urlencode;
use function urldecode;

/**
 * ### Binary-to-text encoding runtime utilities
 *
 * Provides direct wrappers around PHP's native binary-to-text encoding and decoding functions, preserving their
 * native return values.
 * @since 1.0.0
 */
final readonly class Encoding extends NativeRuntime {

    /**
     * ### Encode data using Base64
     * @since 1.0.0
     *
     * @param string $data <p>
     * Data to encode.
     * </p>
     *
     * @return string Base64-encoded data.
     */
    public static function base64Encode (string $data):string {

        return base64_encode($data);

    }

    /**
     * ### Decode Base64-encoded data
     * @since 1.0.0
     *
     * @param string $data <p>
     * Encoded data.
     * </p>
     *
     * @return string|false Decoded data, or false on failure.
     */
    public static function base64Decode (string $data):string|false {

        return base64_decode($data, true);

    }

    /**
     * ### Encode binary data as hexadecimal
     * @since 1.0.0
     *
     * @param string $data <p>
     * Binary data.
     * </p>
     *
     * @return string Hexadecimal representation.
     */
    public static function hexEncode (string $data):string {

        return bin2hex($data);

    }

    /**
     * ### Decode hexadecimal data
     * @since 1.0.0
     *
     * @param string $data <p>
     * Hexadecimal representation.
     * </p>
     *
     * @return string|false Decoded data, or false on invalid input.
     */
    public static function hexDecode (string $data):string|false {

        return hex2bin($data);

    }

    /**
     * ### Encode data using quoted-printable
     * @since 1.0.0
     *
     * @param string $data <p>
     * Data to encode.
     * </p>
     *
     * @return string Quoted-printable encoded data.
     */
    public static function quotedPrintableEncode (string $data):string {

        return quoted_printable_encode($data);

    }

    /**
     * ### Decode quoted-printable data
     * @since 1.0.0
     *
     * @param string $data <p>
     * Encoded data.
     * </p>
     *
     * @return string Decoded data.
     */
    public static function quotedPrintableDecode (string $data):string {

        return quoted_printable_decode($data);

    }

    /**
     * ### Encode data using uuencoding
     * @since 1.0.0
     *
     * @param string $data <p>
     * Data to encode.
     * </p>
     *
     * @return string Uuencoded data.
     */
    public static function uuEncode (string $data):string {

        return convert_uuencode($data);

    }

    /**
     * ### Decode uuencoded data
     * @since 1.0.0
     *
     * @param string $data <p>
     * Encoded data.
     * </p>
     *
     * @return string|false Decoded data, or false on failure.
     */
    public static function uuDecode (string $data):string|false {

        return convert_uudecode($data);

    }

    /**
     * ### URL-encode according to RFC 3986
     * @since 1.0.0
     *
     * @param string $string <p>
     * The URL to be encoded.
     * </p>
     *
     * @return string Returns a string in which all non-alphanumeric characters except -_.~ have been replaced with a
     * percent (%) sign followed by two hex digits.
     */
    public static function rawUrlEncode (string $string):string {

        return rawurlencode($string);

    }

    /**
     * ### Decode URL-encoded strings
     * @since 1.0.0
     *
     * @param string $string <p>
     * The URL to be decoded.
     * </p>
     *
     * @return string Returns the decoded URL, as a string.
     */
    public static function rawUrlDecode (string $string):string {

        return rawurldecode($string);

    }

    /**
     * ### URL-encodes string
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to be encoded.
     * </p>
     *
     * @return string Returns a string in which all non-alphanumeric characters except -_. have been replaced with a
     * percent (%) sign followed by two hex digits and spaces encoded as plus (+) signs.
     */
    public static function urlEncode (string $string):string {

        return urlencode($string);

    }

    /**
     * ### Decodes URL-encoded string
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to be decoded.
     * </p>
     *
     * @return string Returns the decoded string.
     */
    public static function urlDecode (string $string):string {

        return urldecode($string);

    }

}