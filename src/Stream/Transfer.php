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

use function stream_copy_to_stream;

/**
 * ### PHP Runtime Stream Transfer Utilities
 *
 * Provides low-level wrappers for transferring data between PHP streams.
 *
 * Supports copying stream contents with optional length and offset parameters while preserving native PHP stream
 * behavior.
 * @since 1.0.0
 */
final readonly class Transfer extends NativeRuntime {

    /**
     * ### Copies data between streams
     *
     * Copies data from the source stream to the destination stream.
     *
     * By default, copies all remaining data from the current position of the source stream.
     *
     * An optional maximum length limits the number of bytes copied. An optional offset specifies the position in the
     * source stream from which copying begins.
     * @since 1.0.0
     *
     * @param resource $source <p>
     * Source stream resource from which data will be read.
     * </p>
     * @param resource $destination <p>
     * Destination stream resource to which data will be written.
     * </p>
     * @param int $length [optional] <p>
     * Maximum number of bytes to copy. A value of -1 copies all remaining data from the source stream.
     * </p>
     * @param int $offset [optional] <p>
     * Offset in the source stream from which copying begins.
     *
     * A value of zero uses the current stream position.
     * </p>
     *
     * @return int|false Number of bytes copied on success, false on failure.
     */
    public static function copy (mixed $source, mixed $destination, int $length = -1, int $offset = 0):int|false {

        return stream_copy_to_stream($source, $destination, $length, $offset);

    }

}