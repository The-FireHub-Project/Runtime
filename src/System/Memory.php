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

namespace FireHub\Runtime\System;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Str;

use function memory_get_usage;
use function memory_get_peak_usage;
use function memory_reset_peak_usage;

/**
 * ### PHP Runtime Memory Utilities
 *
 * Provides low-level wrappers for inspecting and managing PHP runtime memory usage, including current allocation,
 * peak memory consumption, and memory-related runtime operations while preserving native PHP behavior.
 *
 * This component exposes PHP memory management capabilities through a consistent FireHub Runtime API without
 * altering native runtime behavior.
 * @since 1.0.0
 */
final class Memory extends NativeRuntime {

    /**
     * ### Gets the amount of memory allocated to PHP
     * @since 1.0.0
     *
     * @return non-negative-int The memory amount in bytes.
     */
    public static function getUsage ():int {

        return memory_get_usage();

    }

    /**
     * ### Gets the peak of memory allocated by PHP
     * @since 1.0.0
     *
     * @return non-negative-int The memory peak in bytes.
     */
    public static function getPeakUsage ():int {

        return memory_get_peak_usage();

    }

    /**
     * ### Reset the peak memory usage
     * @since 1.0.0
     *
     * @return void
     */
    public static function resetPeakUsage ():void {

        memory_reset_peak_usage();

    }

}