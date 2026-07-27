<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.0
 * @package Runtime
 */

namespace FireHub\Runtime\Arr;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function array_pop;
use function array_push;
use function array_shift;
use function array_unshift;

/**
 * ### PHP Array Runtime Wrapper Utility - Mutation
 *
 * Provides runtime wrappers for modifying arrays through direct value insertion, removal, and queue or stack
 * operations while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for array mutation operations
 * without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Mutation extends NativeRuntime {

    /**
     * ### Pop the element off the end of an array
     *
     * Pops and returns the last element value of the $array, shortening the $array by one element.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray &$array <p>
     * The array to get the value from.
     * </p>
     * @phpstan-param-out TArray $array
     *
     * @return null|value-of<TArray> The last value of an array. If an array is empty (or is not an array), null will
     * be returned.
     *
     * @note This function will reset the array pointer of the input array after use.
     */
    public static function pop (array &$array):mixed {

        return array_pop($array);

    }

    /**
     * ### Push elements onto the end of an array
     *
     * Method treats an array as a stack and pushes the passed variables onto the end of an array.
     *
     * The length of an array increases by the number of variables pushed.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     * @template TPushedValue
     *
     * @param array<TKey, TValue> &$array <p>
     * The input array.
     * </p>
     * @param TPushedValue ...$values [optional] <p>
     * The values to push onto the end of the array.
     * </p>
     * @phpstan-param-out array<TKey, TValue|TPushedValue> $array
     *
     * @return int The new number of elements in the array.
     *
     * @note If you use push to add one element to the array, it is better to use $array[] = because in that way
     * there is no overhead of calling a function.
     */
    public static function push (array &$array, mixed ...$values):int {

        return array_push($array, ...$values);

    }

    /**
     * ### Removes an item at the beginning of an array
     *
     * Shifts the first value of the array off and returns it, shortening the array by one element and moving
     * everything down.
     *
     * All numerical array keys will be modified to start counting from zero while literal keys won't be affected.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray &$array <p>
     * Array to shift.
     * </p>
     * @phpstan-param-out TArray $array
     *
     * @return null|value-of<TArray> The shifted value, or null if an array is empty or is not an array.
     *
     * @note This function will reset the array pointer of the input array after use.
     */
    public static function shift (array &$array):mixed {

        return array_shift($array);

    }

    /**
     * ### Prepend one or more elements to the beginning of an array
     *
     * Method prepends passed elements to the front of the array.
     *
     * Note that the list of elements is prepended as a whole so that the prepended elements stay in the same order.
     *
     * All numerical array keys will be modified to start counting from zero, while literal keys won't be changed.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     * @template TUnshiftValue
     *
     * @param array<TKey, TValue> &$array <p>
     * The input array.
     * </p>
     * @param TUnshiftValue ...$values [optional] <p>
     * The values to prepend.
     * </p>
     * @phpstan-param-out array<TKey, TValue|TUnshiftValue> $array
     *
     * @return int The new number of elements in the array.
     *
     * @note Resets array's internal pointer to the first element.
     */
    public static function unshift (array &$array, mixed ...$values):int {

        return array_unshift($array, ...$values);

    }

}