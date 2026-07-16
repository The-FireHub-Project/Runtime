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
use FireHub\Runtime\Exception\StringSplitLengthException;

use function str_split;
use function strpbrk;
use function strrchr;
use function stristr;
use function strstr;
use function substr;
use function substr_count;

/**
 * ### PHP Byte-Oriented String Runtime Wrapper Utility - Access
 *
 * Provides runtime wrappers for accessing byte-oriented string data, including byte positions, character extraction,
 * and direct string element access while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for byte-oriented string access
 * operations without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Access extends NativeRuntime {

    /**
     * ### Get part of string
     *
     * Returns the portion of the string specified by the $start and $length parameters.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to extract the substring from.
     * </p>
     * @param int $start <p>
     * If start is non-negative, the returned string will start at the start position in string, counting from zero.
     * For instance, in the string 'FireHub', the character at position 0 is 'F', the character at position 2 is 'r',
     * and so forth.
     *
     * If the start is negative, the returned string will start at the start character from the end of the string.
     * </p>
     * @param null|int $length [optional] <p>
     * Maximum number of characters to use from string.
     *
     * If omitted or NULL is passed, extract all characters to the end of the string.
     * </p>
     *
     * @return ($string is empty ? '' : string) The portion of string specified by the start and length parameters.
     */
    public static function part (string $string, int $start, ?int $length = null):string {

        return substr($string, $start, $length);

    }

    /**
     * ### Get the number of times the searched substring occurs in the string
     *
     * Returns the number of times the needle substring occurs in the haystack string.
     *
     * Note that the needle is case-sensitive.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being checked.
     * </p>
     * @param string $search <p>
     * The string being found.
     * </p>
     * @param int $start [optional] <p>
     * The offset is where to start counting.
     *
     * If the offset is negative, counting starts from the end of the string.
     * </p>
     * @param null|int $length [optional] <p>
     * The maximum length after the specified offset to search for the substring.
     *
     * It outputs a warning if the offset plus the length is greater than the $string length.
     *
     * A negative length counts from the end of $string.
     * </p>
     *
     * @return non-negative-int The number of times the searched substring occurs in the string.
     *
     * @note This method doesn't count overlapped substring.
     */
    public static function partCount (string $string, string $search, int $start = 0, ?int $length = null):int {

        return substr_count($string, $search, $start, $length);

    }

    /**
     * ### Find part of a string with characters
     * @since 1.0.0
     *
     * @param string $characters <p>
     * Characters to find. This parameter is case-sensitive.
     * </p>
     * @param string $string <p>
     * The string where characters are looked for.
     * </p>
     *
     * @return ($string is empty ? '' : non-falsy-string)|false String starting from the character found, or false if it
     * is not found.
     */
    public static function firstCharacterFrom (string $characters, string $string):string|false {

        return strpbrk($string, $characters);

    }

    /**
     * ### Finds the last occurrence of any character from $find within in a string
     *
     * This function finds the last occurrence of a $find in the $string and returns the portion of $string.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being searched.
     * </p>
     * @param string $character <p>
     * Character to find.
     * </p>
     * @param bool $before_needle [optional] <p>
     * If true, return the part of the string before the last occurrence (excluding the find string).
     * </p>
     *
     * @return ($string is empty ? '' : non-falsy-string)|false The portion of string, or false if the $find
     * is not found.
     */
    public static function lastCharacter (string $string, string $character, bool $before_needle = false):string|false {

        return strrchr($string, $character, $before_needle);

    }

    /**
     * ### Find the first occurrence of a string
     *
     * Returns part of $string starting from and including the first occurrence of $find to the end of $string.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being searched.
     * </p>
     * @param string $find <p>
     * String to find.
     * </p>
     * @param bool $before_needle [optional] <p>
     * If true, return the part of the string before the first occurrence (excluding the find string).
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Searched values are case-sensitive.
     * </p>
     *
     * @return ($string is empty ? '' : non-falsy-string)|false The portion of string or false if the $find
     * is not found.
     */
    public static function firstOccurrence (string $string, string $find, bool $before_needle = false, bool $case_sensitive = true):string|false {

        if ($case_sensitive) return strstr($string, $find, $before_needle);

        return stristr($string, $find, $before_needle);

    }

    /**
     * ### Convert a string to an array
     * @since 1.0.0
     *
     * @param string $string <p>
     * The input string.
     * </p>
     * @param positive-int $length [optional] <p>
     * Maximum length of the chunk.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\StringSplitLengthException If the $length parameter is less than 1.
     *
     * @return list<non-empty-string> If the optional $length parameter is specified, the returned array will be broken
     * down into chunks with each being $length in length, except the final chunk which may be shorter if the string
     * doesn't divide evenly.
     *
     * The default $length is 1, meaning every chunk will be one byte in size.
     */
    public static function split (string $string, int $length = 1):array {

        return $length >= 1
            ? str_split($string, $length)
            : throw new StringSplitLengthException(
                'The split length must be greater than zero.',
                [
                    'string' => $string,
                    'length' => $length,
                    'minimum' => 1,
                ]
            );

    }

}