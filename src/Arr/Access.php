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

use FireHub\Runtime\Module;
use FireHub\Runtime\Exception\ {
    EmptyArrayException, InvalidRangeException
};

use function array_column;
use function array_find;
use function array_find_key;
use function array_first;
use function array_key_exists;
use function array_key_first;
use function array_key_last;
use function array_keys;
use function array_last;
use function array_rand;
use function array_search;
use function array_values;

/**
 * ## PHP Array Runtime Wrapper Utility - Access
 *
 * The Access class provides lightweight, deterministic wrappers for accessing and retrieving data from PHP arrays.
 *
 * It contains common runtime operations for locating values, extracting keys, retrieving columns, and navigating
 * array elements while preserving native PHP behavior and performance.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for array access operations
 * without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Access extends Module {

    /**
     * ### Checks if the given key or index exists in the array
     *
     * Returns true if the given key is set in the array.
     * Key can be any value possible for an array index.
     * @since 1.0.0
     *
     * @param array-key $key <p>
     * Key to check.
     * </p>
     * @param array<array-key, mixed> $array <p>
     * An array with keys to check.
     * </p>
     *
     * @return bool True if the key exists in an array, false otherwise.
     *
     * @note Method will search for the keys in the first dimension only.
     * Nested keys in multidimensional arrays will not be found.
     */
    public static function keyExists (int|string $key, array $array):bool {

        return array_key_exists($key, $array);

    }

    /**
     * ### Searches the array for a given value and returns the first corresponding key if successful
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * Array to search.
     * </p>
     * @param mixed $value <p>
     * The searched value.
     * If $value is a string, the comparison is done in a case-sensitive manner.
     * </p>
     *
     * @return TKey|false The key for value if it is found in the array, false otherwise.
     *
     * @warning This method may return Boolean false but may also return a non-Boolean value which evaluates to false.
     * Read the section on Booleans for more information.
     * Use the === operator for testing the return value of this function.
     */
    public static function search (array $array, mixed $value):int|string|false {

        return array_search($value, $array, true);

    }

    /**
     * ### Return the values from a single column in the input array
     *
     * Returns the values from a single column of the $array, identified by the $key.
     *
     * Optionally, an argument key may be provided to $index the values in the returned array by the values from the
     * index argument column of the input array.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TIndex of null|array-key
     * @template TArray of array<array-key, mixed>
     *
     * @param array<array-key, TArray> $array <p>
     * A multidimensional array (record set) from which to pull a column of values.<br>
     * If an array of objects is provided, then public properties can be directly pulled.<br>
     * In order for protected or private properties to be pulled, the class must implement both the __get() and
     * __isset() magic methods.<br>
     * </p>
     * @param TKey $key <p>
     * The column of values to return.<br>
     * This value may be an integer key of the column you wish to retrieve, or it may be a string key name for an
     * associative array or property name.<br>
     * It may also be null to return complete arrays or objects (this is useful together with $index to reindex the
     * array).<br>
     * </p>
     * @param TIndex $index [optional] <p>
     * The column to use as the index/keys for the returned array.<br>
     * This value may be the integer key of the column, or it may be the string key name.<br>
     * The value is cast as usual for array keys.
     * </p>
     *
     * @return ($index is null ? list<mixed> : array<array-key, mixed>) Array of values representing a single column
     * from the input array.
     */
    public static function column (array $array, int|string $key, null|int|string $index = null):array {

        return array_column($array, $key, $index);

    }

    /**
     * ### Get the first item from an array
     *
     * Get the first item of the given $array without affecting the internal array pointer.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * An array.
     * </p>
     *
     * @return null|TValue First item from $array or null if an array is empty.
     */
    public static function first (array $array):mixed {

        return array_first($array);

    }

    /**
     * ### Get the last item from an array
     *
     * Get the last item of the given $array without affecting the internal array pointer.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * An array.
     * </p>
     *
     * @return null|TValue Last item from $array or null if an array is empty.
     */
    public static function last (array $array):mixed {

        return array_last($array);

    }

    /**
     * ### Get the first key from an array
     *
     * Get the first key of the given $array without affecting the internal array pointer.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * An array.
     * </p>
     *
     * @return null|TKey First key from $array or null if an array is empty.
     */
    public static function firstKey (array $array):null|int|string {

        return array_key_first($array);

    }

    /**
     * ### Get the last key from an array
     *
     * Get the last key of the given $array without affecting the internal array pointer.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * An array.
     * </p>
     *
     * @return null|TKey Last key from $array or null if an array is empty.
     */
    public static function lastKey (array $array):null|int|string {

        return array_key_last($array);

    }

    /**
     * ### Return all the keys or a subset of the keys for an array
     *
     * Returns the keys, numeric, and string, from the $array.<br>
     * If a $filter is specified, then only the keys for that value are returned.<br>
     * Otherwise, all the keys from the array are returned.
     * @since 1.0.0
     *
     * @template TKey of array-key
     *
     * @param array<TKey, mixed> $array <p>
     * An array containing keys to return.
     * </p>
     * @param mixed $filter [optional] <p>
     * If specified, then only keys containing these values are returned.
     * </p>
     *
     * @return list<TKey> An array of all the keys in the input.
     */
    public static function keys (array $array, mixed $filter = null):array {

        return $filter !== null
            ? array_keys($array, $filter, true)
            : array_keys($array);

    }

    /**
     * ### Return all the values from an array
     *
     * Returns all the values from the array and indexes the array numerically.
     * @since 1.0.0
     *
     * @template TValue
     *
     * @param array<array-key, TValue> $array <p>
     * The array.
     * </p>
     *
     * @return list<TValue> An indexed array of values.
     */
    public static function values (array $array):array {

        return array_values($array);

    }

    /**
     * ### Returns the first element satisfying a callback function
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * The array that should be searched.
     * </p>
     * @param callable(TValue, TKey):bool $callback <p>
     * The callback function to call to check each element.
     * </p>
     *
     * @return null|TValue The value of the first element for which the callback returns true, null otherwise.
     */
    public static function find (array $array, callable $callback):mixed {

        return array_find($array, $callback);

    }

    /**
     * ### Returns the key of the first element satisfying a callback function
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * The array that should be searched.
     * </p>
     * @param callable(TValue, TKey):bool $callback <p>
     * The callback function to call to check each element.
     * </p>
     *
     * @return null|TKey The key of the first element for which the callback returns true, null otherwise.
     */
    public static function findKey (array $array, callable $callback):null|int|string {

        return array_find_key($array, $callback);

    }

    /**
     * ### Pick one or more random keys out of an array
     *
     * Picks one or more random entries out of an array and returns the key (or keys) of the random entries.
     * @since 1.0.0
     *
     * @template TKey of array-key
     *
     * @param non-empty-array<TKey, mixed> $array <p>
     * The input array.
     * </p>
     * @param positive-int $number [optional] <p>
     * Specifies how many entries should be picked.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\EmptyArrayException If the input array is empty.
     * @throws \FireHub\Runtime\Exception\InvalidRangeException If the number of requested random keys is less than
     * one or exceeds the available array size.
     *
     * @return ($number is int<2, max> ? list<TKey> : TKey) When picking only one entry, the method returns the key
     * for a random entry.<br>
     * Otherwise, an array of keys for the random entries is returned.
     *
     * @caution This function doesn't generate cryptographically secure values and mustn't be used for cryptographic
     * purposes, or purposes that require returned values to be unguessable.
     */
    public static function random (array $array, int $number = 1):int|string|array {

        if ($array === []) throw new EmptyArrayException;

        if ($number < 1) {
            throw new InvalidRangeException(
                'The number of requested random keys must be greater than zero.',
                [
                    'value' => $number,
                    'minimum' => 1,
                ]
            );
        }

        if ($number > $maximum = count($array)) {
            throw new InvalidRangeException(
                'The number of requested random keys exceeds the available array size.',
                [
                    'value' => $number,
                    'maximum' => $maximum,
                ]
            );
        }

        /** @var ($number is int<2, max> ? list<TKey> : TKey) */
        return array_rand($array, $number);

    }

}