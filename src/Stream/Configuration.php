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

use function stream_set_blocking;
use function stream_set_timeout;
use function stream_set_read_buffer;
use function stream_set_write_buffer;
use function stream_set_chunk_size;

/**
 * ### PHP Runtime Stream Configuration Utilities
 *
 * Provides low-level wrappers for configuring native PHP stream behavior.
 *
 * Supports blocking modes, timeouts, buffering, and chunk sizes while preserving the behavior of the underlying PHP
 * functions.
 * @since 1.0.0
 */
final readonly class Configuration extends NativeRuntime {

    /**
     * ### Sets the blocking mode of a stream
     *
     * Enables or disables blocking mode on the specified stream.
     *
     * In blocking mode, supported operations may wait until data becomes available. In non-blocking mode, operations
     * may return without waiting for the requested data.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource to configure.
     * </p>
     * @param bool $blocking <p>
     * True to enable blocking mode, false to enable non-blocking mode.
     * </p>
     *
     * @return bool True on success, false on failure.
     */
    public static function setBlocking (mixed $stream, bool $blocking):bool {

        return stream_set_blocking($stream, $blocking);

    }

    /**
     * ### Sets the timeout of a stream
     *
     * Configures the timeout for read and write operations on the specified stream.
     *
     * The timeout is expressed in seconds and microseconds.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource to configure.
     * </p>
     * @param int<0, max> $seconds <p>
     * Timeout duration in seconds.
     * </p>
     * @param int<0, max> $microseconds [optional] <p>
     * Additional timeout duration in microseconds.
     * </p>
     *
     * @return bool True on success, false on failure.
     */
    public static function setTimeout (mixed $stream, int $seconds, int $microseconds = 0):bool {

        return stream_set_timeout($stream, $seconds, $microseconds);

    }

    /**
     * ### Sets the read buffer size of a stream
     *
     * Configures the read buffer used by the specified stream.
     *
     * A buffer size of zero disables read buffering.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource to configure.
     * </p>
     * @param int<0, max> $size <p>
     * Read buffer size in bytes.
     * </p>
     *
     * @return int Zero on success, or a nonzero value on failure.
     */
    public static function setReadBuffer (mixed $stream, int $size):int {

        return stream_set_read_buffer($stream, $size);

    }

    /**
     * ### Sets the write buffer size of a stream
     *
     * Configures the write buffer used by the specified stream.
     *
     * A buffer size of zero disables write buffering.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource to configure.
     * </p>
     * @param int<0, max> $size <p>
     * Write buffer size in bytes.
     * </p>
     *
     * @return int Zero on success, or a nonzero value on failure.
     */
    public static function setWriteBuffer (mixed $stream, int $size):int {

        return stream_set_write_buffer($stream, $size);

    }

    /**
     * ### Sets the chunk size of a stream
     *
     * Changes the chunk size used by the specified stream.
     *
     * The previous chunk size is returned when the operation succeeds.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource to configure.
     * </p>
     * @param positive-int $size <p>
     * New chunk size in bytes.
     * </p>
     *
     * @return int Previous chunk size on success.
     */
    public static function setChunkSize (mixed $stream, int $size):int {

        return stream_set_chunk_size($stream, $size);

    }

}