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

namespace FireHub\Runtime\Date;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Exception\ {
    CannotParseTimestampException, ParseFromFormatException
};
use ValueError;

use function date_parse;
use function date_parse_from_format;
use function strtotime;

/**
 * ### Date Parsing Utilities
 *
 * Provides low-level wrappers for parsing date and time strings into structured date information while preserving
 * native PHP behavior.
 * @since 1.0.0
 */
final class Parse extends NativeRuntime {

    /**
     * ### Returns associative array with detailed info about the given date/time
     *
     * Method parses the given datetime string according to the same rules as Parse::stringToTimestamp().
     * @since 1.0.0
     *
     * @param non-empty-string $datetime <p>
     * String representing the date/time.
     * </p>
     *
     * @return array<string, mixed> Associative array with detailed info about the given date/time.
     *
     * @warning The number of array elements in the warning and errors arrays might be lower than warning_count or
     * error_count if they occurred at the same position.
     */
    public static function date (string $datetime):array {

        return date_parse($datetime);

    }

    /**
     * ### Get info about the given date formatted according to the specified format
     * @since 1.0.0
     *
     * @param non-empty-string $format <p>
     * Format accepted by date with some extras.
     * </p>
     * @param non-empty-string $datetime <p>
     * String representing the date/time.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ParseFromFormatException If $datetime contains NULL-bytes.
     *
     * @return array{
     *  year: int|false, month: int|false, day: int|false, hour: int|false, minute: int|false, second: int|false,
     *  fraction: float|false, warning_count: int, warnings: array<string>, error_count: int, errors: array<string>,
     *  is_localtime: bool, zone_type?: bool|int, zone?: bool|int, is_dst?: bool, tz_abbr?: string, tz_id?: string,
     *  relative?: array{
     *   year: int, month: int, day: int, hour: int, minute: int, second: int, weekday?: int, weekdays?: int,
     *   first_day_of_month?: bool, last_day_of_month?: bool
     *  }
     * } Associative array with detailed info about a given date/time.
     *
     * @warning The number of array elements in the warning and errors arrays might be lower than warning_count or
     * error_count if they occurred at the same position-
     */
    public static function dateFromFormat (string $format, string $datetime):array {

        try {

            return date_parse_from_format($format, $datetime);

        } catch (ValueError) {

            throw new ParseFromFormatException('$datetime contains NULL-bytes');

        }

    }

    /**
     * ### Parse about any English textual datetime description into a Unix timestamp
     *
     * The method expects to be given a string containing an English date format. It will try to parse that format
     * into a Unix timestamp (the number of seconds since January 1, 1970 00:00:00 UTC), relative to the timestamp
     * given in baseTimestamp, or the current time if baseTimestamp is not supplied.
     * @since 1.0.0
     *
     * @see https://www.php.net/manual/en/datetime.formats.php To check how to pass $datetime parameter.
     *
     * @param non-empty-string $datetime <p>
     * A date/time string.
     * </p>
     * @param null|int $timestamp [optional] <p>
     * The timestamp which is used as a base for the calculation of relative dates.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\CannotParseTimestampException If we couldn't convert string
     * to timestamp.
     *
     * @return int A timestamp.
     *
     * @note If the number of the year is specified in a two-digit format, the values between 00-69 are mapped to
     * 2000-2069 and 70-99 to 1970-1999.
     * See the notes below for possible differences on 32bit systems (possible dates might end on 2038-01-19 03:14:07).
     * @note The valid range of a timestamp is typically from Fri, 13 Dec 1901 20:45:54 UTC to Tue, 19 Jan 2038
     * 03:14:07 UTC (These are the dates that correspond to the minimum and maximum values for a 32-bit signed
     * integer.).
     * For 64-bit versions of PHP, the valid range of a timestamp is effectively infinite, as 64 bits can represent
     * approximately 293 billion years in either direction.
     */
    public static function timestamp (string $datetime, ?int $timestamp = null):int {

        return ($str_to_time = strtotime($datetime, $timestamp)) !== false
            ? $str_to_time : throw new CannotParseTimestampException;

    }

}