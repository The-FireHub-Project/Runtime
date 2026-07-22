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

namespace FireHub\Runtime\ObjectModel;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\DataIs;
use FireHub\Runtime\Exception\ {
    ClassAliasException, ClassDoesntExistException
};

use function class_alias;
use function get_class_methods;
use function get_class_vars;
use function get_mangled_object_vars;
use function get_object_vars;

/**
 * #### Object and Class Metadata
 *
 * Provides low-level utilities for retrieving runtime metadata from classes and objects.
 *
 * This component exposes native PHP metadata operations such as aliases, declared members, and internal object
 * information without introducing reflection-based abstractions.
 * @since 1.0.0
 */
final class Metadata extends NativeRuntime {

    /**
     * ### Creates an alias for a class
     *
     * Creates an alias named alias based on the user-defined class.
     *
     * The aliased class is exactly the same as the original class.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\ObjectModel\Inspection::isClass() To check if the original class exists before creating
     * an alias.
     *
     * @param class-string $class <p>
     * The original class.
     * </p>
     * @param class-string $alias <p>
     * The alias name for the class.
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to autoload if the original class is not found.
     * </p>
     *
     *
     * @throws \FireHub\Runtime\Exception\ClassAliasException If failed to create alias for the class.
     *
     * @return true True on success.
     *
     * @note Class names are case-insensitive in PHP, and this is reflected in this function.
     * Aliases created by ClsObj#alias() are declared in lowercase
     * This means that for a class MyClass, the Metadata#alias('MyClass', 'My_Class_Alias') call will declare a new
     * class alias named my_class_alias.
     */
    public static function alias (string $class, string $alias, bool $autoload = true):true {

        return Inspection::isClass($class) && class_alias($class, $alias, $autoload)
            ?: throw new ClassAliasException;

    }

    /**
     * ### Gets the accessible non-static properties and their values
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\ObjectModel\Inspection::isClass() To check if the class exists before getting its
     * properties.
     * @uses \FireHub\Runtime\DataIs::object() To check if the $object_or_class parameter is an object.
     *
     * @param class-string|object $object_or_class <p>
     * The class name or an object instance.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ClassDoesntExistException If the class doesn't exist.
     *
     * @return array<string, mixed> Returns an associative array of declared properties visible from the current
     * scope, with their values.
     *
     * @note The result depends on the current scope.
     * @note Using this function will use any registered autoloader if the class is not already known.
     */
    public static function properties (string|object $object_or_class):array {

        /** @var array<string, mixed> */
        return match (true) {
            DataIs::object($object_or_class) => get_object_vars($object_or_class),
            default => Inspection::isClass($object_or_class)
                ? get_class_vars($object_or_class)
                : throw new ClassDoesntExistException
        };

    }

    /**
     * ### Gets the mangled object properties
     *
     * Returns an array whose elements are the object's properties.
     *
     * The keys are the member variable names, with a few notable exceptions: private variables have the class name
     * prepended to the variable name, and protected variables have a * prepended to the variable name.
     *
     * These prepended values have NUL bytes on either side.
     *
     * Uninitialized typed properties are silently discarded.
     * @since 1.0.0
     *
     * @param object $object <p>
     * An object instance.
     * </p>
     *
     * @return array<string, mixed> An array containing all properties, regardless of visibility, of an object.
     */
    public static function mangledProperties (object $object):array {

        /** @var array<string, mixed> */
        return get_mangled_object_vars($object);

    }

    /**
     * ### Gets the class or object methods names
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\ObjectModel\Inspection::isClass() To check if the class exists before getting its methods.
     * @uses \FireHub\Runtime\DataIs::object() To check if the $object_or_class parameter is an object.
     *
     * @param class-string|object $object_or_class <p>
     * The class name or an object instance.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ClassDoesntExistException If the class doesn't exist.
     *
     * @return array<string> Returns an array of method names defined for the class, or false if the class doesn't
     * exist.
     *
     * @note The result depends on the current scope.
     */
    public static function methods (string|object $object_or_class):array {

        return Inspection::isClass(DataIs::object($object_or_class) ? $object_or_class::class : $object_or_class)
            ? get_class_methods($object_or_class)
            : throw new ClassDoesntExistException;

    }

}