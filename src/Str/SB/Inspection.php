<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=7.4
 * @package Runtime
 */

namespace FireHub\Runtime\Str\SB;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function crc32;
use function strlen;

/**
 * ### PHP Byte-Oriented String Runtime Wrapper Utility - Inspection
 *
 * Provides runtime wrappers for inspecting byte-oriented string data, including string length, checksum calculation,
 * and other string metadata operations while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for byte-oriented string
 * inspection operations without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Inspection extends NativeRuntime {

    /**
     * ### Get string length
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being measured for length.
     * </p>
     *
     * @return non-negative-int String length.
     *
     * @note The function returns the number of bytes rather than the number of characters in a string.
     */
    public static function length (string $string):int {

        return strlen($string);

    }

    /**
     * ### Calculates the crc32 polynomial of a string
     * @since 1.0.0
     *
     * @param string $string <p>
     * The data.
     * </p>
     *
     * @return int crc32 checksum of string as an integer.
     */
    public static function crc32 (string $string):int {

        return crc32($string);

    }

}