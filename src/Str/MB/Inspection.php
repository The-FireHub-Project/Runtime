<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.1
 * @package Runtime
 */

namespace FireHub\Runtime\Str\MB;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Arr;
use FireHub\Core\Type\Str\Encoding;

use function mb_check_encoding;
use function mb_detect_encoding;
use function mb_list_encodings;
use function mb_strlen;

/**
 * ### PHP Multibyte String Runtime Wrapper Utility - Inspection
 *
 * Provides runtime wrappers for inspecting multibyte string data, including character length, encoding validation,
 * encoding detection, and available character encoding information while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for multibyte string inspection
 * operations without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Inspection extends NativeRuntime {

    /**
     * ### Get string length
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Type\Str\Encoding The encoding parameter for character encoding.
     *
     * @param string $string <p>
     * The string being measured for length.
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return non-negative-int String length.
     */
    public static function length (string $string, ?Encoding $encoding = null):int {

        return mb_strlen($string, $encoding?->value);

    }

    /**
     * ### Check if strings are valid for the specified encoding
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Type\Str\Encoding As checked encoding.
     *
     * @param string $string <p>
     * The string to check encoding on.
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding <p>
     * The expected encoding.
     * </p>
     *
     * @return bool True on success or false on failure.
     */
    public static function checkEncoding (string $string, ?Encoding $encoding = null):bool {

        return mb_check_encoding($string, $encoding?->value);

    }

    /**
     * ### Detect character encoding
     *
     * Detects the most likely character encoding for string from an ordered list of candidates.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Type\Str\Encoding As detected encoding.
     * @uses \FireHub\Runtime\Arr\Access::column() To get the encoding values from the Encoding enum.
     *
     * @param string $string <p>
     * The string to detect encoding.
     * </p>
     *
     * @return null|\FireHub\Core\Type\Str\Encoding The detected character encoding, or null if the string
     * is not valid in any of the listed encodings.
     */
    public static function detectEncoding (string $string):?Encoding {

        $encodings = Arr\Access::column(Encoding::cases(), 'value');

        return Encoding::tryFrom(
            mb_detect_encoding($string, $encodings, true) ?: ''
        );

    }

    /**
     * ### List of all supported encodings
     * @since 1.0.0
     *
     * @return non-empty-list<non-empty-string> Returns a numerically indexed array of all available encodings.
     */
    public static function listEncodings ():array {

        return mb_list_encodings();

    }

}