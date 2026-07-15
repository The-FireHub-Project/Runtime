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
use FireHub\Runtime\Exception\ArrayKeysAndValuesCountMismatchException;

use function array_combine;
use function array_merge;
use function array_merge_recursive;
use function array_replace;
use function array_replace_recursive;

/**
 * ### PHP Array Runtime Wrapper Utility - Composition
 *
 * The Composition class provides lightweight, deterministic wrappers for composing arrays from multiple sources.
 *
 * It contains common runtime operations for merging arrays, replacing values, combining keys with values, and creating
 * new array structures through composition while preserving native PHP behavior and performance.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for array composition operations
 * without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Composition extends NativeRuntime {

    /**
     * ### Creates an array by using one array for keys and another for its values
     *
     * Creates an array by using the values from the $keys array as keys and the values from the $values array as the
     * corresponding values.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Arr\Inspection::count() To check the number of keys and values.
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<array-key, TKey> $keys <p>
     * Array of values to be used as keys.
     *
     * Illegal values for a key will be converted to string.
     * </p>
     * @param array<array-key, TValue> $values <p>
     * Array of values to be used as values on a combined array.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ArrayKeysAndValuesCountMismatchException If the number of keys and values
     * doesn't match.
     *
     * @return array<TKey, TValue> The combined array.
     */
    public static function combine (array $keys, array $values):array {

        if (($key_count = Inspection::count($keys)) !== ($value_count = Inspection::count($values))) {
            throw new ArrayKeysAndValuesCountMismatchException(
                'The number of keys and values must be equal.',
                [
                    'keys' => $key_count,
                    'values' => $value_count,
                ]
            );
        }

        return array_combine($keys, $values);

    }

    /**
     * ### Merges the elements of one or more arrays
     *
     * Merges the elements of one or more arrays so that the values of one are appended to the end of
     * the previous one.
     *
     * It returns the resulting array.
     *
     * If the input arrays have the same string keys, then the later value for that key will overwrite the previous one.
     *
     * If, however, the arrays contain numeric keys, the later value will not overwrite the original value but will
     * be appended.
     *
     * Values in the input arrays with numeric keys will be renumbered with incrementing keys starting from zero in
     * the result array.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> ...$arrays [optional] <p>
     * Variable list of arrays to merge.
     * </p>
     *
     * @return array<TKey, TValue> The resulting array.
     *
     * @note If the input arrays have the same string keys, then the later value for that key will overwrite
     * the previous one.
     * @note If the arrays contain numeric keys, the later value will be appended.
     * @note Numeric keys will be renumbered.
     */
    public static function merge (array ...$arrays):array {

        return array_merge(...$arrays);

    }

    /**
     * ### Merge two or more arrays recursively
     *
     * Merges the elements of one or more arrays so that the values of one are appended to the end of the
     * previous one.
     *
     * It returns the resulting array.
     *
     * If the input arrays have the same string keys, then the values for these keys are merged into an array.
     *
     * This is done recursively, so that if one of the values is an array itself, the function will merge it with a
     * corresponding entry in another array too.
     *
     * If, however, the arrays have the same numeric key, the later value will not overwrite the original value but
     * will be appended.
     * @since 1.0.0
     *
     * @param array<array-key, mixed> ...$arrays [optional] <p>
     * Variable list of arrays to recursively merge.
     * </p>
     *
     * @return array<array-key, mixed> The resulting array.
     */
    public static function mergeRecursive (array ...$arrays):array {

        return array_merge_recursive(...$arrays);

    }

    /**
     * ### Replaces elements from passed arrays into the first array
     *
     * Replaces the values of $array with values having the same keys in each of the following arrays.
     *
     * If a key from the first array exists in the second array, its value will be replaced by the value from the
     * second array.
     *
     * If the key exists in the second array, and not the first, it will be created in the first array.
     *
     * If a key only exists in the first array, it will be left as is.
     *
     * If several arrays are passed for replacement, they will be processed in order, the later arrays overwriting
     * the previous values.
     *
     * Method is not recursive, it will replace values in the first array by whatever type is in the second array.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValueOriginal
     * @template TValueReplacement
     *
     * @param array<TKey, TValueOriginal> $array <p>
     * The array in which elements are replaced.
     * </p>
     * @param array<TKey, TValueReplacement> ...$replacements<p>
     * Arrays from which elements will be extracted.
     *
     * Values from later arrays overwrite the previous values.
     * </p>
     *
     * @return array<TKey, TValueOriginal|TValueReplacement> The resulting array.
     */
    public static function replace (array $array, array ...$replacements):array {

        return array_replace($array, ...$replacements);

    }

    /**
     * ### Replace two or more arrays recursively
     *
     * Replaces the values of $array with the same values from all the following arrays.
     *
     * If a key from the first array exists in the second array, its value will be replaced by the value from the
     * second array.
     *
     * If the key exists in the second array, and not the first, it will be created in the first array.
     *
     * If a key only exists in the first array, it will be left as is.
     *
     * If several arrays are passed for replacement, they will be processed in order, the later array overwriting the
     * previous values.
     *
     * When the value in the first array is scalar, it will be replaced by the value in the second array, may it be
     * scalar or array.
     *
     * When the value in the first array and the second array are both arrays, Arr#replaceRecursive() will replace
     * their respective values recursively.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValueOriginal
     * @template TValueReplacement
     *
     * @param array<TKey, TValueOriginal> $array <p>
     * The array in which elements are replaced.
     * </p>
     * @param array<TKey, TValueReplacement> ...$replacements<p>
     * Arrays from which elements will be extracted.
     *
     * Values from later arrays overwrite the previous values.
     * </p>

     * @return array<TKey, TValueOriginal|TValueReplacement> The resulting array.
     */
    public static function replaceRecursive (array $array, array ...$replacements):array {

        /** @var array<TKey, TValueOriginal|TValueReplacement> */
        return array_replace_recursive($array, ...$replacements);

    }

}