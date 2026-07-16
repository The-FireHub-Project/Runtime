<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.0
 * @package Runtime
 */

namespace FireHub\Runtime\Str\SB;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function str_contains;
use function str_ends_with;
use function str_starts_with;
use function stripos;
use function strpos;
use function strripos;
use function strrpos;
use function strcspn;
use function strspn;

/**
 * ### PHP Single-Byte String Runtime Wrapper Utility - Search
 *
 * Provides runtime wrappers for searching within single-byte string data, including substring lookup, character
 * occurrence detection, position retrieval, and string matching operations while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for byte-oriented string search
 * operations without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Search extends NativeRuntime {

    /**
     * ### Checks if a string contains a value
     *
     * Performs a case-sensitive check indicating if $string is contained in $string.
     * @since 1.0.0
     *
     * @param string $value <p>
     * The value to search for.
     * </p>
     * @param string $string <p>
     * The string to search in.
     * </p>
     *
     * @return bool True if a string contains a value, false otherwise.
     */
    public static function contains (string $value, string $string):bool {

        return str_contains($string, $value);

    }

    /**
     * ### Checks if a string starts with a given value
     *
     * Performs a case-sensitive check indicating if $string begins with $value.
     * @since 1.0.0
     *
     * @param string $value <p>
     * The value to search for.
     * </p>
     * @param string $string <p>
     * The string to search in.
     * </p>
     *
     * @return bool True if the string starts with value, false otherwise.
     */
    public static function startsWith (string $value, string $string):bool {

        return str_starts_with($string, $value);

    }

    /**
     * ### Checks if a string ends with a given value
     *
     * Performs a case-sensitive check indicating if $string ends with $value.
     * @since 1.0.0
     *
     * @param string $value <p>
     * The value to search for.
     * </p>
     * @param string $string <p>
     * The string to search in.
     * </p>
     *
     * @return bool True if the string ends with value, false otherwise.
     */
    public static function endsWith (string $value, string $string):bool {

        return str_ends_with($string, $value);

    }

    /**
     * ### Find the position of the first occurrence of a substring in a string
     * @since 1.0.0
     *
     * @param string $search <p>
     * A string to find position.
     * </p>
     * @param string $string <p>
     * The string to search in.
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Search case-sensitive position.
     * </p>
     * @param int $offset [optional] <p>
     * If specified, search will start this number of characters counted from the beginning of the string.
     * </p>
     *
     * @return non-negative-int|false Numeric position of the first occurrence or false if none exist.
     *
     * @warning This function may return Boolean false but may also return a non-Boolean value which evaluates to false.
     * Read the section on Booleans for more information.
     * Use the === operator for testing the return value of this function.
     */
    public static function firstPosition (string $search, string $string, bool $case_sensitive = true, int $offset = 0):int|false {

        if ($case_sensitive) return strpos($string, $search, $offset);

        return stripos($string, $search, $offset);

    }

    /**
     * ### Find the position of the last occurrence of a substring in a string
     * @since 1.0.0
     *
     * @param string $search <p>
     * A string to find position.
     * </p>
     * @param string $string <p>
     * The string to search in.
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Search case-sensitive position.
     * </p>
     * @param int $offset [optional] <p>
     * If specified, search will start this number of characters counted from the beginning of the string.
     * </p>
     *
     * @return non-negative-int|false Numeric position of the last occurrence or false if none exist.
     *
     * @warning This function may return Boolean false but may also return a non-Boolean value which evaluates to false.<br>
     * Read the section on Booleans for more information.
     * Use the === operator for testing the return value of this function.
     */
    public static function lastPosition (string $search, string $string, bool $case_sensitive = true, int $offset = 0):int|false {

        if ($case_sensitive)
            /** @var non-negative-int|false */
            return strrpos($string, $search, $offset);

        /** @var non-negative-int|false */
        return strripos($string, $search, $offset);

    }

    /**
     * ### Length of the initial segment for a string consisting entirely of characters contained within a given mask
     *
     * Finds the length of the initial segment for $string that contains only characters from $characters.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to examine.
     * </p>
     * @param string $characters <p>
     * The list of allowable characters.
     * </p>
     * @param int $offset [optional] <p>
     * The position in a subject to start searching.
     *
     * If start is given and is non-negative, then Seach#segmentMatching() will begin examining the subject at
     * the start position.
     *
     * For instance, in the string 'abcdef', the character at position 0 is 'a', the character at position 2 is 'c',
     * and so forth.
     *
     * If start is given and is negative, then Seach#segmentMatching() will begin examining the subject at the start
     * position from the end of a subject.
     * </p>
     * @param int|null $length [optional] <p>
     * The length of the segment from the subject to examine.
     *
     * If length is given and is non-negative, then the subject will be examined for length characters after the
     * starting position.
     *
     * If length is given and is negative, then the subject will be examined from the starting position up-to-length
     * characters from the end of the subject.
     * </p>
     *
     * @return non-negative-int The length of the initial segment for string which consists entirely of characters in
     * characters.
     *
     * @note When the offset parameter is set, the returned length is counted starting from this position, not from
     * beginning of the string.
     */
    public static function segmentLength (string $string, string $characters, int $offset = 0, ?int $length = null):int {

        return strspn($string, $characters, $offset, $length);

    }

    /**
     * ### Find length of the initial segment not matching mask
     *
     * Returns the length of the initial segment for $string which doesn't contain any of the characters in $characters.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to examine.
     * </p>
     * @param string $characters <p>
     * The string containing every disallowed character.
     * </p>
     * @param int $offset [optional] <p>
     * The position in a subject to start searching.
     *
     * If start is given and is non-negative, then Seach#segmentNotMatching() will begin examining the subject at
     * the start position.
     *
     * For instance, in the string 'abcdef', the character at position 0 is 'a', the character at position 2 is 'c',
     * and so forth.
     *
     * If start is given and is negative, then Search#segmentNotMatching() will begin examining the subject at the
     * start position from the end of a subject.
     * </p>
     * @param null|int $length [optional] <p>
     * The length of the segment from the subject to examine
     *
     * If length is given and is non-negative, then the subject will be examined for length characters after the
     * starting position.
     *
     * If length is given and is negative, then the subject will be examined from the starting position up-to-length
     * characters from the end of the subject.
     * </p>
     *
     * @return non-negative-int The length of the initial segment from string which consists entirely of characters not
     * in characters.
     *
     * @note When the offset parameter is set, the returned length is counted starting from this position, not from
     * beginning of the string.
     */
    public static function segmentNotLength (string $string, string $characters, int $offset = 0, ?int $length = null):int {

        return strcspn($string, $characters, $offset, $length);

    }

}