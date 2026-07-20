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

namespace FireHub\Runtime\Str\SB;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Core\Meta\Enum\Side;
use FireHub\Runtime\Exception\ {
    EmptyPadException, InvalidChunkLengthException
};

use const STR_PAD_BOTH;
use const STR_PAD_LEFT;
use const STR_PAD_RIGHT;

use function chunk_split;
use function ltrim;
use function rtrim;
use function sprintf;
use function str_pad;
use function str_repeat;
use function str_shuffle;
use function strrev;
use function trim;
use function wordwrap;

/**
 * ### PHP Single-Byte String Runtime Wrapper Utility - Transform
 *
 * Provides runtime wrappers for transforming single-byte string data using native PHP string manipulation operations
 * while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for single-byte string
 * transformation operations without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Transform extends NativeRuntime {

    /**
     * ### Repeat a string
     *
     * Returns string repeated with $times parameter.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string is to be repeated.
     * </p>
     * @param int $times <p>
     * Number of times the input string should be repeated.
     *
     * Multiplier has to be greater than or equal to 0.
     *
     * If the $times are set to 0 or less, the function will return an empty string.
     * </p>
     * @param string $separator [optional] <p>
     * Separator in between any repeated string.
     * </p>
     *
     * @return string Repeated string.
     *
     * @note If $times is less than 1, an empty string will be returned.
     */
    public static function repeat (string $string, int $times, string $separator = ''):string {

        return $times < 1 ? '' : str_repeat($string.$separator, $times - 1).$string;

    }

    /**
     * ### Pad a string to a certain length with another string
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
     *
     * @throws \FireHub\Runtime\Exception\EmptyPadException If the pad is empty.
     *
     * @return string Padded string.
     */
    public static function pad (string $string, int $length, string $pad = ' ', Side $side = Side::RIGHT):string {

        if ($pad === '') throw new EmptyPadException;

        return str_pad(
            $string,
            $length,
            $pad,
            match ($side) {
                Side::LEFT => STR_PAD_LEFT,
                Side::RIGHT => STR_PAD_RIGHT,
                Side::BOTH => STR_PAD_BOTH,
            }
        );

    }

    /**
     * ### Reverse a string
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to be reversed.
     * </p>
     *
     * @return ($string is empty ? '' : non-empty-string) The reversed string.
     */
    public static function reverse (string $string):string {

        return strrev($string);

    }

    /**
     * ### Randomly shuffles a string
     * @since 1.0.0
     *
     * @param string $string <p>
     * The input string.
     * </p>
     *
     * @return ($string is empty ? '' : non-empty-string) The shuffled string.
     *
     * @caution This function doesn't generate cryptographically secure values and mustn't be used for cryptographic
     * purposes, or purposes that require returned values to be unguessable.
     */
    public static function shuffle (string $string):string {

        return str_shuffle($string);

    }

    /**
     * ### Split a string into smaller chunks
     *
     * Can be used to split a string into smaller chunks, which is useful, for example, converting base64_encode()
     * output to match RFC 2045 semantics.
     *
     * It inserts $separator every $length characters.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to be chunked.
     * </p>
     * @param positive-int $length [optional] <p>
     * The chunk length.
     * </p>
     * @param string $separator [optional] <p>
     * The line-ending sequence.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidChunkLengthException If the length is less than 1.
     *
     * @return string The chunked string.
     */
    public static function chunkSplit (string $string, int $length = 76, string $separator = "\r\n"):string {

        if ($length < 1) {
            throw new InvalidChunkLengthException(
                'The length of each chunk must be a positive integer.',
                [
                    'length' => $length,
                    'minimum' => 1,
                ]
            );
        }

        return chunk_split($string, $length, $separator);

    }

    /**
     * ### Wraps a string to a given number of characters
     *
     * Wraps a string to a given number of characters using a string break character.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to warp.
     * </p>
     * @param int $width [optional] <p>
     * The column width.
     * </p>
     * @param string $break [optional] <p>
     * The line is broken using the optional break parameter.
     * </p>
     * @param bool $cut_long_words [optional] <p>
     * If the cut is set to true, the string is always wrapped at or before the specified width.
     *
     * So if you have a word that is larger than the given width, it is broken apart.
     * </p>
     *
     * @return string The given string wrapped at the specified column.
     */
    public static function wrap (string $string, int $width = 75, string $break = "\n", bool $cut_long_words = false):string {

        return wordwrap($string, $width, $break, $cut_long_words);

    }

    /**
     * ### Return a formatted string
     *
     * Returns a string produced according to the formatting string $format.
     * @since 1.0.0
     *
     * @param string $format <p>
     * String is composed of zero or more directives: ordinary characters (excluding %) that are copied directly to
     * the result and conversion specifications, each of which results in fetching its own parameter.
     *
     * A conversion specification follows this prototype: %[argnum$][flags][width][.precision]specifier.
     * </p>
     * @param null|scalar ...$values <p>
     * The values to insert into the formatted string.
     * </p>
     *
     * @return string string produced according to the formatting string $format.
     */
    public static function format (string $format, null|bool|float|int|string ...$values):string {

        return sprintf($format, ...$values);

    }

    /**
     * ### Strip whitespace (or other characters) from the beginning and end of a string
     *
     * This function returns a string with whitespace stripped from the beginning and end of the string.
     *
     * Without the second parameter, StrSB#trim() will strip these characters.
     *
     * - " " (ASCII 32 (0x20)), an ordinary space.
     * - "\t" (ASCII 9 (0x09)), a tab.
     * - "\n" (ASCII 10 (0x0A)), a new line (line feed).
     * - "\r" (ASCII 13 (0x0D)), a carriage return.
     * - "\0" (ASCII 0 (0x00)), the NUL-byte.
     * - "\v" (ASCII 11 (0x0B)), a vertical tab.
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
     * @param string $characters [optional] <p>
     * The stripped characters can also be specified using the char-list parameter.
     *
     * List all characters that you want to be stripped. With '..', you can specify a range of characters.
     * </p>
     *
     * @return string The trimmed string.
     *
     * @note Because StrSB#trim trims characters from the beginning and end of a string, it may be confusing when
     * characters are (or aren't) removed from the middle.
     * StrSB#trim('abc', 'bad') removes both 'a' and 'b' because it trims 'a' thus moving 'b' to the beginning to
     * also be trimmed.
     * So, this is why it "works" whereas StrSB#trim('abc', 'b') seemingly doesn't.
     */
    public static function trim (string $string, Side $side = Side::BOTH, string $characters = " \n\r\t\v\x00"):string {

        return match($side) {
            Side::LEFT => ltrim($string, $characters),
            Side::RIGHT => rtrim($string, $characters),
            Side::BOTH => trim($string, $characters)
        };

    }

}