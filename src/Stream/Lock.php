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
use FireHub\Core\Type\IO\LockMode;

use function flock;

/**
 * ### PHP Runtime Stream Lock Utilities
 *
 * Provides low-level wrappers for acquiring and releasing advisory locks on native PHP streams.
 *
 * Locking behavior depends on the underlying stream wrapper and operating system.
 * @since 1.0.0
 */
final readonly class Lock extends NativeRuntime {

    /**
     * ### Performs a stream locking operation
     *
     * Acquires or releases an advisory lock on a stream.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource.
     * </p>
     * @param \FireHub\Core\Type\IO\LockMode $mode <p>
     * Locking operation.
     * </p>
     * @param bool $non_blocking [optional] <p>
     * Whether to apply the non-blocking modifier.
     * </p>
     * @param null|bool $would_block [optional] <p>
     * Receives whether the lock attempt would block.
     * </p>
     * @param-out int $would_block
     *
     * @return bool True on success, false on failure.
     */
    public static function operation (mixed $stream, LockMode $mode, bool $non_blocking = false, ?bool &$would_block = null):bool {

        return flock(
            $stream,
            $mode->value | ($non_blocking ? LOCK_NB : 0),
            $would_block
        );

    }

}