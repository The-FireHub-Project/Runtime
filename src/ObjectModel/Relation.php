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
use FireHub\Runtime\Exception\ClassDoesntExistException;

use function class_implements;
use function class_parents;
use function class_uses;
use function get_parent_class;
use function is_a;
use function is_subclass_of;

/**
 * ### Object and Class Relations
 *
 * Provides low-level utilities for resolving inheritance, implementation, and type relationships between classes,
 * interfaces, traits, and objects.
 *
 * This component exposes native PHP relationship checks and hierarchy traversal operations while preserving native
 * runtime behavior.
 * @since 1.0.0
 */
final class Relation extends NativeRuntime {

    /**
     * ### Checks whether the object or class is of a given type or subtype
     *
     * Checks if the given $object_or_class is of this object type or has this object type as one of its supertypes.
     * @since 1.0.0
     *
     * @template TObject of object
     *
     * @param class-string|object $object_or_class <p>
     * A class name or an object instance.
     * </p>
     * @param class-string<TObject> $class <p>
     * The class or interface name.
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to allow this function to load the class automatically through the __autoload magic method.
     * </p>
     *
     * @phpstan-assert-if-true TObject|class-string<TObject> $object_or_class
     *
     * @return bool True if the object is of this object type or has this object type as one of its supertypes,
     * false otherwise.
     */
    public static function instanceOf (string|object $object_or_class, string $class, bool $autoload = true):bool {

        return is_a($object_or_class, $class, $autoload);

    }

    /**
     * ### Checks if a class has this class as one of its parents or implements it
     *
     * Checks if the given object_or_class has the class $class as one of its parents or implements it.
     * @since 1.0.0
     *
     * @template TObject of object
     *
     * @param class-string|object $object_or_class <p>
     * The tested class.
     *
     * No error is generated if the class doesn't exist.
     * </p>
     * @param class-string<TObject> $class <p>
     * The class or interface name.
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to allow this function to load the class automatically through the __autoload magic method.
     * </p>
     *
     * @phpstan-assert-if-true TObject $object_or_class
     *
     * @return bool True if the object is of this object or lass type or has this object type as one of its supertypes,
     * false otherwise.
     */
    public static function isSubClassOf (string|object $object_or_class, string $class, bool $autoload = true):bool {

        return is_subclass_of($object_or_class, $class, $autoload);

    }

    /**
     * ### Retrieves the parent class name for an object or class
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\ObjectModel\Inspection::isClass() To check if the class exists before getting its parent.
     * @uses \FireHub\Runtime\DataIs::object() To check if the $object_or_class parameter is an object.
     *
     * @param class-string|object $object_or_class <p>
     * The tested object or class name.<br>
     * This parameter is optional if called from the object's method.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ClassDoesntExistException If the class doesn't exist.
     *
     * @return class-string|false The name of the parent class for the class that $object_or_class is an instance
     * or the name, or false if object_or_class doesn't have a parent.
     */
    public static function parentClass (string|object $object_or_class):string|false {

        return Inspection::isClass(DataIs::object($object_or_class) ? $object_or_class::class : $object_or_class)
            ? get_parent_class($object_or_class)
            : throw new ClassDoesntExistException;

    }

    /**
     * ### Return the parent classes of the given class
     *
     * This function returns an array with the name of the parent classes for the given object_or_class.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\ObjectModel\Inspection::isClass() To check if the class exists before getting its parents.
     * @uses \FireHub\Runtime\DataIs::object() To check if the $object_or_class parameter is an object.
     *
     * @param class-string|object $object_or_class <p>
     * An object (class instance) or a string (class or interface name).
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to allow this function to load the class automatically through the __autoload magic method.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ClassDoesntExistException If the class doesn't exist.
     *
     * @return array<string, class-string> An array on success.
     */
    public static function parents (object|string $object_or_class, bool $autoload = true):array {

        /** @var array<string, class-string> */
        return Inspection::isClass(DataIs::object($object_or_class) ? $object_or_class::class : $object_or_class)
            ? class_parents($object_or_class, $autoload)
            : throw new ClassDoesntExistException;

    }

    /**
     * ### Return the interfaces which are implemented by the given class or interface
     *
     * This function returns an array with the names of the interfaces that the given object_or_class and its parents
     * implement.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\ObjectModel\Inspection::isClass() To check if the class exists before getting its
     * interfaces.
     * @uses \FireHub\Runtime\DataIs::object() To check if the $object_or_class parameter is an object.
     *
     * @param class-string|object $object_or_class <p>
     * An object (class instance) or a string (class or interface name).
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to allow this function to load the class automatically through the __autoload magic method.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ClassDoesntExistException If the class doesn't exist.
     *
     * @return array<string, class-string> An array.
     */
    public static function implements (object|string $object_or_class, bool $autoload = true):array {

        /** @var array<string, class-string> */
        return Inspection::isClass(DataIs::object($object_or_class) ? $object_or_class::class : $object_or_class)
            ? class_implements($object_or_class, $autoload)
            : throw new ClassDoesntExistException;

    }

    /**
     * ### Return the traits used by the given class
     *
     * This function returns an array with the names of the traits that the given object_or_class uses.
     *
     * This does, however, not include any traits used by a parent class.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\ObjectModel\Inspection::isClass() To check if the class exists before getting its traits.
     * @uses \FireHub\Runtime\DataIs::object() To check if the $object_or_class parameter is an object.
     *
     * @param class-string|object $object_or_class <p>
     * An object (class instance) or a string (class or interface name).
     * </p>
     * @param bool $autoload [optional] <p>
     * Whether to allow this function to load the class automatically through the __autoload magic method.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ClassDoesntExistException If the class doesn't exist.
     *
     * @return array<string, class-string> An array.
     */
    public static function uses (object|string $object_or_class, bool $autoload = true):array {

        /** @var array<string, class-string> */
        return Inspection::isClass(DataIs::object($object_or_class) ? $object_or_class::class : $object_or_class)
            ? class_uses($object_or_class, $autoload)
            : throw new ClassDoesntExistException;

    }

}