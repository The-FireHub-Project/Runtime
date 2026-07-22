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
use FireHub\Core\Meta\Enum\Order;
use FireHub\Runtime\Type\Arr\ {
    SortFlag, SortType
};

use function array_multisort;
use function arsort;
use function asort;
use function krsort;
use function ksort;
use function rsort;
use function shuffle;
use function sort;
use function uasort;
use function uksort;
use function usort;

/**
 * ### PHP Array Runtime Wrapper Utility - Ordering
 *
 * Provides runtime wrappers for ordering, sorting, and rearranging array elements while preserving native PHP behavior
 * and performance.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for array ordering operations
 * without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Ordering extends NativeRuntime {

    /**
     * ### Sorts array
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Meta\Enum\Order::ASC As default parameter.
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray &$array <p>
     * Array to sort.
     * </p>
     * @param bool $preserve_keys [optional] <p>
     * Whether you want to preserve keys from an original array or not.
     * </p>
     * @param \FireHub\Core\Meta\Enum\Order $order [optional] <p>
     * Order type.
     * </p>
     * @param \FireHub\Runtime\Type\Arr\SortType $type [optional] <p>
     * Sort type.
     * </p>
     * @param \FireHub\Runtime\Type\Arr\SortFlag ...$flags [optional] <p>
     * Sort flags.
     * </p>
     * @phpstan-param-out ($preserve_keys is true ? TArray : list<value-of<TArray>>) $array
     *
     * @return true Always true.
     *
     * @note Resets array's internal pointer to the first element.
     */
    public static function sort (array &$array, bool $preserve_keys = false, Order $order = Order::ASC, SortType $type = SortType::REGULAR, SortFlag ...$flags):true {

        $flags_value = $type->value;

        foreach ($flags as $flag) $flags_value |= $flag->value;

        return $order === Order::ASC
            ? ($preserve_keys
                ? asort($array, $flags_value) // @phpstan-ignore argument.type
                : sort($array, $flags_value)) // @phpstan-ignore argument.type
            : ($preserve_keys
                ? arsort($array, $flags_value) // @phpstan-ignore argument.type
                : rsort($array, $flags_value)); // @phpstan-ignore argument.type

    }

    /**
     * ### Sorts an array by key
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Meta\Enum\Order::ASC As default parameter.
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray &$array <p>
     * Array to sort.
     * </p>
     * @param \FireHub\Core\Meta\Enum\Order $order [optional] <p>
     * Order type.
     * </p>
     * @param \FireHub\Runtime\Type\Arr\SortType $type [optional] <p>
     * Sort type.
     * </p>
     * @param \FireHub\Runtime\Type\Arr\SortFlag ...$flags [optional] <p>
     * Sort flags.
     * </p>
     * @phpstan-param-out TArray $array
     *
     * @return true Always true.
     *
     * @note Resets array's internal pointer to the first element.
     */
    public static function sortByKeys (array &$array, Order $order = Order::ASC, SortType $type = SortType::REGULAR, SortFlag ...$flags):true {

        $flags_value = $type->value;

        foreach ($flags as $flag) $flags_value |= $flag->value;

        return $order === Order::ASC
            ? ksort($array, $flags_value)
            : krsort($array, $flags_value);

    }

    /**
     * ### Sorts an array by values using a user-defined comparison function
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray &$array <p>
     * Array to sort.
     * </p>
     * @param callable(value-of<TArray>, value-of<TArray>):int<-1, 1> $callback <p>
     * The comparison function must return an integer less than, equal to, or greater than zero if the first argument
     * is considered to be respectively less than, equal to, or greater than the second.
     * </p>
     * @param bool $preserve_keys [optional] <p>
     * Whether you want to preserve keys from an original array or not.
     * </p>
     * @phpstan-param-out ($preserve_keys is true ? TArray : list<value-of<TArray>>) $array
     *
     * @return true Always true.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.
     *
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     */
    public static function sortBy (array &$array, callable $callback, bool $preserve_keys = false):true {

        return $preserve_keys
            ? uasort($array, $callback)
            : usort($array, $callback);

    }

    /**
     * ### Sorts an array by key using a user-defined comparison function
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray &$array <p>
     * Array to sort.
     * </p>
     * @param callable(key-of<TArray>, key-of<TArray>):int<-1, 1> $callback <p>
     * The callback comparison function.
     *
     * Function cmp_function should accept two parameters which will be filled by pairs of array keys.
     *
     * The comparison function must return an integer less than, equal to, or greater than zero if the first argument
     * is considered to be respectively less than, equal to, or greater than the second.
     * </p>
     * @phpstan-param-out TArray $array
     *
     * @return true Always true.
     *
     * @note Resets array's internal pointer to the first element.
     */
    public static function sortKeysBy (array &$array, callable $callback):true {

        return uksort($array, $callback);

    }

    /**
     * ### Sort multiple on multidimensional arrays
     * @since 1.0.0
     *
     * @param array<array-key, mixed> &$array <p>
     * An array being sorted.
     * </p>
     *
     * @return true True on success.
     *
     * @caution Associative (string) keys will be maintained, but numeric keys will be re-indexed.
     * @note Resets array's internal pointer to the first element.
     */
    public static function multiSort (array &...$array):bool {

        return array_multisort(...$array);

    }

    /**
     * ### Shuffle array
     *
     * This function shuffles (randomizes the order of the elements in) an array.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray &$array <p>
     * The array.
     * </p>
     * @phpstan-param-out TArray $array
     *
     * @return true Always returns true.
     *
     * @caution This function doesn't generate cryptographically secure values and mustn't be used for cryptographic
     * purposes, or purposes that require returned values to be unguessable.
     * @note This function assigns new keys to the elements in an array.
     * It will remove any existing keys that may have been assigned, rather than reordering the keys.
     * @note Resets array's internal pointer to the first element.
     */
    public static function shuffle (array &$array):true {

        return shuffle($array);

    }

}