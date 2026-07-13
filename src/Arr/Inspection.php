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

namespace FireHub\Runtime\Arr;

use FireHub\Runtime\Module;
use Countable;

use const COUNT_NORMAL;
use const COUNT_RECURSIVE;

use function array_all;
use function array_any;
use function array_count_values;
use function array_is_list;
use function count;
use function in_array;

/**
 * ### PHP Array Runtime Wrapper Utility - Inspection
 *
 * This class is part of the FireHub Runtime layer and provides a lightweight, deterministic wrapper over native PHP
 * functionality for its respective domain.
 *
 * It is designed to reduce boilerplate, standardize common runtime operations, and improve developer ergonomics
 * through a consistent and expressive API while preserving native PHP behavior and performance.
 *
 * This component contains no domain logic, no framework coupling, and no business rules.
 * @since 1.0.0
 */
final class Inspection extends Module {

    /**
     * ### Checks if all array elements satisfy a callback function
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
     * @return bool True if callback returns true for all elements, false otherwise.
     */
    public static function all (array $array, callable $callback):bool {

        return array_all($array, $callback);

    }

    /**
     * ### Checks if at least one array element satisfies a callback function
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
     * @return bool True if there is at least one element for which callback returns true, false otherwise.
     */
    public static function any (array $array, callable $callback):bool {

        return array_any($array, $callback);

    }

    /**
     * ### Checks if a value exists in an array
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array <p>
     * The array.
     * </p>
     * @param mixed $value <p>
     * The searched value.
     * If the value is a string, the comparison is done in a case-sensitive manner.
     * </p>
     *
     * @return bool True if a value is found in the array, false otherwise.
     */
    public static function inArray (array $array, mixed $value):bool {

        return in_array($value, $array, true);

    }

    /**
     * ### Checks whether a given array is a list
     *
     * Determines if the given array is a list.
     * An array is considered a list if its keys consist of consecutive numbers from 0 to count($array)-1.
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array <p>
     * The array is being evaluated.
     * </p>
     *
     * @phpstan-assert-if-true list<mixed> $array
     *
     * @return ($array is list ? true : false) True if an array is a list, false otherwise.
     *
     * @note This function returns true on empty arrays.
     */
    public static function isList (array $array):bool {

        return array_is_list($array);

    }

    /**
     * ### Counts all elements in the array
     * @since 1.0.0
     *
     * @param array<array-key, mixed>|Countable $value <p>
     * Array or Countable instance to count.
     * </p>
     * @param bool $recursive [optional] <p>
     * Recursively count the array.<br>
     * This is particularly useful for counting all the elements of a multidimensional array.
     * </p>
     *
     * @return non-negative-int Number of elements in an array.
     */
    public static function count (array|Countable $value, bool $recursive = false):int {

        return count($value, $recursive ? COUNT_RECURSIVE : COUNT_NORMAL);

    }

    /**
     * ### Counts the occurrences of each distinct value in an array
     *
     * Returns an array using the values of $array (which must be int-s or strings) as keys and their frequency in an
     * $array as values.
     * @since 1.0.0
     *
     * @template TValue of array-key
     *
     * @param array<array-key, TValue> $array <p>
     * The array of values to count.
     * </p>
     *
     * @return array<TValue, positive-int> An associative array of values from input as keys and their count as
     * value.
     */
    public static function countValues (array $array):array {

        return array_count_values($array);

    }

}