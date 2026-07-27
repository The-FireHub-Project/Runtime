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

namespace FireHub\Runtime\ObjectModel;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function class_exists;
use function enum_exists;
use function interface_exists;
use function method_exists;
use function property_exists;
use function trait_exists;

/**
 * ### Object and Class Inspection
 *
 * Provides low-level utilities for inspecting classes, objects, interfaces, traits, enums, methods, and properties.
 *
 * This component exposes native PHP inspection operations for retrieving structural information and checking the
 * existence of runtime-defined entities without introducing reflection abstractions or additional behavior.
 * @since 1.0.0
 */
final class Inspection extends NativeRuntime {

    /**
     * ### Checks if a class name exists
     *
     * This method checks whether the given class has been defined.
     * @since 1.0.0
     *
     * @uses self::isEnum() To check if the class is an enum.
     *
     * @param class-string $name <p>
     * The class name.
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to autoload if not already loaded.
     * </p>
     *
     * @return bool True if class exist, false otherwise.
     */
    public static function isClass (string $name, bool $autoload = true):bool {

        return class_exists($name, $autoload) && !self::isEnum($name); // @phpstan-ignore argument.type

    }

    /**
     * ### Checks if interface name exists
     *
     * Checks if the given interface has been defined.
     * @since 1.0.0
     *
     * @param interface-string $name <p>
     * The interface name.
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to autoload if not already loaded.
     * </p>
     *
     * @return bool True if the interface exists, false otherwise.
     */
    public static function isInterface (string $name, bool $autoload = true):bool {

        return interface_exists($name, $autoload);

    }

    /**
     * ### Checks if a trait name exists
     * @since 1.0.0
     *
     * @param trait-string $name <p>
     * The trait name.
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to autoload if not already loaded.
     * </p>
     *
     * @return bool True if the trait exists, false otherwise.
     */
    public static function isTrait (string $name, bool $autoload = true):bool {

        return trait_exists($name, $autoload);

    }

    /**
     * ### Checks if an enum name exists
     *
     * This method checks whether the given enum has been defined.
     * @since 1.0.0
     *
     * @param enum-string $name <p>
     * The enum name.
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to autoload if not already loaded.
     * </p>
     *
     * @return bool True if enum exists, false otherwise.
     */
    public static function isEnum (string $name, bool $autoload = true):bool {

        return enum_exists($name, $autoload);

    }

    /**
     * ### Checks if the class method exists
     * @since 1.0.0
     *
     * @param class-string|object $object_or_class <p>
     * An object instance or a class name.
     * </p>
     * @param non-empty-string $method <p>
     * The method name.
     * </p>
     *
     * @return bool True if the method given by method has been defined for the given object_or_class, false otherwise.
     *
     * @note Using this function will use any registered autoloader if the class is not already known.
     */
    public static function methodExists (string|object $object_or_class, string $method):bool {

        return method_exists($object_or_class, $method);

    }

    /**
     * ### Checks if the object or class has a property
     *
     * This method checks if the given property exists in the specified class.
     * @since 1.0.0
     *
     * @param class-string|object $object_or_class <p>
     * The class name or an object of the class to test for.
     * </p>
     * @param non-empty-string $property <p>
     * The name of the property.
     * </p>
     *
     * @return bool True if the property exists, false if it doesn't exist.
     *
     * @note As opposed with isset(), Inspection::propertyExist() returns true even if the property has the value null.
     * @note This method can't detect properties that are magically accessible using the __get magic method.
     * @note Using this function will use any registered autoloaders if the class is not already known.
     */
    public static function propertyExists (string|object $object_or_class, string $property):bool {

        return property_exists($object_or_class, $property);

    }

}