<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.5
 * @package Runtime
 */

namespace FireHub\Runtime\Arr;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function current;
use function end;
use function key;
use function next;
use function prev;
use function reset;

/**
 * ### PHP Array Runtime Wrapper Utility - Pointer
 *
 * The Pointer class provides lightweight, deterministic wrappers for PHP array internal pointer operations.
 *
 * It contains runtime utilities for navigating and manipulating the internal array pointer, including moving between
 * elements, retrieving the current position, and resetting or advancing traversal state while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for low-level array pointer
 * operations without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Pointer extends NativeRuntime {

    /**
     * ### Return the current element in an array
     *
     * Every array has an internal pointer to its "current" element, which is initialized to the first element
     * inserted into the array.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array.
     * </p>
     *
     * @return value-of<TArray>|false The Iterables::current() function simply returns the value of the array element
     * that is being pointed to with the internal pointer.
     *
     * It doesn't move the pointer in any way.
     *
     * If the internal pointer points beyond the end of the element list or the array is empty, Iterables::current()
     * returns false.
     *
     * @warning This function may return Boolean false but may also return a non-Boolean value which evaluates to false.
     *
     * Read the section on Booleans for more information.
     *
     * Use the === operator for testing the return value of this function.
     * @note The results of calling Iterables::current() on an empty array and on an array whose internal pointer points
     * beyond the end of the elements is indistinguishable from a bool false element.
     *
     * To properly traverse an array which may contain false elements, see the foreach control structure.
     *
     * To still use Iterables::current() and properly check if the value is really an element of the array, the
     * Iterables::key() of the Iterables::current() element should be checked to be strictly different from null.
     */
    public static function current (array $array):mixed {

        return current($array);

    }

    /**
     * ### Fetch a key from an array
     *
     * Key returns the index element of the current array position.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array.
     * </p>
     *
     * @return null|key-of<TArray> The Iterables::key() function simply returns the key of the array element that's
     * currently being pointed to by the internal pointer.
     *
     * It doesn't move the pointer in any way.
     *
     * If the internal pointer points beyond the end of the element list or the array is empty, Iterables::key()
     * returns null.
     */
    public static function key (array $array):null|int|string {

        return key($array);

    }

    /**
     * ### Rewind the internal array pointer
     *
     * Method Iterables::prev() behaves like Iterables::next(), except it rewinds the internal array pointer one place
     * instead of advancing it.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray &$array <p>
     * The input array.
     * </p>
     * @phpstan-param-out TArray $array
     *
     * @return null|value-of<TArray> Returns the array value in the previous place that is pointed to by the internal
     * array pointer, or false if there are no more elements.
     *
     * @warning This function may return Boolean false but may also return a non-Boolean value which evaluates to false.
     * Read the section on Booleans for more information.
     *
     * Use the === operator for testing the return value of this function.
     * @note The beginning of an array is indistinguishable from a bool false element. To make the distinction, check
     * that the Iterables#key() of the Iterables#prev() element is not null.
     */
    public static function prev (array &$array):mixed {

        return prev($array);

    }

    /**
     * ### Advance the internal pointer of an array
     *
     * Method Iterables::next() behaves like Iterables::current(), with one difference.
     *
     * It advances the internal array pointer one place forward before returning the element value.
     *
     * That means it returns the next array value and advances the internal array pointer by one.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray &$array <p>
     * The array being affected.
     * </p>
     * @phpstan-param-out TArray $array
     *
     * @return value-of<TArray>|false Returns the array value in the next place that is pointed to by the internal array
     * pointer, or false if there are no more elements.
     *
     * @warning This function may return Boolean false but may also return a non-Boolean value which evaluates to false.
     *
     * Read the section on Booleans for more information.
     *
     * Use the === operator for testing the return value of this function.
     * @note The end of an array is indistinguishable from a bool false element.
     * To properly traverse an array which may contain false elements, see the foreach function.
     *
     * To still use Iterables::next() and properly check if the end of the array has been reached, verify that the
     * Iterables::key() is null.
     */
    public static function next (array &$array):mixed {

        return next($array);

    }

    /**
     * ### Set the internal pointer of an array to its first element
     *
     * Method Iterables::reset() rewinds the array's internal pointer to the first element and returns the value of
     * the first array element.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray &$array <p>
     * The input array.
     * </p>
     * @phpstan-param-out TArray $array
     *
     * @return value-of<TArray>|false Returns the value of the first array element, or false if the array is empty.
     *
     * @warning This function may return Boolean false but may also return a non-Boolean value which evaluates to false.
     *
     * Read the section on Booleans for more information.
     *
     * Use the === operator for testing the return value of this function.
     * @note The return value for an empty array is indistinguishable from the return value in the case of an array
     * which has a bool false first element.
     *
     * To properly check the value of the first element in an array which may contain false elements, first check the
     * Iterables#count() of the array, or check that Iterables#key() is not null, after calling Iterables#reset().
     */
    public static function reset (array &$array):mixed {

        return reset($array);

    }

    /**
     * ### Set the internal pointer of an array to its last element
     *
     * Method Iterables::end() advances the array's internal pointer to the last element and returns its value.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray &$array <p>
     * The input array.
     * </p>
     * @phpstan-param-out TArray $array
     *
     * @return value-of<TArray>|false Returns the value of the last element or false for an empty array.
     *
     * @warning This function may return Boolean false but may also return a non-Boolean value which evaluates to false.
     *
     * Read the section on Booleans for more information.
     *
     * Use the === operator for testing the return value of this function.
     */
    public static function end (array &$array):mixed {

        return end($array);

    }

}