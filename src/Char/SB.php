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

namespace FireHub\Runtime\Char;

use FireHub\Runtime\Exception\InvalidCharacterCodepointException;

use function chr;
use function ord;

/**
 * ### PHP Single-Byte Character Runtime Wrapper Utility - SB
 *
 * Provides low-level runtime wrappers for single-byte character operations using PHP native string behavior.
 *
 * This component operates directly on byte-oriented strings and provides access to character inspection,
 * conversion, and transformation operations without Unicode awareness.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for single-byte character
 * processing while preserving native PHP behavior, performance, and compatibility.
 * @since 1.0.0
 */
final class SB {

    /**
     * ### Generate a single-byte string from a number
     *
     * Returns a one-character string containing the character specified by interpreting $codepoint as an unsigned
     * integer.
     *
     * This can be used to create a one-character string in a single-byte encoding such as ASCII, ISO-8859, or
     * Windows 1252, by passing the position of a desired character in the encoding's mapping table.
     * However, note that this function is not aware of any string encoding, and in particular can't be passed a
     * Unicode code point value to generate a string in a multibyte encoding like UTF-8 or UTF-16.
     *
     * This function complements Char\SB::ord().
     * @since 1.0.0
     *
     * @see https://www.man7.org/linux/man-pages/man7/ascii.7.html List of codepoint values
     *
     * @param int<0, 255> $codepoint <p>
     * An integer between 0 and 255.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidCharacterCodepointException If the codepoint value is outside the
     * valid range (0..255).
     *
     * @return string A single-character string containing the specified byte.
     */
    public static function chr (int $codepoint):string {

        if ($codepoint < 0 || $codepoint > 255) {
            throw new InvalidCharacterCodepointException(
                'The character codepoint must be between 0 and 255 for single-byte characters.',
                [
                    'codepoint' => $codepoint,
                    'minimum' => 0,
                    'maximum' => 255,
                ]
            );
        }

        return chr($codepoint);

    }

    /**
     * ### Convert the first byte of a string to a value between 0 and 255
     *
     * Interprets the binary value of the first byte from $character as an unsigned integer between 0 and 255.
     * If the string is in a single-byte encoding, such as ASCII, ISO-8859, or Windows 1252, this is equivalent to
     * returning the position of a character in the character set's mapping table.
     *
     * However, note that this function is not aware of any string encoding, and in particular will never identify a
     * Unicode code point in a multibyte encoding such as UTF-8 or UTF-16.
     *
     * This function complements Char\SB::chr().
     * @since 1.0.0
     *
     * @see https://www.man7.org/linux/man-pages/man7/ascii.7.html List of codepoint values
     *
     * @param string $character <p>
     * A character.
     * - Empty string is treated as NUL ("\0")
     * - Strings longer than one byte are truncated to the first byte
     * </p>
     *
     * @return int<0, 255> An integer between 0 and 255.
     */
    public static function ord (string $character):int {

        return ord($character[0] ?? "\0");

    }

}