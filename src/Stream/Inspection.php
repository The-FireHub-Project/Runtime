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

use function stream_is_local;
use function stream_isatty;
use function stream_supports_lock;

/**
 * ### PHP Runtime Stream Inspection Utilities
 *
 * Provides low-level wrappers for inspecting native PHP stream properties.
 *
 * Supports checking whether a stream is local, connected to a terminal, or capable of supporting file locking.
 *
 * This component preserves native PHP stream inspection behavior.
 * @since 1.0.0
 */
final readonly class Inspection extends NativeRuntime {

    /**
     * ### Checks whether a stream is local
     *
     * Determines whether the specified stream resource or URL refers to a local stream.
     *
     * Locality is determined by the underlying PHP stream wrapper.
     * @since 1.0.0
     *
     * @param resource|string $stream <p>
     * Stream resource or URL to inspect.
     * </p>
     *
     * @return bool True if the stream is local, false otherwise.
     */
    public static function isLocal (mixed $stream):bool {

        return stream_is_local($stream);

    }

    /**
     * ### Checks whether a stream is connected to a terminal
     *
     * Determines whether the specified stream resource is associated with an interactive terminal.
     *
     * This operation is equivalent to the native PHP stream_isatty() function.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource to inspect.
     * </p>
     *
     * @return bool True if the stream is connected to a terminal, false otherwise.
     */
    public static function isATty (mixed $stream):bool {

        return stream_isatty($stream);

    }

    /**
     * ### Checks whether a stream supports locking
     *
     * Determines whether the specified stream resource supports file locking through the underlying stream
     * implementation.
     *
     * Support for locking does not guarantee that a particular lock acquisition will succeed.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource to inspect.
     * </p>
     *
     * @return bool True if the stream supports locking, false otherwise.
     */
    public static function supportsLock (mixed $stream):bool {

        return stream_supports_lock($stream);

    }

}