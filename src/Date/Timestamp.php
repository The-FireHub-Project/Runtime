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
use FireHub\Runtime\Exception\CannotCreateTimestampException;

use function gmmktime;
use function mktime;

/**
 * ### Unix Timestamp Utilities
 *
 * Provides low-level wrappers for creating Unix timestamps using native PHP date and time functions while preserving
 * native runtime behavior.
 * @since 1.0.0
 */
final class Timestamp extends NativeRuntime {

    /**
     * ### Format a Unix timestamp
     *
     * Returns the Unix timestamp corresponding to the arguments given.
     *
     * This timestamp is a long integer containing the number of seconds between the Unix Epoch (January, 1 1970
     * 00:00:00 GMT) and the time specified.
     * @since 1.0.0
     *
     * @param int<0, 24> $hour <p>
     * The number of hours relative to the start of the day is determined by month, day, and year.
     * Negative values reference the hour before midnight of the day in question.
     * Values greater than 23 reference the appropriate hour on the following day(s).
     * </p>
     * @param null|int<0, 59> $minute [optional] <p>
     * The number of the minutes relative to the start of the hour.
     *
     * Negative values reference the minute in the previous hour.
     *
     * Values greater than reference 59 the appropriate minute in the following hour(s).
     * </p>
     * @param null|int<0, 59> $second [optional] <p>
     * The number of seconds relative to the start of the minute.
     *
     * Negative values reference the second in the previous minute.
     *
     * Values greater than 59 reference the appropriate second in the following minute(s).
     * </p>
     * @param null|int $year [optional] <p>
     * The year.
     * </p>
     * @param null|int<0, 12> $month [optional] <p>
     * The number of the month relative to the end of the previous year.
     *
     * Values 1 to 12 reference the normal calendar months of the year in question.
     *
     * Values less than 1 (including negative values) reference the months in the previous year in reverse order, so
     * 0 is December, -1 is November, and so on.
     *
     * Values greater than 12 reference the appropriate month in the following year(s).
     * </p>
     * @param null|int<0, 31> $day [optional] <p>
     * The number of the days relative to the end of the previous month.
     *
     * Values 1 to 28, 29, 30, or 31 (depending upon the month) reference the normal days in the relevant month.
     *
     * Values less than 1 (including negative values) reference the days in the previous month, so 0 is the last day
     * of the previous month, -1 is the day before that, and so on.
     *
     * Values greater than the number of days in the relevant month reference the appropriate day in the following
     * month(s).
     * </p>
     * @param bool $gmt [optional] <p>
     * Get a GMT/UTC timestamp.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\CannotCreateTimestampException If the timestamp doesn't fit in a PHP integer.
     *
     * @return int The Unix timestamp of the arguments given.
     */
    public static function create (int $hour, ?int $minute = null, ?int $second = null, ?int $year = null, ?int $month = null, ?int $day = null, bool $gmt = false):int {

        return (
        $timestamp = $gmt
            ? gmmktime($hour, $minute, $second, $month, $day, $year)
            : mktime($hour, $minute, $second, $month, $day, $year)
        ) !== false ? $timestamp : throw new CannotCreateTimestampException;

    }

}