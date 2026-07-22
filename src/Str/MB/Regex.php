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

namespace FireHub\Runtime\Str\MB;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Core\Type\Str\Encoding;
use FireHub\Runtime\Exception\ {
    InvalidEncodingException, InvalidPatternException
};

use function mb_ereg;
use function mb_ereg_replace;
use function mb_ereg_replace_callback;
use function mb_eregi;
use function mb_eregi_replace;
use function mb_regex_encoding;
use function mb_split;

/**
 * ### Multibyte Regular Expression Utilities
 *
 * Provides low-level wrappers for multibyte regular expression operations using PHP's mbstring regular expression
 * functions while preserving native runtime behavior.
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
     * @param bool $case_sensitive [optional] <p>
     * Case-sensitive match.
     * </p>
     * @param mixed &$result [optional] <p>
     * Case-sensitive match.
     * </p>
     * @param-out list<string> $result
     *
     * @return bool True if the string matches the regular expression pattern, false if not.
     */
    public static function match (string $pattern, string $string, bool $case_sensitive = true, mixed &$result = null):bool {

        return $case_sensitive
            ? mb_ereg($pattern, $string, $result) // @phpstan-ignore paramOut.type
            : mb_eregi($pattern, $string, $result); // @phpstan-ignore paramOut.type

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
     * @param bool $case_sensitive [optional] <p>
     * Case-sensitive replace type.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidPatternException If an error occurred while performing a regular
     * expression search and replace type.
     * @throws \FireHub\Runtime\Exception\InvalidEncodingException If string is not valid for the current encoding.
     *
     * @return string Replaced string.
     *
     * @warning Never use the e modifier when working on untrusted input.
     * No automatic escaping will happen (as known from RegexMB#replace()).
     * Not taking care of this will most likely create remote code execution vulnerabilities in your application.
     * @note The internal encoding or the character encoding specified by encoding() will be used as character
     * encoding for this function.
     */
    public static function replace (string $pattern, string $replacement, string $string, bool $case_sensitive = true):string {

        $replaced = ($case_sensitive
            ? mb_ereg_replace($pattern, $replacement, $string)
            : mb_eregi_replace($pattern, $replacement, $string)
        );

        return $replaced !== false
            ? ($replaced ?? throw new InvalidEncodingException)
            : throw new InvalidPatternException;

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
     *
     * @throws \FireHub\Runtime\Exception\InvalidPatternException If an error occurred while performing a regular
     * expression search and replace type.
     * @throws \FireHub\Runtime\Exception\InvalidEncodingException If string is not valid for the current encoding.
     *
     * @return string Replaced string.
     */
    public static function replaceUsing (string $pattern, callable $callback, string $string):string {

        $replaced = mb_ereg_replace_callback($pattern, $callback, $string);

        return $replaced !== false
            ? ($replaced ?? throw new InvalidEncodingException)
            : throw new InvalidPatternException;

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
     *
     * @throws \FireHub\Runtime\Exception\InvalidPatternException If error while performing a regular expression split.
     *
     * @return list<string> Array containing substrings of $string split along boundaries matched by $pattern.
     */
    public static function split (string $pattern, string $string, int $limit = -1):array {

        return mb_split($pattern, $string, $limit)
            ?: throw new InvalidPatternException;

    }

    /**
     * ### Set/Get character encoding for multibyte regex
     * @since 1.0.0
     *
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidEncodingException If encoding is invalid or failed to get regex
     * encoding.
     *
     * @return ($encoding is null ? \FireHub\Core\Type\Str\Encoding : true) If encoding is set, then returns
     * true. In this case, the internal character encoding is NOT changed. If encoding is omitted, then the current
     * character encoding name for a multibyte regex is returned.
     */
    public static function encoding (?Encoding $encoding = null):true|Encoding {

        return match ($regex_encoding = mb_regex_encoding($encoding?->value)) {
            true => true,
            false => throw new InvalidEncodingException,
            default => Encoding::tryFrom($regex_encoding)
                ?? throw new InvalidEncodingException
        };

    }

}