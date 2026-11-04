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

use function fstat;
use function stream_get_meta_data;
use function stream_get_transports;

/**
 * ### PHP Runtime Stream Metadata Utilities
 *
 * Provides low-level wrappers for retrieving native PHP stream metadata and available stream transport protocols.
 *
 * This component preserves native PHP stream metadata behavior.
 * @since 1.0.0
 */
final readonly class Metadata extends NativeRuntime {

    /**
     * ### Gets stream metadata
     *
     * Retrieves metadata associated with the specified stream resource.
     *
     * The returned information may include the stream's access mode, blocking status, timeout status, end-of-file
     * status, URI, wrapper type, stream type, and seekability.
     *
     * Available metadata entries depend on the underlying stream.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource from which metadata will be retrieved.
     * </p>
     *
     * @return array<string, mixed> Associative array containing stream metadata.
     */
    public static function get (mixed $stream):array {

        return stream_get_meta_data($stream);

    }

    /**
     * ### Gets available stream transports
     *
     * Returns the names of all socket transport protocols supported by the current PHP environment.
     *
     * Available transport depends on the operating system and installed PHP extensions.
     * @since 1.0.0
     *
     * @return list<string> Available stream transport protocol names.
     */
    public static function transports ():array {

        return stream_get_transports();

    }

    /**
     * ### Gets stream resource statistics
     *
     * Retrieves information about the resource underlying the stream.
     *
     * The returned array may contain a device, inode, mode, size, timestamps, and other filesystem-related information.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource.
     * </p>
     *
     * @return array<string|int, int>|false Stream statistics, or false on failure.
     */
    public static function statistics (mixed $stream):array|false {

        return fstat($stream);

    }

}