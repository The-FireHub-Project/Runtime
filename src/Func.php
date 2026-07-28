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

use function call_user_func;
use function call_user_func_array;
use function function_exists;

/**
 * ### PHP Runtime Function Utilities
 *
 * Provides low-level wrappers for inspecting and invoking callable functions using native PHP function utilities
 * while preserving native runtime behavior.
 *
 * This component exposes PHP callable execution capabilities through a consistent FireHub Runtime API without
 * altering function invocation semantics.
 * @since 1.0.0
 */
final class Func extends NativeRuntime {

    /**
     * ### Checks if the function name exists
     *
     * Checks the list of defined functions, both built-in (internal) and user-defined, for function.
     * @since 1.0.0
     *
     * @param non-empty-string $name <p>
     * The function name.
     * </p>
     *
     * @phpstan-assert-if-true callable-string $name
     * @phpstan-assert-if-false !callable-string $name
     *
     * @return bool True if the interface exists, false otherwise.
     *
     * @note This function will return false for constructs, such as include_once and echo.
     * @note A function name may exist even if the function itself is unusable due to configuration or compiling
     * options.
     */
    public static function isFunction (string $name):bool {

        return function_exists($name);

    }

    /**
     * ### Call the callback
     *
     * Calls the callback given by the first parameter and passes the remaining parameters as arguments.
     * @since 1.0.0
     *
     * @template TReturn
     * @template TParameters
     *
     * @param callable(TParameters...):TReturn $callback <p>
     * The callable to be called.
     * </p>
     * @param TParameters ...$arguments <p>
     * Zero or more parameters to be passed to the callback.
     * </p>
     *
     * @return TReturn The return value of the callback.
     *
     * @note Callbacks registered with this method will not be called if there is an uncaught exception thrown
     * in a previous callback.
     */
    public static function call (callable $callback, mixed ...$arguments):mixed {

        return call_user_func($callback, ...$arguments);

    }

    /**
     * ### Call the callback with an array of parameters
     *
     * Calls the callback given by the first parameter with the parameters in $arguments.
     * @since 1.0.0
     *
     * @template TReturn
     * @template TParameters
     *
     * @param callable(TParameters...):TReturn $callback <p>
     * The callable to be called.
     * </p>
     * @param array<TParameters> $arguments <p>
     * The parameters that are to be passed to the function as an indexed array.
     * </p>
     *
     * @return TReturn The return value of the callback.
     *
     * @note Callbacks registered with this method will not be called if there is an uncaught exception thrown
     * in a previous callback.
     */
    public static function callWithArray (callable $callback, array $arguments):mixed {

        return call_user_func_array($callback, $arguments);

    }

}