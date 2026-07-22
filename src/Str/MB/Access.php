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
use FireHub\Core\Type\Str\Encoding;
use FireHub\Runtime\Exception\StringSplitLengthException;

use function mb_str_split;
use function mb_strrchr;
use function mb_strrichr;
use function mb_stristr;
use function mb_strstr;
use function mb_substr;
use function mb_substr_count;

/**
 * ### PHP Multibyte String Runtime Wrapper Utility - Access
 *
 * Provides runtime wrappers for accessing multibyte string data, including character positions, character extraction,
 * and encoding-aware string element access while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for multibyte string access
 * operations without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Access extends NativeRuntime {

    /**
     * ### Get part of string
     *
     * Performs a multibyte safe StrSB#part() operation based on the number of characters.
     * Position is counted from the beginning of $string.
     * The first character's position is 0.
     * The second character's position is 1, and so on.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to extract the substring from.
     * </p>
     * @param int $start <p>
     * If start is non-negative, the returned string will start at the start position in string, counting from zero.<br>
     * For instance, in the string 'abcdef', the character at position 0 is 'a', the character at position 2 is 'c',
     * and so forth.
     *
     * If the start is negative, the returned string will start at the start character from the end of the string.
     * </p>
     * @param null|int $length [optional] <p>
     * Maximum number of characters to use from string.
     * If omitted or NULL is passed, extract all characters to the end of the string.
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return string The portion of string specified by the start and length parameters.
     */
    public static function part (string $string, int $start, ?int $length = null, ?Encoding $encoding = null):string {

        return mb_substr($string, $start, $length, $encoding?->value);

    }

    /**
     * ### Get the number of times the searched substring occurs in the string
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being checked.
     * </p>
     * @param string $search <p>
     * The string being found.
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return non-negative-int The number of times the searched substring occurs in the string.
     */
    public static function partCount (string $string, string $search, ?Encoding $encoding = null):int {

        return mb_substr_count($string, $search, $encoding?->value);

    }

    /**
     * ### Finds the last occurrence of a character in a string within another
     *
     * This function finds the last occurrence of a $find in the $string and returns the portion of $string.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being searched.
     * </p>
     * @param string $character <p>
     * String to find.
     * </p>
     * @param bool $before_needle [optional] <p>
     * If true, return the part of the string before the last occurrence (excluding the find string).
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Is string to find case-sensitive or not.
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return string|false The portion of string, or false if the $find is not found.
     */
    public static function lastCharacter (string $string, string $character, bool $before_needle = false, bool $case_sensitive = true, ?Encoding $encoding = null):string|false {

        if ($case_sensitive) return mb_strrchr($string, $character, $before_needle, $encoding?->value);

        return mb_strrichr($string, $character, $before_needle, $encoding?->value);

    }

    /**
     * ### Find the first occurrence of a string
     *
     * Returns part of $string starting from and including the first occurrence of $find to the end of $string.
     * @since 1.0.0
     *
     * @param string $find <p>
     * String to find.
     * </p>
     * @param string $string <p>
     * The string being searched.
     * </p>
     * @param bool $before_needle [optional] <p>
     * If true, return the part of the string before the first occurrence (excluding the find string).
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Is string to find case-sensitive or not.
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return string|false The portion of string or false if the $find is not found.
     */
    public static function firstOccurrence (string $string, string $find, bool $before_needle = false, bool $case_sensitive = true, ?Encoding $encoding = null):string|false {

        if ($case_sensitive) return mb_strstr($string, $find, $before_needle, $encoding?->value);

        return mb_stristr($string, $find, $before_needle, $encoding?->value);

    }

    /**
     * ### Given a multibyte string, return an array of its characters
     *
     * This function will return an array of strings, it is a version of StrSB#split() with support for encodings of
     * variable character size as well as fixed-size encodings of 1,2 or 4 byte characters.
     *
     * If the $length parameter is specified, the string is broken down into chunks of the specified length in
     * characters (not bytes).
     *
     * The $encoding parameter can be optionally specified, and it is good practice to do so.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The input string.
     * </p>
     * @param positive-int $length [optional] <p>
     * Maximum length of the chunk.
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\StringSplitLengthException If the $length parameter is less than 1.
     *
     * @return list<non-empty-string> If the optional $length parameter is specified, the returned array will be broken
     * down into chunks with each being $length in length, except the final chunk, which may be shorter if the string
     * doesn't divide evenly.
     *
     * The default $length is 1, meaning every chunk will be one character in size.
     */
    public static function split (string $string, int $length = 1, ?Encoding $encoding = null):array {

        return $length >= 1
            ? mb_str_split($string, $length, $encoding?->value)
            : throw new StringSplitLengthException(
                'The split length must be greater than zero.',
                [
                    'string' => $string,
                    'length' => $length,
                    'encoding' => $encoding?->value,
                    'minimum' => 1,
                ]
            );

    }

}