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
use FireHub\Core\Foundation\Constant\Numeric\IntegerLimits;
use FireHub\Runtime\Exception\EmptySeparatorException;

use function explode;
use function implode;

/**
 * ### PHP String Runtime Wrapper Utility - Delimiter
 *
 * Provides runtime wrappers for splitting strings into arrays and joining arrays of strings into a single string
 * using delimiter-based operations while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for string segmentation and
 * concatenation operations without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Delimiter extends NativeRuntime {

    /**
     * ### Join array elements with a string
     *
     * Join array elements with a $separator string.
     * @since 1.0.0
     *
     * @param array<array-key, null|scalar|\Stringable> $array <p>
     * The array of strings to implode.
     * </p>
     * @param string $separator [optional] <p>
     * The boundary string.
     * </p>
     *
     * @return string Returns a string containing a string representation of all the array elements in the same order,
     * with the separator string between each element.
     */
    public static function implode (array $array, string $separator = ''):string {

        return implode($separator, $array);

    }

    /**
     * ### Split a string by a string
     *
     * Returns an array of strings, each of which is a substring of string formed by splitting it on boundaries
     * formed by the string separator.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The input string.
     * </p>
     * @param non-empty-string $separator <p>
     * The boundary string.
     * </p>
     * @param int<min, max> $limit [optional] <p>
     * If the limit is set and positive, the returned array will contain a maximum of limit elements with the last
     * element containing the rest of the string.
     *
     * If the limit parameter is negative, all components except the last – limit are returned.
     *
     * If the limit parameter is zero, then this is treated as 1.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\EmptySeparatorException If the separator is an empty string.
     *
     * @return ($string is empty ? list<string> : non-empty-list<string>) If a delimiter contains a value not contained
     * in string, and a negative limit is used, then an empty array will be returned. For any other limit, an array
     * containing a string will be returned.
     */
    public static function explode (string $string, string $separator, int $limit = IntegerLimits::MAX):array {

        if ($separator === '') throw new EmptySeparatorException;

        return explode($separator, $string, $limit);

    }

}