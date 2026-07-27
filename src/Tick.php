<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=7.4
 * @package Runtime
 */

namespace FireHub\Runtime;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Exception\RegisterTickFailedException;

use function register_tick_function;
use function unregister_tick_function;

/**
 * ### PHP Runtime Tick Utilities
 *
 * Provides low-level wrappers for registering and removing tick callbacks using native PHP tick handling while
 * preserving runtime behavior.
 *
 * This component exposes execution tick hooks through a consistent FireHub Runtime API without changing PHP tick
 * semantics.
 * @since 1.0.0
 */
final class Tick extends NativeRuntime {

    /**
     * ### Register a function for execution on each tick
     *
     * Registers the given callback to be executed when a tick is called.
     * @since 1.0.0
     *
     * @param callable $callback <p>
     * The function to register.
     * </p>
     * @param mixed ...$arguments <p>
     * Parameters for a callback function.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\RegisterTickFailedException If failed to register tick function.
     *
     * @return true True on success.
     */
    public static function register (callable $callback, mixed ...$arguments):true {

        return register_tick_function($callback, ...$arguments)
            ?: throw new RegisterTickFailedException;

    }

    /**
     * ### De-register a function for execution on each tick
     *
     * De-registers the function, so it is no longer executed when a tick is called.
     * @since 1.0.0
     *
     * @param callable $callback <p>
     * The function to deregister.
     * </p>
     *
     * @return void
     */
    public static function unregister (callable $callback):void {

        unregister_tick_function($callback);

    }

}