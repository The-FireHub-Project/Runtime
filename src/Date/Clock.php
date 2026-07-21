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

namespace FireHub\Runtime\Date;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function microtime;
use function time;

/**
 * ### Clock and Current Time Utilities
 *
 * Provides low-level wrappers for retrieving and formatting the current system time using native PHP date and time
 * functions while preserving native runtime behavior.
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

}