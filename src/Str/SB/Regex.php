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

namespace FireHub\Runtime\Str\SB;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Exception\InvalidPatternException;

use function preg_match;
use function preg_match_all;
use function preg_replace;
use function preg_replace_callback;
use function preg_split;
use function preg_quote;

/**
 * ### Regular Expression Utilities
 *
 * Provides low-level wrappers for matching, replacing, splitting, and escaping strings using PHP's native PCRE
 * regular expression engine while preserving native runtime behavior.
 * @since 1.0.0
 */
final class Regex extends NativeRuntime {

    /**
     * ### Perform a regular expression match
     *
     * Searches subject for a match to the regular expression given in a pattern.
     * @since 1.0.0
     *
     * @param string $pattern <p>
     * The regular expression pattern.
     * </p>
     * @param string $string <p>
     * The string being evaluated.
     * </p>
     * @param int $offset [optional] <p>
     * Normally, the search starts from the beginning of the subject string.
     *
     * The optional parameter offset can be used to specify the alternate place from which to start the search (in
     * bytes).
     * </p>
     * @param bool $all [optional] <p>
     * If true, search subject for a match to the regular expression given in a pattern.
     * </p>
     * @param null|string[] &$result [optional] <p>
     * Regular expressions match the result.
     * </p>
     * @param-out array<string>|array<array<int, string>> $result
     *
     * @throws \FireHub\Runtime\Exception\InvalidPatternException If the regular expression pattern is invalid.
     *
     * @return bool True if the string matches the regular expression pattern, false if not.
     *
     * @warning This function may return Boolean false but may also return a non-Boolean value which evaluates to false.
     * Read the section on Booleans for more information.
     * Use the === operator for testing the return value of this function.
     */
    public static function match (string $pattern, string $string, int $offset = 0, bool $all = false, ?array &$result = null):bool {

        $match = $all
            ? preg_match_all($pattern, $string, $result, offset: $offset)
            : preg_match($pattern, $string, $result, offset: $offset);

        return $match === false
            ? throw new InvalidPatternException
            : $match !== 0;

    }

    /**
     * ### Perform a regular expression search and replace
     *
     * Searches $subject for matches to $pattern and replaces them with $replacement.
     * @since 1.0.0
     *
     * @param string $pattern <p>
     * The regular expression pattern.
     * </p>
     * @param string $replacement <p>
     * The string to replace.
     * </p>
     * @param string $string <p>
     * The string being evaluated.
     * </p>
     * @param int $limit [optional] <p>
     * The maximum possible replacements for each pattern in each subject string.
     *
     * Defaults to -1 (no limit).
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidPatternException If error while performing a regular expression,
     * search and replace.
     *
     * @return string Replaced string.
     */
    public static function replace (string $pattern, string $replacement, string $string, int $limit = -1):string {

        return preg_replace($pattern, $replacement, $string, $limit)
            ?? throw new InvalidPatternException;

    }

    /**
     * ### Perform a regular expression search and replace using a callback
     *
     * Searches $subject for matches to $pattern and replaces them with $replacement.
     * @since 1.0.0
     *
     * @param string $pattern <p>
     * The regular expression pattern.
     * </p>
     * @param callable(array<array-key, string> $matches):string $callback <p>
     * A callback that will be called and passed an array of matched elements in the subject string.
     *
     * The callback should return the replacement string.
     *
     * This is the callback signature.
     * </p>
     * @param string $string <p>
     * The string being evaluated.
     * </p>
     * @param int $limit [optional] <p>
     * The maximum possible replacements for each pattern in each subject string.
     *
     * Defaults to -1 (no limit).
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidPatternException If error while performing a regular expression,
     * search and replace.
     *
     * @return string Replaced string.
     */
    public static function replaceUsing (string $pattern, callable $callback, string $string, int $limit = -1):string {

        return preg_replace_callback($pattern, $callback, $string, $limit)
            ?? throw new InvalidPatternException;

    }

    /**
     * ### Split string by a regular expression
     *
     * Split the given string by a regular expression.
     * @since 1.0.0
     *
     * @param string $pattern <p>
     * The regular expression pattern.
     * </p>
     * @param string $string <p>
     * The input string.
     * </p>
     * @param int $limit [optional] <p>
     * The maximum possible replacements for each pattern in each subject string.
     *
     * Defaults to -1 (no limit).
     * </p>
     * @param bool $remove_empty [optional] <p>
     * If true, only non-empty pieces will be returned.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidPatternException If error while performing a regular expression split.
     *
     * @return list<string> Array containing substrings of $string split along boundaries matched by $pattern.
     */
    public static function split (string $pattern, string $string, int $limit = -1, bool $remove_empty = false):array {

        return preg_split($pattern, $string, $limit, $remove_empty ? PREG_SPLIT_NO_EMPTY : 0)
            ?: throw new InvalidPatternException;

    }

    /**
     * ### Quote regular expression characters
     *
     * Method takes string and puts a backslash in front of every character that is part of the regular expression
     * syntax.
     *
     * This is useful if you have a runtime string that you need to match in some text and the string may contain
     * special regex characters.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The input string.
     * </p>
     * @param null|string $delimiter [optional] <p>
     * If the optional delimiter is specified, it will also be escaped.
     *
     * This is useful for escaping the delimiter required by the PCRE functions.
     *
     * The / is the most commonly used delimiter.
     * </p>
     *
     * @return string The quoted (escaped) string.
     */
    public static function quote (string $string, ?string $delimiter = null):string {

        return preg_quote($string, $delimiter);

    }

}