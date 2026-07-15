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

namespace FireHub\Runtime\Arr;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Type\Arr\ {
    KeyCase, UniqueMode
};

use const ARRAY_FILTER_USE_BOTH;

use function array_change_key_case;
use function array_filter;
use function array_flip;
use function array_map;
use function array_reduce;
use function array_reverse;
use function array_unique;
use function array_walk;
use function array_walk_recursive;

/**
 * ### PHP Array Runtime Wrapper Utility - Transform
 *
 * The Transform class provides lightweight, deterministic wrappers for transforming and modifying PHP arrays.
 *
 * It contains common runtime operations for changing array structure, replacing values, mapping data, filtering
 * elements, and producing transformed array representations while preserving native PHP behavior and performance.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for array transformation
 * operations without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Transform extends NativeRuntime {

    /**
     * ### Iteratively reduce the array to a single value using a callback function
     *
     * Iteratively applies the $callback function to the elements of the $array to reduce the array to a single value.
     * @since 1.0.0
     *
     * @template TValue
     * @template TReturn
     *
     * @param array<array-key, TValue> $array <p>
     * The input array.
     * </p>
     * @param callable(null|TReturn, TValue):TReturn $callback <p>
     * The callable function.
     * </p>
     * @param null|TReturn $initial [optional] <p>
     * If the optional initial is available, it will be used at the beginning of the process, or as a final result in
     * case the array is empty.
     * </p>
     *
     * @return ($initial is null ? null|TReturn : TReturn) Resulting value or null if the array is empty and the
     * initial is not passed.
     */
    public static function reduce (array $array, callable $callback, mixed $initial = null):mixed {

        return func_num_args() < 3
            ? array_reduce($array, $callback)
            : array_reduce($array, $callback, $initial);

    }

    /**
     * ### Changes the case of all keys in an array
     *
     * Returns an array with all keys from an array lowercased or uppercased.
     * Numbered indices are left as is.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Type\Arr\KeyCase::LOWER As default parameter.
     *
     * @template TValue
     *
     * @param array<array-key, TValue> $array <p>
     * The array to work on.
     * </p>
     * @param \FireHub\Runtime\Type\Arr\KeyCase $style [optional] <p>
     * Either LOWER or UPPER key case style.
     * </p>
     *
     * @return array<array-key, TValue> An array with its keys lower or uppercased.
     */
    public static function keyCase (array $array, KeyCase $style = KeyCase::LOWER):array {

        return array_change_key_case($array, $style->value);

    }

    /**
     * ### Filters elements of an array using a callback function
     *
     * Iterates over each value in the $array, passing them to the $callback function.
     *
     * If the $callback function returns true, the current value from an $array is returned into the result array.
     *
     * Array keys are preserved and may result in gaps if the $array was indexed.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * The array to iterate.
     * </p>
     * @param null|callable(TValue, TKey):bool $callback [optional] <p>
     * The callback function to use.
     *
     * If no callback is supplied, all empty and false entries of an array will be removed.
     * </p>
     *
     * @return array<TKey, TValue> Filtered array.
     *
     * @note The result array can be re-indexed using the Arr#values() function.
     * @note If no callback is provided, all falsey values are removed.
     * @caution If the array is changed from the callback function (for example, an element added, deleted, or unset),
     * then the behavior of this function is undefined.
     */
    public static function filter (array $array, ?callable $callback = null):array {

        return array_filter(
            $array,
            $callback ?? static fn(mixed $value): bool => (bool) $value,
            ARRAY_FILTER_USE_BOTH
        );

    }


    /**
     * ### Exchanges all keys with their associated values in an array
     *
     * Returns an array in flip order; in other words, keys from an $array become values, and values from an $array
     * become keys.
     *
     * Note that the values of $array need to be valid keys; in other words, they need to be either int or string.
     *
     * A warning will be emitted if a value has the wrong type, and the key/value pair in question will not be
     * included in the result.
     *
     * If a value has several occurrences, the latest key will be used as its value, and all others will be lost.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue of array-key
     *
     * @param array<TKey, TValue> $array <p>
     * The array to flip.
     * </p>
     *
     * @return array<TValue, TKey> The flipped array.
     */
    public static function flip (array $array):array {

        return array_flip($array);

    }

    /**
     * ### Applies the callback to the elements of the given array
     *
     * Returns an array containing the results of applying the $callback to the corresponding value of an $array
     * used as arguments for the callback.
     *
     * The number of parameters that the $callback function accepts should match the number of arrays passed to
     * Arr#map(). Excess input arrays are ignored.
     *
     * An ArgumentCountError is thrown if an insufficient number of arguments is provided.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     * @template TReturn
     *
     * @param array<TKey, TValue> $array <p>
     * Array to run through the callback function.
     * </p>
     * @param callable(TValue):TReturn $callback <p>
     * Callback function to run for each element in each array.
     *
     * Null can be passed as a value to $callback to perform a zip operation on multiple arrays.
     *
     * If only an array is provided, Arr#map() will return the input array.
     * </p>
     *
     * @return ($array is list
     *  ? list<TReturn>
     *  : array<TKey, TReturn>
     * ) Returns an array containing the results of applying the callback function to the corresponding value of array.
     */
    public static function map (array $array, callable $callback):array {

        return array_map($callback, $array);

    }

    /**
     * ### Apply a user function to every member of an array
     *
     * Applies the user-defined callback function to each element of the array $array.
     *
     * Method is not affected by the internal array pointer of an array.
     *
     * Method will walk through the entire array regardless of pointer position.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     * @template TReturn
     *
     * @param array<TKey, TValue> &$array <p>
     * The array to apply a user function.
     * </p>
     * @param callable(TValue, TKey):TReturn $callback <p>
     * Typically, the function name takes on two parameters.
     *
     * The array parameter's value is the first, and the key/index second.
     *
     * If a function name needs to be working with the actual values of the array, specify the first parameter of the
     * function name as a reference.
     *
     * Then, any changes made to those elements will be made in the original array itself.
     *
     * Users may not change the array itself from the callback function, for example, add/delete elements, unset
     * elements, and so on.
     * </p>
     * @phpstan-param-out array<TKey, TReturn> $array
     *
     * @return true True on success.
     */
    public static function walk (array &$array, callable $callback):true {

        return array_walk($array, $callback); // @phpstan-ignore paramOut.type

    }

    /**
     * ### Apply a user function recursively to every member of an array
     *
     * Applies the user-defined callback function to each element of the array.
     *
     * This function will recurse into deeper arrays.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     * @template TReturn
     *
     * @param array<TKey, TValue> &$array <p>
     * The array to apply a user function.
     * </p>
     * @param callable(TValue, TKey):TReturn $callback <p>
     * Typically, the function name takes on two parameters.
     *
     * The array parameter's value is the first, and the key/index second.
     *
     * If a function name needs to be working with the actual values of the array, specify the first parameter of the
     * function name as a reference.
     *
     * Then, any changes made to those elements will be made in the original array itself.
     *
     * Users may not change the array itself from the callback function.
     *
     * For example, Add/delete elements, unset elements, and so on.
     * </p>
     * @phpstan-param-out array<TKey, TReturn> $array
     *
     * @return true True on success.
     */
    public static function walkRecursive (array &$array, callable $callback):true {

        return array_walk_recursive($array, $callback); // @phpstan-ignore paramOut.type

    }

    /**
     * ### Reverse the order of array items
     *
     * Takes an input array and returns a new array with the order of the elements reversed.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * Array to reverse.
     * </p>
     * @param bool $preserve_keys [optional] <p>
     * Whether you want to preserve keys from an original array or not.
     *
     * Non-numeric keys aren't affected by this setting and will always be preserved.
     * </p>
     *
     * @return ($preserve_keys is true ? array<TKey, TValue> : list<TValue>) The reversed array.
     */
    public static function reverse (array $array, bool $preserve_keys = false):array {

        return array_reverse($array, $preserve_keys);

    }

    /**
     * ### Removes duplicate values from an array
     *
     * Takes an input array and returns a new array without duplicate values.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Type\Arr\UniqueMode::REGULAR As default compare enum.
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * The array to remove duplicates.
     * </p>
     *
     * @return array<TKey, TValue> The filtered array.
     *
     * @note The new array will preserve keys.
     * @note This method is not intended to work on multidimensional arrays.
     */
    public static function unique (array $array, UniqueMode $compare = UniqueMode::REGULAR):array {

        return array_unique($array, $compare->value); // @phpstan-ignore argument.type

    }

}