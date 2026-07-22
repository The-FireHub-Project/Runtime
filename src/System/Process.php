<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.4
 * @package Runtime
 */

namespace FireHub\Runtime\System;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Exception\ProcessIdUnavailableException;

use function getmypid;

/**
 * ### PHP Process Utilities
 *
 * Provides low-level wrappers for inspecting the current PHP process environment, including retrieving process
 * identifiers and process-related runtime information while preserving native runtime behavior.
 *
 * This component exposes PHP process capabilities through a consistent FireHub Runtime API without altering
 * operating system process semantics.
 * @since 1.0.0
 */
final class Process extends NativeRuntime {

    /**
     * ### Gets PHP's process ID
     * @since 1.0.0
     *
     * @throws \FireHub\Runtime\Exception\ProcessIdUnavailableException If failed to get a process ID.
     *
     * @return positive-int Current PHP process ID.
     *
     * @warning Process IDs aren't unique, thus they're a weak entropy source.
     * We recommend against relying on pids in security-dependent contexts.
     */
    public static function ID ():int {

        /** @var positive-int */
        return ($process_id = getmypid()) !== false
            ? $process_id : throw new ProcessIdUnavailableException;

    }

}