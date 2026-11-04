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
use FireHub\Runtime\Stream\Enum\OpenMode;

use function fopen;
use function fclose;

/**
 * ### PHP Runtime Stream Handle Utilities
 *
 * Provides low-level wrappers for opening and closing native PHP streams.
 *
 * Preserves native PHP stream behavior.
 * @since 1.0.0
 */
final readonly class Handle extends NativeRuntime {

    /**
     * ### Opens a stream resource
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * File path or supported stream URI.
     * </p>
     * @param \FireHub\Runtime\Stream\Enum\OpenMode $mode [optional] <p>
     * Stream opening mode.
     * </p>
     * @param bool $use_include_path [optional] <p>
     * Whether to search the configured include path.
     * </p>
     * @param null|resource $context [optional] <p>
     * Stream context resource.
     * </p>
     *
     * @return resource|false Opened stream resource, or false on failure.
     */
    public static function open (string $path, OpenMode $mode, bool $use_include_path = false, mixed $context = null):mixed {

        return fopen($path, $mode->value, $use_include_path, $context);

    }

    /**
     * ### Closes an open stream
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource to close.
     * </p>
     *
     * @return bool True on success, false on failure.
     */
    public static function close (mixed $stream):bool {

        return fclose($stream);

    }

}