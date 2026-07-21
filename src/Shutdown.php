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

use function register_shutdown_function;

/**
 * ### PHP Runtime Shutdown Utilities
 *
 * Provides low-level wrappers for registering shutdown callbacks using native PHP shutdown handling mechanisms while
 * preserving runtime behavior.
 *
 * This component exposes shutdown execution hooks through a consistent FireHub Runtime API without altering PHP
 * shutdown lifecycle semantics.
 * @since 1.0.0
 */
final class Shutdown extends NativeRuntime {

    /**
     * ### Register a function for execution on shutdown
     *
     * Registers a callback to be executed after script execution finishes or exit() is called.
     *
     * Multiple calls to this method can be made, and each will be called in the same order as they were registered.
     *
     * If you call exit() within one registered shutdown function, processing will stop completely, and no other
     * registered shutdown functions will be called.
     *
     * Shutdown functions may also call Tick#register() themselves to add a shutdown function to the end of
     * the queue.
     * @since 1.0.0
     *
     * @param callable $callback <p>
     * The shutdown callback to register.
     *
     * The shutdown callbacks are executed as part of the request, so it is possible to send output from them and
     * access output buffers.
     * </p>
     * @param mixed ...$arguments <p>
     * It is possible to pass parameters to the shutdown function by passing additional parameters.
     * </p>
     *
     * @return void
     *
     * @note The working directory of the script can change inside the shutdown function under some web servers,
     * for example, Apache.
     * @note Shutdown functions will not be executed if the process is killed with a SIGTERM or SIGKILL signal.<br>
     * While you can't intercept a SIGKILL, you can use pcntl_signal() to install a handler for a SIGTERM which uses
     * exit() to end cleanly.
     * @note Shutdown functions run separately from the time tracked by max_execution_time.
     * That means even if a process is terminated for running too long, shutdown functions will still be called.
     * Additionally, if the max_execution_time runs out while a shutdown function is running, it will not be terminated.
     */
    public static function register (callable $callback, mixed ...$arguments):void {

        register_shutdown_function($callback, ...$arguments);

    }

}