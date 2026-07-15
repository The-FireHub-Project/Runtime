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

namespace FireHub\Runtime\Arr;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function array_diff;
use function array_diff_assoc;
use function array_diff_key;
use function array_diff_uassoc;
use function array_diff_ukey;
use function array_intersect;
use function array_intersect_assoc;
use function array_intersect_key;
use function array_intersect_uassoc;
use function array_intersect_ukey;
use function array_udiff;
use function array_udiff_assoc;
use function array_udiff_uassoc;
use function array_uintersect;
use function array_uintersect_assoc;
use function array_uintersect_uassoc;

/**
 * ### PHP Array Runtime Wrapper Utility - SetOperation
 *
 * Provides runtime wrappers for performing set-based operations on arrays, including difference, intersection,
 * and user-defined comparison while preserving native PHP behavior and performance.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for array set operations
 * without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class SetOperation extends NativeRuntime {

    /**
     * ### Computes the difference of arrays using values for comparison
     *
     * Compares an array against one or more other arrays and returns the values in an array that aren't present in any
     * of the other arrays.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, scalar|\Stringable>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param array<array-key, mixed> ...$excludes [optional] <p>
     * An array to compare against.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that aren't present in any of the other arrays.
     *
     * @note This function only checks one dimension of an n-dimensional array.<br>
     * You can check deeper dimensions by using Arr#difference($array1[0], $array2[0]).
     */
    public static function difference (array $array, array ...$excludes):array {

        /** @var TArray */
        return array_diff($array, ...$excludes);

    }

    /**
     * ### Computes the difference of arrays using values for comparison by using a callback for comparison
     *
     * Computes the difference of arrays by using a callback function for data comparison.<br>
     * This is unlike Arr#difference() which uses an internal function for comparing the data.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(value-of<TArray>|value-of<TCompareArray>, value-of<TArray>|value-of<TCompareArray>):int<-1, 1> $callback <p>
     * The comparison function must return an integer less than, equal to, or greater than zero if the first argument
     * is considered to be respectively less than, equal to, or greater than the second.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that aren't present in any of
     * the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note Note that this function only checks one dimension of an n-dimensional array.<br>
     * Of course, you can check deeper dimensions by using
     * Arr#differenceFunc($array1[0], $array2[0], 'data_compare_func').
     */
    public static function differenceUsing (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_udiff($array, $excludes, $callback);

    }

    /**
     * ### Computes the difference of arrays using keys for comparison
     *
     * Compares the keys from an array against the keys from arrays and returns the difference.<br>
     * This function is like Arr#difference() except the comparison is done on the keys instead of the values.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param array<array-key, mixed> ...$excludes [optional] <p>
     * An array to compare against.
     * </p>
     *
     * @return TArray Returns an array containing all the entries from an array whose keys are absent from all the
     * other arrays.
     *
     * @note This function only checks one dimension of an n-dimensional array.<br>
     * Of course, you can check deeper dimensions by using Arr#differenceKey($array1[0], $array2[0]).
     */
    public static function differenceKey (array $array, array ...$excludes):array {

        /** @var TArray */
        return array_diff_key($array, ...$excludes);

    }

    /**
     * ### Computes the difference of arrays using keys for comparison by using a callback for data comparison
     *
     * Compares the keys from an array against the keys from arrays and returns the difference.<br>
     * This function is like Arr#difference() except the comparison is done on the keys instead of the values.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(key-of<TArray>|key-of<TCompareArray>, key-of<TArray>|key-of<TCompareArray>):int<-1, 1> $callback <p>
     * The comparison function.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that aren't present in any of the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note This function only checks one dimension of an n-dimensional array.<br>
     * Of course, you can check deeper dimensions by using
     * Arr#differenceKeyFunc($array1[0], $array2[0], 'callback_func').
     */
    public static function differenceUsingKey (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_diff_ukey($array, $excludes, $callback);

    }

    /**
     * ### Computes the difference of arrays with additional index check
     *
     * Compares an array against arrays and returns the difference.<br>
     * Unlike Arr#difference(), the array keys are also used in the comparison.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, scalar|\Stringable>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param array<array-key, mixed> ...$excludes [optional] <p>
     * An array to compare against.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that aren't present in any of
     * the other arrays.
     *
     * @note This function only checks one dimension of an n-dimensional array.<br>
     * It is possible to check deeper dimensions by using, for example, Arr#differenceAssoc($array1[0], $array2[0]).
     * @note Ensure arguments are passed in the correct order when comparing similar arrays with more keys.<br>
     * The new array should be the first in the list.
     */
    public static function differenceAssoc (array $array, array ...$excludes):array {

        /** @var TArray */
        return array_diff_assoc($array, ...$excludes);

    }

    /**
     * ### Computes the difference of arrays with additional index check by using a callback for value comparison
     *
     * Computes the difference of arrays with an additional index check, compares data by a callback function.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(value-of<TArray>|value-of<TCompareArray>, value-of<TArray>|value-of<TCompareArray>):int<-1, 1> $callback <p>
     * The comparison function.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that aren't present in any of the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note Note that this function only checks one dimension of an n-dimensional array.<br>
     * Of course, you can check deeper dimensions by using, for example,
     * Arr#differenceAssocFuncValue($array1[0], $array2[0], some_comparison_func').
     */
    public static function differenceAssocUsingValue (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_udiff_assoc($array, $excludes, $callback);

    }

    /**
     * ### Computes the difference of arrays with additional index check by using a callback for key comparison
     *
     * Compares an array against arrays and returns the difference.<br>
     * Unlike Arr#difference(), the array keys are used in the comparison.<br>
     * Unlike Arr#differenceAssoc(), a user-supplied callback function is used for the indices' comparison,
     * not an internal function.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(key-of<TArray>|key-of<TCompareArray>, key-of<TArray>|key-of<TCompareArray>):int<-1, 1> $callback <p>
     * The comparison function.
     * </p>
     *
     * @return TArray Returns an array containing all the entries from $array that aren't present in any of the other
     * arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note This function only checks one dimension of an n-dimensional array.<br>
     * It is possible to check deeper dimensions by using, for example,
     * Arr#differenceAssocFuncKey($array1[0], $array2[0], 'key_compare_func').
     */
    public static function differenceAssocUsingKey (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_diff_uassoc($array, $excludes, $callback);

    }

    /**
     * ### Computes the difference of arrays with additional index check by using a callback for key-value comparison
     *
     * Computes the difference of arrays with additional index check, compares data, and indexes by a callback function.<br>
     * Note that the keys are used in the comparison unlike Arr#difference() and Arr#differenceFunc().
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(value-of<TArray>|value-of<TCompareArray>, value-of<TArray>|value-of<TCompareArray>):int<-1, 1> $callback_value <p>
     * The comparison function for value.
     * </p>
     * @param callable(key-of<TArray>|key-of<TCompareArray>, key-of<TArray>|key-of<TCompareArray>):int<-1, 1> $callback_key <p>
     * The comparison function for a key.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that aren't present in any of
     * the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note This function only checks one dimension of an n-dimensional array.<br>
     * It is possible to check deeper dimensions by using, for example,
     *  Arr#differenceAssocFuncKeyValue($array1[0], $array2[0], 'data_compare_func', 'key_compare_func').
     */
    public static function differenceAssocUsingKeyValue (array $array, array $excludes, callable $callback_value, callable $callback_key):array {

        /** @var TArray */
        return array_udiff_uassoc($array, $excludes, $callback_value, $callback_key);

    }

    /**
     * ### Computes the intersection of arrays using values for comparison
     *
     * Returns an array containing all the values of an array that are present in all the arguments.<br>
     * Note that keys are preserved.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, scalar|\Stringable>
     *
     * @param TArray $array <p>
     * The array with main values to check.
     * </p>
     * @param array<array-key, mixed> ...$arrays [optional] <p>
     * An array to compare values against.
     * </p>
     *
     * @return TArray The filtered array.
     *
     * @note Two elements are considered equal if and only if (string) $elem1 === (string) $elem2.<br>
     * In words: when the string representation is the same.
     */
    public static function intersect (array $array, array ...$arrays):array {

        /** @var TArray */
        return array_intersect($array, ...$arrays);

    }

    /**
     * ### Computes the intersection of arrays using values for comparison by using a callback for data comparison
     *
     * Computes the intersection of arrays, compares data by a callback function.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(value-of<TArray>|value-of<TCompareArray>, value-of<TArray>|value-of<TCompareArray>):int<-1, 1> $callback <p>
     * The comparison function.
     * </p>
     *
     * @return TArray Arrays containing all the entries from $array that are present in any of the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note Two elements are considered equal if and only if (string) $elem1 === (string) $elem2.<br>
     * In words: when the string representation is the same.
     */
    public static function intersectUsing (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_uintersect($array, $excludes, $callback);

    }

    /**
     * ### Computes the intersection of arrays using keys for comparison
     *
     * Returns an array containing all the entries of an array which have keys that are present in all the arguments.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array with main values to check.
     * </p>
     * @param array<array-key, mixed> ...$arrays [optional] <p>
     * An array to compare values against.
     * </p>
     *
     * @return TArray The filtered array.
     */
    public static function intersectKey (array $array, array ...$arrays):array {

        return array_intersect_key($array, ...$arrays);

    }

    /**
     * ### Computes the intersection of arrays using keys for comparison by using a callback for data comparison
     *
     * Returns an array containing all the values of an array which have matching keys that are present in all the
     * arguments.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(key-of<TArray>|key-of<TCompareArray>, key-of<TArray>|key-of<TCompareArray>):int<-1, 1> $callback <p>
     * The comparison function.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that are present in any of the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     */
    public static function intersectUsingKey (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_intersect_ukey($array, $excludes, $callback);

    }

    /**
     * ### Computes the intersection of arrays with additional index check
     *
     * Returns an array containing all the values of an array that are present in all the arguments.<br>
     * Note that the keys are also used in the comparison, unlike in Arr#intersect().
     * @since 1.0.0
     *
     * @template TArray of array<array-key, scalar|\Stringable>
     *
     * @param TArray $array <p>
     * The array with main values to check.
     * </p>
     * @param array<array-key, mixed> ...$arrays [optional] <p>
     * An array to compare values against.
     * </p>
     *
     * @return TArray The filtered array.
     *
     * @note The two values from the key → value pairs are considered equal only if (string) $elem1 === (string) $elem2.<br>
     * In other words, a strict type check is executed, so the string representation must be the same.
     */
    public static function intersectAssoc (array $array, array ...$arrays):array {

        /** @var TArray */
        return array_intersect_assoc($array, ...$arrays);

    }

    /**
     * ### Computes the intersection of arrays with additional index check by using a callback for value comparison
     *
     * Computes the intersection of arrays with additional index check, compares data by a callback function.<br>
     * Note that the keys are used in the comparison unlike in Arr#intersectFunc().
     * The data is compared by using a callback function.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(value-of<TArray>|value-of<TCompareArray>, value-of<TArray>|value-of<TCompareArray>):int<-1, 1> $callback $callback <p>
     * The comparison function.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that are present in any of the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     */
    public static function intersectAssocUsingValue (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_uintersect_assoc($array, $excludes, $callback);

    }

    /**
     * ### Computes the intersection of arrays with additional index check by using a callback for key comparison
     *
     * Computes the intersection of arrays with additional index check, compares data and indexes by separate
     * callback functions.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(key-of<TArray>|key-of<TCompareArray>, key-of<TArray>|key-of<TCompareArray>):int<-1, 1> $callback <p>
     * The comparison function.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that are present in any of the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note The comparison function must return an integer less than, equal to, or greater than zero if<br>
     * the first argument is considered to be respectively less than, equal to, or greater than the second.
     */
    public static function intersectAssocUsingKey (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_intersect_uassoc($array, $excludes, $callback);

    }

    /**
     * ### Computes the intersection of arrays with additional index check by using a callback for key-value comparison
     *
     * Computes the intersection of arrays with additional index check, compares data and indexes by separate
     * callback functions.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(value-of<TArray>|value-of<TCompareArray>, value-of<TArray>|value-of<TCompareArray>):int<-1, 1> $callback_value <p>
     * The comparison function for value.
     * </p>
     * @param callable(key-of<TArray>|key-of<TCompareArray>, key-of<TArray>|key-of<TCompareArray>):int<-1, 1>  $callback_key <p>
     * The comparison function for a key.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that are present in any of the other
     * arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note The comparison function must return an integer less than, equal to, or greater than zero if
     * the first argument is considered to be respectively less than, equal to, or greater than the second.
     */
    public static function intersectAssocUsingKeyValue (array $array, array $excludes, callable $callback_value, callable $callback_key):array {

        /** @var TArray */
        return array_uintersect_uassoc($array, $excludes, $callback_value, $callback_key);

    }

}