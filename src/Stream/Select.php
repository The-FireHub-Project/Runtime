<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.2
 * @package Runtime
 */

namespace FireHub\Runtime\Stream;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function stream_select;

/**
 * ### PHP Runtime Stream Selection Utilities
 *
 * Provides low-level wrappers for monitoring multiple PHP streams for readiness to perform input and output
 * operations.
 *
 * Supports monitoring readable, writable, and exceptional stream conditions while preserving native PHP stream
 * selection behavior.
 * @since 1.0.0
 */
final readonly class Select extends NativeRuntime {

    /**
     * ### Selects streams ready for I/O operations
     *
     * Monitors the specified streams for readiness to perform reading, writing, or exceptional operations.
     *
     * The input arrays are modified to contain only the streams that satisfy their respective readiness conditions.
     *
     * A null timeout waits indefinitely, while a timeout of zero seconds and zero microseconds performs a
     * non-blocking poll.
     * @since 1.0.0
     *
     * @param null|array<int|string, resource> &$read <p>
     * Streams to monitor for reading. Modified to contain only streams ready for reading.
     * </p>
     * @param null|array<int|string, resource> &$write <p>
     * Streams to monitor for writing. Modified to contain only streams ready for writing.
     * </p>
     * @param null|array<int|string, resource> &$except <p>
     * Streams to monitor for exceptional conditions. Modified to contain only streams with exceptional conditions.
     * </p>
     * @param null|int $seconds <p>
     * Maximum number of seconds to wait. Null waits indefinitely.
     * </p>
     * @param null|int<0, 999999> $microseconds <p>
     * Additional timeout duration in microseconds.
     * </p>
     *
     * @return int|false Number of ready streams on success, or false on failure.
     */
    public static function select (?array &$read, ?array &$write, ?array &$except, ?int $seconds, ?int $microseconds = null):int|false {

        return stream_select(
            $read,
            $write,
            $except,
            $seconds,
            $microseconds
        );

    }

}