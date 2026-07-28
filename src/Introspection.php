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

use function get_declared_classes;
use function get_declared_interfaces;
use function get_declared_traits;
use function get_defined_constants;
use function get_defined_functions;

/**
 * ### PHP Runtime Introspection Utilities
 *
 * Provides low-level wrappers for inspecting the current PHP runtime environment, including declared classes,
 * interfaces, traits, functions, and constants while preserving native runtime behavior.
 *
 * This component exposes native runtime introspection capabilities through a consistent FireHub Runtime API without
 * altering PHP execution semantics.
 * @since 1.0.0
 */
final class Introspection extends NativeRuntime {

    /**
     * ### Gets the declared classes
     * @since 1.0.0
     *
     * @return list<class-string> Array of the names for the declared classes in the current script.
     *
     * @note Note that depending on what extensions you've compiled or loaded into PHP, additional classes could be
     * present.
     * This means that you will not be able to define your own classes using these names.
     */
    public static function classes ():array {

        return get_declared_classes();

    }

    /**
     * ### Gets the declared interfaces
     * @since 1.0.0
     *
     * @return list<class-string> Array of the names for the declared interfaces in the current script.
     */
    public static function interfaces ():array {

        return get_declared_interfaces();

    }

    /**
     * ### Gets the declared traits
     * @since 1.0.0
     *
     * @return list<class-string> Array of the names for the declared traits in the current script.
     */
    public static function traits ():array {

        return get_declared_traits();

    }

    /**
     * ### Gets the declared constants
     *
     * Returns the names and values of all the constants currently defined.
     *
     * This includes those created by extensions as well as those created with the Constant::define() function.
     * @since 1.0.0
     *
     * @param bool $categorize [optional] <p>
     * Causing this function to return a multidimensional array with categories in the keys of the first dimension
     * and constants and their values in the second dimension.
     * </p>
     *
     * @return ($categorize is true ? array<string, array<non-empty-string, mixed>> : array<string, mixed>) Array of
     * constant name => constant value array, optionally grouped by extension name registering the constant.
     */
    public static function definedConstants (bool $categorize = false):array {

        return get_defined_constants($categorize);

    }

    /**
     * ### Gets the declared functions
     * @since 1.0.0
     *
     * @return array{internal: non-empty-array<int, callable-string>, user: array<int, callable-string>}
     * A multidimensional array containing a list of all defined functions, both built-in (internal) and user-defined.
     * The internal functions will be accessible via $arr['internal'], and the user-defined ones using $arr['user'].
     */
    public static function definedFunctions ():array {

        return get_defined_functions();

    }

}