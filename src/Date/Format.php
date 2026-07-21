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

namespace FireHub\Runtime\Date;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Exception\FailedToFormatTimestampAsIntException;

use function date;
use function gmdate;
use function idate;

/**
 * ### Date Formatting Utilities
 *
 * Provides low-level wrappers for formatting Unix timestamps into human-readable date and time representations while
 * preserving native PHP formatting behavior.
 */
final class Format extends NativeRuntime {

    /**
     * ### Format a Unix timestamp
     *
     * Returns a string formatted according to the given format string using the given integer timestamp (Unix
     * timestamp) or the current time if no timestamp is given.
     *
     * In other words, timestamp is optional and defaults to the value of Clock#time().
     * @since 1.0.0
     *
     * @link https://www.php.net/manual/en/datetime.format.php To check valid $format formats.
     *
     * @param string $format [optional] <p>
     * The format of the outputted date string.
     * </p>
     * @param null|int $timestamp [optional] <p>
     * The optional timestamp parameter is an integer Unix timestamp that defaults to the current local time if a
     * timestamp is not given.
     * </p>
     * @param bool $gmt [optional] <p>
     * Format a GMT/UTC date/time.
     * </p>
     *
     * @return string String formatted according to the given format string using the given integer timestamp.
     */
    public static function string (string $format = 'Y-m-d H:i:s.u', ?int $timestamp = null, bool $gmt = false):string {

        return $gmt ? gmdate($format, $timestamp) : date($format, $timestamp);

    }

    /**
     * ### Format a Unix timestamp as integer
     *
     * Returns a formatted number, according to the given format string using the given integer timestamp or the current
     * local time if no timestamp is given
     *
     * In other words, timestamp is optional and defaults to the value of Clock#time().
     * @since 1.0.0
     *
     * @see https://www.php.net/manual/en/function.idate.php
     *
     * @param 'B'|'d'|'h'|'H'|'i'|'I'|'L'|'m'|'s'|'t'|'U'|'w'|'W'|'y'|'Y'|'z'|'Z' $format <p>
     * Single format character.
     * </p>
     * @param null|int $timestamp [optional] <p>
     * The optional timestamp parameter is an integer Unix timestamp that defaults to the current local time if a
     * timestamp is not given.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\FailedToFormatTimestampAsIntException If failed to format a Unix timestamp
     * as integer.
     *
     * @return int Formatted date as an integer.
     */
    public static function integer (string $format, ?int $timestamp = null):int {

        return ($i_date = idate($format, $timestamp)) !== false
            ? $i_date
            : throw new FailedToFormatTimestampAsIntException (
                'Failed to format a Unix timestamp as integer.',
                [
                    'format' => $format,
                    'timestamp' => $timestamp
                ]
            );

    }

}