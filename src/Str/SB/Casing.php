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

use function lcfirst;
use function strtolower;
use function strtoupper;
use function ucfirst;
use function ucwords;

/**
 * ### PHP Single-Byte String Runtime Wrapper Utility - Casing
 *
 * Provides runtime wrappers for changing the letter case of single-byte string data using native PHP casing
 * operations while preserving native behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for single-byte string case
 * transformation operations without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Casing extends NativeRuntime {

    /**
     * ### Make string lowercase
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being lowercased.
     * </p>
     *
     * @return ($string is empty ? '' : lowercase-string) String with all alphabetic characters converted to lowercase.
     */
    public static function toLower (string $string):string {

        return strtolower($string);

    }

    /**
     * ### Make string uppercase
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being uppercased.
     * </p>
     *
     * @return ($string is empty ? '' : uppercase-string) String with all alphabetic characters converted to uppercase.
     */
    public static function toUpper (string $string):string {

        return strtoupper($string);

    }

    /**
     * ### Make a string title-cased
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being title cased.
     * </p>
     *
     * @return ($string is empty ? '' : non-falsy-string) String with title-cased conversion.
     */
    public static function toTitle (string $string):string {

        return ucwords($string);

    }

    /**
     * ### Make the first character of a string uppercased
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being converted.
     * </p>
     *
     * @return ($string is empty ? '' : non-falsy-string) String with the first character uppercased.
     */
    public static function capitalize (string $string):string {

        return ucfirst($string);

    }

    /**
     * ### Make the first character of string lowercased
     *
     * Returns a string with the first character of $string lowercased if that character is an ASCII character in the
     * range "A" (0x41) to "Z" (0x5a).
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being converted.
     * </p>
     *
     * @return ($string is empty ? '' : non-falsy-string) String with the first character lowercased.
     */
    public static function uncapitalize (string $string):string {

        return lcfirst($string);

    }

}