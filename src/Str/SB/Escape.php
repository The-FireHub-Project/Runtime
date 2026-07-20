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

use function addcslashes;
use function addslashes;
use function quotemeta;
use function strip_tags;
use function stripcslashes;
use function stripslashes;

/**
 * ### PHP Single-Byte String Runtime Wrapper Utility - Escape
 *
 * Provides runtime wrappers for escaping, quoting, and removing escape sequences from single-byte string data using
 * native PHP string escaping operations while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for single-byte string escape
 * operations without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Escape extends NativeRuntime {

    /**
     * ### Quote string with slashes
     *
     * Backslashes are added before characters that need to be escaped: (single quote, double quote, backslash, NUL).
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to be escaped.
     * </p>
     *
     * @return ($string is empty ? '' : non-falsy-string) The escaped string.
     *
     * @caution The Escape#addSlashes() is sometimes incorrectly used to try to prevent SQL Injection. Instead,
     * database-specific escaping functions and/or prepared statements should be used.
     */
    public static function addSlashes (string $string):string {

        return addslashes($string);

    }

    /**
     * ### Quote string with slashes in a C style
     *
     * Returns a string with backslashes before characters that are listed in characters' parameter.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to be escaped.
     * </p>
     * @param string $characters <p>
     * The list of characters to be escaped.
     *
     * Non-alphanumeric characters with ASCII codes lower than 32 and higher than 126 converted to octal representation.
     * </p>
     *
     * @return string The escaped string.
     */
    public static function addCSlashes (string $string, string $characters):string {

        return addcslashes($string, $characters);

    }

    /**
     * ### Unquotes a quoted string
     *
     * Backslashes are removed: (backslashes become single quote, double backslashes are made into a single backslash).
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to be unquoted.
     * </p>
     *
     * @return string String with backslashes stripped off.
     *
     * @note StrSB#stripSlashes() is not recursive. If you want to apply this function to a multidimensional array,
     * you need to use a recursive function.
     * @tip StrSB#stripSlashes() can be used if you aren't inserting this data into a place (such as a database)
     * that requires escaping. For example, if you're simply outputting data straight from an HTML form.
     */
    public static function stripSlashes (string $string):string {

        return stripslashes($string);

    }

    /**
     * ### Unquote string quoted with Escape::addCSlashes
     *
     * Returns a string with backslashes stripped off. Recognizes C-like \n, \r ..., octal, and hexadecimal
     * representation.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to be unquoted.
     * </p>
     *
     * @return string The unescaped string.
     */
    public static function stripCSlashes (string $string):string {

        return stripcslashes($string);

    }

    /**
     * ### Quote meta-characters
     *
     * Returns a version of str with a backslash character (\) before every character that is among these: .\+*?[^]($).
     * @since 1.0.0
     *
     * @param string $string <p>
     * The input string.
     * </p>
     *
     * @return ($string is empty ? '' : non-empty-string) The string with meta-characters quoted.
     */
    public static function quoteMeta (string $string):string {

        return quotemeta($string);

    }

    /**
     * ### Strip HTML and PHP tags from a string
     *
     * This function tries to return a string with all NULL bytes, HTML and PHP tags stripped from a given string.
     *
     * It uses the same tag-stripping state machine as the fgetss() function.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The input string.
     * </p>
     * @param null|string|array<int, string> $allowed_tags <p>
     * You can use the optional second parameter to specify tags which shouldn't be stripped.
     * </p>
     *
     * @return string the Stripped string.
     *
     * @note Self-closing XHTML tags are ignored, and only non-self-closing tags should be used in allowed_tags. For
     * example, to allow both ```<br>``` and ```<br/>```, you should use: ```<br>```.
     */
    public static function stripTags (string $string, null|string|array $allowed_tags = null):string {

        return strip_tags($string, $allowed_tags);

    }

}