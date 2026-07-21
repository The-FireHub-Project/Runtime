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

use function checkdate;
use function getdate;
use function localtime;

/**
 * ### Calendar Date Utilities
 *
 * Provides low-level wrappers for inspecting and working with calendar dates using native PHP calendar functions
 * while preserving native runtime behavior.
 * @since 1.0.0
 */
final class Calendar extends NativeRuntime {

    /**
     * ### Check for a valid date
     *
     * Checks the validity of the date formed by the arguments.
     *
     * A date is considered valid if each parameter is properly defined.
     * @since 1.0.0
     *
     * @param int<1, 32767> $year <p>
     * The year is between 1 and 32,767 inclusive.
     * </p>
     * @param int<1, 12> $month <p>
     * The month is between 1 and 12 inclusive.
     * </p>
     * @param int<1, 31> $day <p>
     * The day is within the allowed number of days for the given month.
     *
     * Leap years are taken into consideration.
     * </p>
     *
     * @return bool True, if the date given is valid, otherwise returns false.
     */
    public static function check (int $year, int $month, int $day):bool {

        return checkdate($month, $day, $year);

    }

    /**
     * ### Get date/time information
     * @since 1.0.0
     *
     * @param null|int $timestamp [optional] <p>
     * The optional timestamp parameter is an int Unix timestamp that defaults to the current local time if
     * the timestamp is omitted or null.
     * </p>
     *
     * @return array{
     *   seconds: int<0, 59>,
     *   minutes: int<0, 59>,
     *   hours: int<0, 23>,
     *   mday: int<1, 31>,
     *   wday: int<0, 6>,
     *   mon: int<1, 12>,
     *   year: int,
     *   yday: int<0, 365>,
     *   weekday: 'Friday'|'Monday'|'Saturday'|'Sunday'|'Thursday'|'Tuesday'|'Wednesday',
     *   month: 'April'|'August'|'December'|'February'|'January'|'July'|'June'|'March'|'May'|'November'|'October'|'September',
     *   timestamp: int,
     *   dts: 0|1
     * } Associative array of information related to the timestamp.
     */
    public static function info (?int $timestamp = null):array {

        $get_date = ($get_date = getdate($timestamp)) + [
                'timestamp' => $get_date[0],
                'dts' => localtime($timestamp, true)['tm_isdst'] ?? 0
            ];

        unset($get_date[0]);

        /** @var array{
         *   seconds: int<0, 59>,
         *   minutes: int<0, 59>,
         *   hours: int<0, 23>,
         *   mday: int<1, 31>,
         *   wday: int<0, 6>,
         *   mon: int<1, 12>,
         *   year: int,
         *   yday: int<0, 365>,
         *   weekday: 'Friday'|'Monday'|'Saturday'|'Sunday'|'Thursday'|'Tuesday'|'Wednesday',
         *   month: 'April'|'August'|'December'|'February'|'January'|'July'|'June'|'March'|'May'|'November'|'October'|'September',
         *   timestamp: int,
         *   dts: 0|1
         * }
         */
        return $get_date;

    }

}