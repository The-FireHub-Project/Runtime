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
use FireHub\Runtime\Str;
use FireHub\Runtime\Exception\InvalidSleepDurationException;

use function sleep;
use function time_nanosleep;
use function time_sleep_until;
use function usleep;

/**
 * ### PHP Runtime Time Utilities
 *
 * Provides low-level wrappers for working with time-related runtime operations, including timestamps,
 * delays, sleeping, and time measurement while preserving native PHP behavior.
 *
 * This component exposes PHP time management capabilities through a consistent FireHub Runtime API without
 * altering native runtime behavior.
 * @since 1.0.0
 */
final class Time extends NativeRuntime {

    /**
     * ### Delay execution
     * @since 1.0.0
     *
     * @param non-negative-int $seconds <p>
     * Halt time in seconds.
     * </p>
     * @param non-negative-int $nanoseconds [optional] <p>
     * Halt time in nanoseconds.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidSleepDurationException If the sleep time is invalid.
     *
     * @return ($nanoseconds is positive-int ? bool|array{seconds: int<0, max>, nanoseconds: int<0, max>} : bool)
     * True on success, false if the call was interrupted by a signal or if nanoseconds are used, an associative
     * array will be returned with the components:
     * - seconds - number of seconds remaining in the delay
     * - nanoseconds - number of nanoseconds remaining in the delay
     *
     * @phpstan-ignore return.unusedType
     */
    public static function sleep (int $seconds, int $nanoseconds = 0):bool|array {

        if ($seconds < 0)
            throw new InvalidSleepDurationException(
                'The sleep time must be at least 0.',
                [
                    'time' => $seconds,
                    'minimum' => 0,
                ]
            );

        return $nanoseconds > 0
            ? time_nanosleep($seconds, $nanoseconds)
            : sleep($seconds) === 0;

    }

    /**
     * ### Delays program execution for the given number of microseconds
     * @since 1.0.0
     *
     * @param int<0, 999999> $microseconds <p>
     * Halt time in microseconds.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidSleepDurationException If the number of microseconds is less than 0 or
     * more than 999_999.
     *
     * @return void
     */
    public static function sleepMicroseconds (int $microseconds):void {

        if ($microseconds < 0 || $microseconds > 999_999)
            throw new InvalidSleepDurationException(
                'The microsleep time must be between 0 and 999999 microseconds.',
                [
                    'time' => $microseconds,
                    'minimum' => 0,
                    'maximum' => 999_999,
                ]
            );

        usleep($microseconds);

    }

    /**
     * ### Delays program execution until the given timestamp
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\System\Clock::time() To get the current timestamp.
     *
     * @param int $timestamp <p>
     * The timestamp when the script should wake.
     * </p>
     *
     * @return bool Returns true on success or false on failure.
     */
    public static function sleepUntil (int $timestamp):bool {

        return $timestamp <= Clock::time() || time_sleep_until($timestamp);

    }

}