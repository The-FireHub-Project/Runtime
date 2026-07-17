<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.0
 * @package Runtime
 */

namespace FireHub\Runtime\Str\SB;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function strcasecmp;
use function strcmp;
use function strncmp;
use function substr_compare;

/**
 * ### PHP Single-Byte String Runtime Wrapper Utility - Compare
 *
 * Provides runtime wrappers for comparing single-byte string data, including binary, lexical, and segment-based
 * comparison operations while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for byte-oriented string
 * comparison operations without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Compare extends NativeRuntime {

    /**
     * ### String comparison
     * @since 1.0.0
     *
     * @param string $string_1 <p>
     * String to compare against.
     * </p>
     * @param string $string_2 <p>
     * String to compare with.
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Is comparison case-sensitive or not.
     * </p>
     *
     * @return int<-1,1> -1 if string1 is less than string2; 1 if string1 is greater than string2, and 0 if they are
     * equal.
     */
    public static function lexical (string $string_1, string $string_2, bool $case_sensitive = true):int {

        $cmp = $case_sensitive
            ? strcmp($string_1, $string_2)
            : strcasecmp($string_1, $string_2);

        return $cmp < 0 ? -1 : ($cmp > 0 ? 1 : 0);

    }

    /**
     * ### String comparison of the first n characters
     * @since 1.0.0
     *
     * @param string $string_1 <p>
     * String to compare against.
     * </p>
     * @param string $string_2 <p>
     * String to compare with.
     * </p>
     * @param int $length <p>
     * Number of characters to use in the comparison.
     * </p>
     *
     * @return ($length is negative-int ? false : int<-1, 1>) -1 if string1 is less than string2; 1 if string1 is greater than
     * string2, and 0 if they are equal, or false if the length is less than 0.
     */
    public static function firstN (string $string_1, string $string_2, int $length):int|false {

        if ($length < 0) return false;

        return strncmp($string_1, $string_2, $length) <=> 0;

    }

    /**
     * ### Comparison of two strings from an offset, up-to-length characters
     * @since 1.0.0
     *
     * @param string $string_1 <p>
     * String to compare against.
     * </p>
     * @param string $string_2 <p>
     * String to compare with.
     * </p>
     * @param int $offset <p>
     * The start position for the comparison.
     *
     * If negative, it starts counting from the end of the string.
     * </p>
     * @param null|int $length [optional] <p>
     * The length of the comparison.
     *
     * The default value is the largest of the length for the needle compared to the length of haystack minus the
     * offset.
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * If case_sensitive is true, the comparison is case-sensitive.
     * </p>
     *
     * @return ($length is negative-int ? false : int<-1, 1>) -1 if string1 is less than string2, 1 if string1 is
     * greater than string2, and zero if they're equal.
     */
    public static function part (string $string_1, string $string_2, int $offset, ?int $length = null, bool $case_sensitive = true):int|false {

        if ($length < 0) return false;

        return substr_compare($string_1, $string_2, $offset, $length, !$case_sensitive) <=> 0;

    }

}