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

use function fflush;
use function ftruncate;
use function fwrite;

/**
 * ### PHP Runtime Stream Writing Utilities
 *
 * Provides low-level wrappers for writing, flushing, and truncating native PHP streams.
 *
 * Preserves native PHP stream behavior.
 * @since 1.0.0
 */
final readonly class Write extends NativeRuntime {

    /**
     * ### Writes bytes to a stream
     *
     * Writes data at the current stream position.
     *
     * The number of bytes written may be smaller than the length of the supplied data.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Destination stream resource.
     * </p>
     * @param string $data <p>
     * Data to write.
     * </p>
     * @param null|int<0, max> $length [optional] <p>
     * Maximum number of bytes to write.
     * </p>
     *
     * @return non-negative-int|false Number of bytes written, or false on failure.
     */
    public static function bytes (mixed $stream, string $data, ?int $length = null):int|false {

        return fwrite($stream, $data, $length);

    }

    /**
     * ### Flushes buffered output to a stream
     *
     * Flushes PHP's buffered output for the specified stream.
     *
     * This operation does not guarantee that data has been physically synchronized to persistent storage.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource to flush.
     * </p>
     *
     * @return bool True on success, false on failure.
     */
    public static function flush (mixed $stream):bool {

        return fflush($stream);

    }

    /**
     * ### Truncates a stream
     *
     * Changes the stream size to the specified number of bytes.
     *
     * The current stream position is not changed.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource to truncate.
     * </p>
     * @param non-negative-int $size <p>
     * New stream size in bytes.
     * </p>
     *
     * @return bool True on success, false on failure.
     */
    public static function truncate (mixed $stream, int $size):bool {

        return ftruncate($stream, $size);

    }

}