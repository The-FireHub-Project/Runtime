<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=7.0
 * @package Runtime
 */

namespace FireHub\Runtime\Str\SB;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function str_ireplace;
use function str_replace;
use function strtr;
use function substr_replace;

/**
 * ### PHP Single-Byte String Runtime Wrapper Utility - Replace
 *
 * Provides runtime wrappers for replacing, substituting, and transforming portions of single-byte string data using
 * direct character and substring replacement operations while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for single-byte string replacement
 * operations without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Replace extends NativeRuntime {

    /**
     * ### Replace all occurrences of the search string with the replacement string
     *
     * This function returns a string or an array with all occurrences of search in a subject replaced with the given
     * replacement value.
     * @since 1.0.0
     *
     * @param string|list<string> $search <p>
     * The string being searched and replaced on.
     * </p>
     * @param string|list<string> $replace <p>
     * The replacement value that replaces found search values.
     *
     * An array may be used to designate multiple replacements.
     * </p>
     * @param string $string <p>
     * The value being searched for.
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Searched values are case-sensitive.
     * </p>
     * @param null|int &$count [optional] <p>
     * If passed, this will hold the number of matched and replaced needles.
     * </p>
     * @param-out int $count
     *
     * @return string String with the replaced values.
     *
     * @note Because the method replaces left to right, it might replace a previously inserted value when doing
     * multiple replacements.
     * @tip To replace text based on a pattern rather than a fixed string, use preg_replace().
     */
    public static function replace (string|array $search, string|array $replace, string $string, bool $case_sensitive = true, ?int &$count = null):string {

        if ($case_sensitive) return str_replace($search, $replace, $string, $count);

        return str_ireplace($search, $replace, $string, $count);

    }

    /**
     * ### Replace text within a portion of a string
     *
     * Replaces a copy of string delimited by the $offset and (optionally) $length parameters with the string given
     * in $replace parameter.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The input string.
     * </p>
     * @param string $replace <p>
     * The replacement string.
     * </p>
     * @param int $offset <p>
     * If the offset is non-negative, the replacing will begin at the into string.
     *
     * If offset is negative, the replacing will begin at the character from the end of the string.
     * </p>
     * @param null|int $length [optional] <p>
     * If given and is positive, it represents the length of the portion of string which is to be replaced.
     *
     * If it is negative, it represents the number of characters from the end of the string at which to stop replacing.
     *
     * If it is not given, then it will default to SB::length(string); in other words, end the replacing at the
     * end of the string.
     *
     * Of course, if the length is zero, then this function will have the effect of inserting $replace into string
     * at the given offset.
     * </p>
     *
     * @return string String with the replaced values.
     */
    public static function part (string $string, string $replace, int $offset, ?int $length = null):string {

        return substr_replace($string, $replace, $offset, $length);

    }

    /**
     * ### Translate characters or replace substrings
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being translated to.
     * </p>
     * @param array<non-empty-string, string> $replace_pairs <p>
     * An array of key-value pairs for translation.
     * </p>
     *
     * @return string The translated string.
     */
    public static function translate (string $string, array $replace_pairs):string {

        return strtr($string, $replace_pairs);

    }

}