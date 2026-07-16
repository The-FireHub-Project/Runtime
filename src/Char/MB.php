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

namespace FireHub\Runtime\Char;

use FireHub\Runtime\Str;
use FireHub\Core\Type\Str\Encoding;

use function mb_chr;
use function mb_ord;

/**
 * ### PHP Multibyte Character Runtime Wrapper Utility - MB
 *
 * Provides runtime wrappers for multibyte character operations using PHP multibyte string functions.
 *
 * This component provides encoding-aware character processing, including Unicode-compatible inspection,
 * conversion, and transformation operations for multibyte string data.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for multibyte character
 * processing while preserving native PHP behavior, encoding support, and runtime performance.
 * @since 1.0.0
 */
final class MB {

    /**
     * ### Return character by Unicode code point value
     *
     * Returns a string containing the character specified by the Unicode code point value, encoded in the specified
     * encoding.
     *
     * This function complements Char\MB::ord().
     * @since 1.0.0
     *
     * @see https://en.wikipedia.org/wiki/List_of_Unicode_characters List of codepoint values
     *
     * @param int $codepoint <p>
     * The codepoint value.
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return string|false A string containing the requested character if it can be represented in the specified
     * encoding or false on failure.
     */
    public static function chr (int $codepoint, ?Encoding $encoding = null):string|false {

        return mb_chr($codepoint, $encoding?->value);

    }

    /**
     * ### Get Unicode code point of character
     *
     * Returns the Unicode code point value of the given character.
     *
     * This function complements Char\MB::chr().
     * @since 1.0.0
     *
     * @see https://en.wikipedia.org/wiki/List_of_Unicode_characters List of codepoint values
     *
     * @param string $character <p>
     * A character.
     * - Empty string is treated as NUL ("\0")
     * - Strings longer than one character are truncated to the first character
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>.
     *
     * @return non-negative-int|false The Unicode code point for the first character of string.
     */
    public static function ord (string $character, ?Encoding $encoding = null):int|false {

        /** @var non-negative-int|false */
        return mb_ord($character ?: "\0", $encoding?->value);

    }

}