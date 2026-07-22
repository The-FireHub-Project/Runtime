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
use FireHub\Runtime\Type\Str\CaseMode;

/**
 * ### PHP Multibyte String Runtime Wrapper Utility - Casing
 *
 * Provides runtime wrappers for changing the letter case of multibyte string data using encoding-aware character
 * transformation operations while preserving native PHP multibyte behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for multibyte string case
 * transformation operations with support for Unicode-aware character processing.
 * @since 1.0.0
 */
final class Casing extends NativeRuntime {

    /**
     * ### Perform case folding on a string
     *
     * Performs case folding on a string, converted in the way specified by $caseFolding.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being converted.
     * </p>
     * @param \FireHub\Runtime\Type\Str\CaseMode $case_mode <p>
     * The mode of the conversion.
     * </p>
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return (
     *  $case_mode is CaseMode::UPPER
     *  ? uppercase-string
     *  : ($case_mode is CaseMode::LOWER
     *    ? lowercase-string
     *    : string)
     * ) Converted string.
     */
    public static function convert (string $string, CaseMode $case_mode, ?Encoding $encoding = null):string {

        return mb_convert_case($string, $case_mode->value, $encoding?->value);

    }

    /**
     * ### Make the first character of a string uppercased
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being converted.
     * </p>
     *
     * @return ($string is empty ? '' : non-empty-string) String with the first character uppercased.
     */
    public static function capitalize (string $string):string {

        return mb_ucfirst($string);

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
     * @return ($string is empty ? '' : non-empty-string) String with the first character lowercased.
     */
    public static function uncapitalize (string $string):string {

        return mb_lcfirst($string);

    }

}