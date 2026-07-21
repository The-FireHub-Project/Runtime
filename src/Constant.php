<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.1
 * @package Runtime
 */

namespace FireHub\Runtime;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Exception\ {
    CannotDefineConstantException, ConstantAlreadyDefinedException, UndefinedConstantException
};

use function constant;
use function define;
use function defined;

/**
 * ### PHP Runtime Constant Utility
 *
 * Provides low-level wrappers for inspecting, defining, and retrieving PHP constants while preserving native runtime behavior.
 *
 * This component exposes native constant operations through a consistent FireHub Runtime API without introducing
 * additional abstraction or changing PHP semantics.
 * @since 1.0.0
 */
final class Constant extends NativeRuntime {

    /**
     * ### Checks whether a given named constant exists
     *
     * This function works also with class constants and enum cases.
     * @since 1.0.0
     *
     * @param non-empty-string $name <p>
     * The constant name.
     * </p>
     *
     * @return bool True if the named constant given by the name parameter has been defined, false otherwise.
     *
     * @note This function works also with class constants and enum cases.
     */
    public static function defined (string $name):bool {

        return defined($name);

    }

    /**
     * ### Defines a named constant at runtime
     *
     * Creates a new global constant with the given name and value.
     * @since 1.0.0
     *
     * @uses Constant::defined() To check if the constant already exists before attempting to define it.
     *
     * @param non-empty-string $name <p>
     * The name of the constant.
     * </p>
     * @param null|array<array-key, mixed>|scalar $value <p>
     * The value of the constant.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ConstantAlreadyDefinedException If constant with the same name already
     * exists.
     * @throws \FireHub\Runtime\Exception\CannotDefineConstantException If failed to define constant.
     *
     * @return true True on success.
     */
    public static function define (string $name, null|array|bool|float|int|string $value):true {

        return self::defined($name)
            ? throw new ConstantAlreadyDefinedException(
                'Constant already defined.',
                [
                    'name' => $name,
                ]
            )
            : (define($name, $value)
                ?: throw new CannotDefineConstantException(
                    'Failed to define constant.',
                    [
                        'name' => $name,
                        'value' => $value,
                    ]
                )
            );

    }

    /**
     * ### Returns the value of a constant
     *
     * Method Constant#value() is useful if you need to retrieve the value of a constant but don't know its name.
     * In other words, it is stored in a variable or returned by a function.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Constant::defined() To check if the constant is defined before attempting to retrieve
     * its value.
     *
     * @param non-empty-string $name <p>
     * The constant name.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\UndefinedConstantException If the constant is not defined.
     *
     * @return mixed The value of the constant.
     *
     * @note This function works also with class constants and enum cases.
     */
    public static function value (string $name):mixed {

        return self::defined($name)
            ? constant($name)
            : throw new UndefinedConstantException (
                'Constant is not defined.',
                [
                    'name' => $name,
                ]
            );

    }

}