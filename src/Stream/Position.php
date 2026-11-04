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
use FireHub\Core\Type\IO\SeekOrigin;

use function feof;
use function fseek;
use function ftell;
use function rewind;

/**
 * ### PHP Runtime Stream Position Utilities
 *
 * Provides low-level wrappers for inspecting and modifying the current position of native PHP streams.
 * @since 1.0.0
 */
final readonly class Position extends NativeRuntime {

    /**
     * ### Moves the stream position
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource.
     * </p>
     * @param int $offset <p>
     * Position offset in bytes.
     * </p>
     * @param \FireHub\Core\Type\IO\SeekOrigin $origin [optional] <p>
     * Reference position.
     * </p>
     *
     * @return int Zero on success, negative one on failure.
     */
    public static function seek (mixed $stream, int $offset, SeekOrigin $origin = SeekOrigin::START):int {

        return fseek($stream, $offset, $origin->value);

    }

    /**
     * ### Gets the current stream position
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource.
     * </p>
     *
     * @return int|false Current position, or false on failure.
     */
    public static function tell (mixed $stream):int|false {

        return ftell($stream);

    }

    /**
     * ### Rewinds the stream
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource.
     * </p>
     *
     * @return bool True on success, false on failure.
     */
    public static function rewind (mixed $stream):bool {

        return rewind($stream);

    }

    /**
     * ### Determines whether a stream has reached EOF
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource.
     * </p>
     *
     * @return bool True if EOF has been reached.
     */
    public static function eof (mixed $stream):bool {

        return feof($stream);

    }

}