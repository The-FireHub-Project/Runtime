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

use function stream_get_contents;
use function stream_get_line;

/**
 * ### PHP Runtime Stream Reading Utilities
 *
 * Provides low-level wrappers for reading data from PHP streams.
 *
 * Supports reading the remaining contents of a stream and reading data up to a specified delimiter.
 *
 * This component preserves native PHP stream reading behavior.
 * @since 1.0.0
 */
final readonly class Read extends NativeRuntime {

    /**
     * ### Reads the remaining contents of a stream
     *
     * Reads data from the current stream position until the end of the stream or until the specified maximum number
     * of bytes has been read.
     *
     * An optional offset can be provided to change the position from which reading begins.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource from which data will be read.
     * </p>
     * @param int $length [optional] <p>
     * Maximum number of bytes to read. A value of -1 reads all remaining bytes.
     * </p>
     * @param int $offset [optional] <p>
     * Offset from which reading begins. A value of -1 uses the current stream position.
     * </p>
     *
     * @return string|false Read data on success, false on failure.
     */
    public static function contents (mixed $stream, int $length = -1, int $offset = -1):string|false {

        return stream_get_contents($stream, $length, $offset);

    }

    /**
     * ### Reads a line from a stream
     *
     * Reads data from the current stream position until the specified delimiter is encountered, the maximum number
     * of bytes has been read, or the end of the stream is reached.
     *
     * The delimiter is not included in the returned string.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource from which data will be read.
     * </p>
     * @param int $length <p>
     * Maximum number of bytes to read.
     * </p>
     * @param string $delimiter [optional] <p>
     * Delimiter indicating where reading should stop.
     *
     * An empty string reads data without delimiter matching.
     * </p>
     *
     * @return string|false Read data on success, false on failure.
     */
    public static function line (mixed $stream, int $length, string $delimiter = ''):string|false {

        return stream_get_line($stream, $length, $delimiter);

    }

}