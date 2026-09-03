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

namespace FireHub\Runtime;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Core\Boundary\Capability\Cloneable;
use FireHub\Runtime\Exception\CopyObjectException;
use Closure, ReflectionException, ReflectionObject;

/**
 * ### Provides operations for creating deep copies of values
 *
 * Deep copying recursively duplicates mutable arrays and objects while preserving values that are immutable,
 * non-copyable, or otherwise cannot safely be duplicated.
 *
 * Objects implementing the {@see Cloneable} capability are responsible for defining their own deep-copy behavior.
 * Internal PHP objects are never copied through reflection because their internal state may not be safely
 * reconstructible without their constructor or native cloning semantics.
 *
 * Circular object references are preserved during the copy operation.
 * @since 1.0.0
 */
final class Copy extends NativeRuntime {

    /**
     * ### Creates a deep copy of the given value
     * @since 1.0.0
     *
     * @uses self::copy() To perform the deep copy.
     *
     * @param mixed $value <p>
     * The value to copy.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\CopyObjectException If the object's copying fails.
     *
     * @return mixed The deep copy of the given value.
     */
    public static function deep (mixed $value):mixed  {

        $objects = [];

        try {

            return self::copy($value, $objects);

        } catch (ReflectionException $error) {

            throw new CopyObjectException(previous: $error);

        }

    }

    /**
     * ### Recursively copies a value
     * @since 1.0.0
     *
     * @uses self::copyArray() To copy arrays.
     * @uses self::copyObject() To copy objects.
     * @uses \FireHub\Runtime\DataIs::array() To check if the value is an array.
     * @uses \FireHub\Runtime\DataIs::object() To check if the value is an object.
     *
     * @param mixed $value <p>
     * The value to copy.
     * </p>
     * @param array<int, object> $objects <p>
     * Previously copied objects indexed by object identifier.
     * </p>
     *
     * @throws ReflectionException If the object's reflection fails.
     *
     * @return mixed The copied value.
     */
    private static function copy (mixed $value, array &$objects):mixed {

        if (DataIs::array($value))
            return self::copyArray($value, $objects);

        if (!DataIs::object($value))
            return $value;

        return self::copyObject($value, $objects);

    }

    /**
     * ### Recursively copies an array
     * @since 1.0.0
     *
     * @uses self::copy() To copy array items.
     *
     * @param array<array-key, mixed> $value <p>
     * The array to copy.
     * </p>
     * @param array<int, object> $objects <p>
     * Previously copied objects indexed by object identifier.
     * </p>
     *
     * @throws ReflectionException If the object's reflection fails.
     *
     * @return array<array-key, mixed> The copied array.
     */
    private static function copyArray (array $value, array &$objects):array {

        $copy = [];

        foreach ($value as $key => $item)
            $copy[$key] = self::copy($item, $objects);

        return $copy;

    }

    /**
     * ### Copies an object according to its copy semantics
     * @since 1.0.0
     *
     * @uses self::copyCloneable() To copy objects implementing the {@see Cloneable} capability.
     * @uses self::copyReflective() To copy user-defined objects using reflection.
     *
     * @param object $value <p>
     * The object to copy.
     * </p>
     * @param array<int, object> $objects <p>
     * Previously copied objects indexed by object identifier.
     * </p>
     *
     * @throws ReflectionException If the object's reflection fails.
     *
     * @return object The copied object.
     */
    private static function copyObject (object $value, array &$objects):object {

        if ($value instanceof Closure) return $value;

        if ($value instanceof Cloneable) return self::copyCloneable($value, $objects);

        if (new ReflectionObject($value)->isInternal()) return $value;

        return self::copyReflective($value, $objects);

    }

    /**
     * ### Creates a deep copy using the object's own copy contract
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\ObjectModel\Identity::id() To get the object's identifier.
     *
     * @param Cloneable $value <p>
     * The object to copy.
     * </p>
     * @param array<int, object> $objects <p>
     * Previously copied objects indexed by object identifier.
     * </p>
     *
     * @return object The copied object.
     */
    private static function copyCloneable (Cloneable $value, array &$objects):object {

        $id = ObjectModel\Identity::id($value);

        if (isset($objects[$id])) return $objects[$id];

        $copy = $value->copy();

        $objects[$id] = $copy;

        return $copy;

    }

    /**
     * ### Creates a deep copy of a user-defined object using reflection
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\ObjectModel\Identity::id() To get the object's identifier.
     *
     * @param object $value <p>
     * The object to copy.
     * </p>
     * @param array<int, object> $objects <p>
     * Previously copied objects indexed by object identifier.
     * </p>
     *
     * @throws ReflectionException If the object's reflection fails.
     *
     * @return object The copied object.
     */
    private static function copyReflective (object $value, array &$objects):object {

        $id = ObjectModel\Identity::id($value);

        if (isset($objects[$id])) return $objects[$id];

        $reflection = new ReflectionObject($value);

        $copy = $reflection->newInstanceWithoutConstructor();

        $objects[$id] = $copy;

        foreach ($reflection->getProperties() as $property) {

            if ($property->isStatic()) continue;

            if (!$property->isInitialized($value)) continue;

            $property->setValue(
                $copy,
                self::copy($property->getValue($value), $objects)
            );

        }

        return $copy;

    }

}