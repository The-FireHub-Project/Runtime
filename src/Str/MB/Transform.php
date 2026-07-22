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
use FireHub\Core\Meta\Enum\Side;
use FireHub\Runtime\Exception\ {
    EmptyPadException, EncodingConversionFailedException
};

use const STR_PAD_BOTH;
use const STR_PAD_LEFT;
use const STR_PAD_RIGHT;

use function mb_convert_encoding;
use function mb_ltrim;
use function mb_rtrim;
use function mb_str_pad;
use function mb_trim;

/**
 * ### PHP Multibyte String Runtime Wrapper Utility - Transform
 *
 * Provides runtime wrappers for transforming multibyte string data using encoding-aware character manipulation
 * operations while preserving native PHP multibyte behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for multibyte string
 * transformation operations with support for Unicode-aware character processing.
 * @since 1.0.0
 */
final class Transform extends NativeRuntime {

    /**
     * ### Pad a multibyte string to a certain length with another multibyte string
     *
     * This method returns the $string padded on the left, the right, or both sides to the specified padding length.
     *
     * If the optional argument $pad is not supplied, the $string is padded with spaces; otherwise it is padded with
     * characters from $pad up to the limit.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Meta\Enum\Side::RIGHT If padding string to the right.
     * @uses \FireHub\Core\Meta\Enum\Side::LEFT If padding string to the left.
     * @uses \FireHub\Core\Meta\Enum\Side::BOTH If padding string on the both sides.
     *
     * @param string $string <p>
     * The string being padded.
     * </p>
     * @param int $length <p>
     * If the value of $length is negative, less than, or equal to the length of the input string, no padding takes
     * place.
     * </p>
     * @param non-empty-string $pad [optional] <p>
     * The pad may be truncated if the required number of padding characters can't be evenly divided by the pad's
     * length.
     * </p>
     * @param \FireHub\Core\Meta\Enum\Side $side [optional] <p>
     * Pad side.
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\EmptyPadException If the pad is empty.
     *
     * @return string Padded string.
     */
    public static function pad (string $string, int $length, string $pad = ' ', Side $side = Side::RIGHT, ?Encoding $encoding = null):string {

        if ($pad === '') throw new EmptyPadException;

        return mb_str_pad(
            $string,
            $length,
            $pad,
            match ($side) {
                Side::LEFT => STR_PAD_LEFT,
                Side::RIGHT => STR_PAD_RIGHT,
                Side::BOTH => STR_PAD_BOTH,
            },
            $encoding?->value
        );

    }

    /**
     * ### Strip whitespace (or other characters) from the beginning and end of a string
     *
     * Performs a multibyte safe StrSB#trim() operation and returns a string with whitespace stripped from
     * the beginning and end of the string.
     *
     * Without the second parameter, StrMB#trim() will strip these characters:
     *
     * - " " (Unicode U+0020), an ordinary space.
     * - "\t" (Unicode U+0009), a tab.
     * - "\n" (Unicode U+000A), a new line (line feed).
     * - "\r" (Unicode U+000D), a carriage return.
     * - "\0" (Unicode U+0000), the NUL-byte.
     * - "\v" (Unicode U+000B), a vertical tab.
     * - "\f" (Unicode U+000C), a form feed.
     * - "\u00A0" (Unicode U+00A0), a NO-BREAK SPACE.
     * - "\u1680" (Unicode U+1680), an OGHAM SPACE MARK.
     * - "\u2000" (Unicode U+2000), an EN QUAD.
     * - "\u2001" (Unicode U+2001), an EM QUAD.
     * - "\u2002" (Unicode U+2002), an EN SPACE.
     * - "\u2003" (Unicode U+2003), an EM SPACE.
     * - "\u2004" (Unicode U+2004), a THREE-PER-EM SPACE.
     * - "\u2005" (Unicode U+2005), a FOUR-PER-EM SPACE.
     * - "\u2006" (Unicode U+2006), a SIX-PER-EM SPACE.
     * - "\u2007" (Unicode U+2007), a FIGURE SPACE.
     * - "\u2008" (Unicode U+2008), a PUNCTUATION SPACE.
     * - "\u2009" (Unicode U+2009), a THIN SPACE.
     * - "\u200A" (Unicode U+200A), a HAIR SPACE.
     * - "\u2028" (Unicode U+2028), a LINE SEPARATOR.
     * - "\u2029" (Unicode U+2029), a PARAGRAPH SEPARATOR.
     * - "\u202F" (Unicode U+202F), a NARROW NO-BREAK SPACE.
     * - "\u205F" (Unicode U+205F), a MEDIUM MATHEMATICAL SPACE.
     * - "\u3000" (Unicode U+3000), a IDEOGRAPHIC SPACE.
     * - "\u0085" (Unicode U+0085), a NEXT LINE (NEL).
     * - "\u180E" (Unicode U+180E), a MONGOLIAN VOWEL SEPARATOR.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Meta\Enum\Side::BOTH If trimming string on the both sides.
     * @uses \FireHub\Core\Meta\Enum\Side::LEFT If trimming string on the left side.
     * @uses \FireHub\Core\Meta\Enum\Side::RIGHT If trimming string on the right side.
     *
     * @param string $string <p>
     * The string that will be trimmed.
     * </p>
     * @param \FireHub\Core\Meta\Enum\Side $side [optional] <p>
     * Side to trim string.
     * </p>
     * @param null|string $characters [optional] <p>
     * Optionally, the stripped characters can also be specified using the character parameter.<br>
     * List all characters that need to be stripped.
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Character encoding. If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return string The trimmed string.
     */
    public static function trim (string $string, Side $side = Side::BOTH, ?string $characters = null, ?Encoding $encoding = null):string {

        return match($side) {
            Side::LEFT => mb_ltrim($string, $characters, $encoding?->value),
            Side::RIGHT => mb_rtrim($string, $characters, $encoding?->value),
            Side::BOTH => mb_trim($string, $characters, $encoding?->value)
        };

    }

    /**
     * ### Convert a string from one character encoding to another
     *
     * Converts string from $from, or the current internal encoding, to $to.
     *
     * If a string is an array, all its $string values will be converted recursively.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Type\Str\Encoding As converted encoding.
     *
     * @param string $string <p>
     * The string to be converted.
     * </p>
     * @param \FireHub\Core\Type\Str\Encoding $to <p>
     * The desired encoding of the result.
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $from [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\EncodingConversionFailedException If the conversion fails.
     *
     * @return string Encoded string.
     */
    public static function convertEncoding (string $string, Encoding $to, ?Encoding $from = null):string {

        return mb_convert_encoding($string, $to->value, $from?->value)
            ?: throw new EncodingConversionFailedException;

    }

}