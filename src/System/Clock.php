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

namespace FireHub\Runtime\System;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function hrtime;
use function microtime;
use function time;

/**
 * ### PHP Runtime Clock Utilities
 *
 * Provides low-level wrappers for retrieving high-resolution and system clock values, including Unix timestamps,
 * microsecond precision time measurements, and monotonic timers while preserving native PHP behavior.
 *
 * This component exposes PHP clock and time measurement capabilities through a consistent FireHub Runtime API
 * without altering native runtime semantics.
 * @since 1.0.0
 */
final class Clock extends NativeRuntime {

    /**
     * ### Return current Unix timestamp
     *
     * Returns the current time measured in the number of seconds since the Unix Epoch (January, 1 1970 00:00:00 GMT).
     * @since 1.0.0
     *
     * @return positive-int The current timestamp.
     *
     * @tip The timestamp of the start for the request is available in $_SERVER['REQUEST_TIME'].
     */
    public static function time ():int {

        return time();

    }

    /**
     * ### Get current Unix microseconds
     *
     * Method returns the current Unix timestamp with microseconds.
     *
     * This function is only available on operating systems that support the gettimeofday() system call.
     * @since 1.0.0
     *
     * @return float The current timestamp with microseconds.
     *
     * @tip For performance measurements, using hrtime() is recommended.
     */
    public static function microtime ():float {

        return microtime(true);

    }

    /**
     * ### Get the system's high-resolution time
     *
     * Returns the system's high-resolution time, counted from an arbitrary point in time. The delivered timestamp is
     * monotonic and cannot be adjusted.
     * @since 1.0.0
     *
     * @return array{0: int<0, max>, 1: int<0, 999999999>} Returns an array of integers in the form [seconds,
     * nanoseconds].
     */
    public static function highResolution ():array {

        return hrtime();

    }

}