<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.2
 * @package Runtime
 */

namespace FireHub\Runtime;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use Traversable;

use function iterator_apply;
use function iterator_count;
use function iterator_to_array;

/**
 * ### PHP Runtime Iterator Utilities
 *
 * Provides low-level wrappers for processing and converting iterator objects using native PHP iterator functions
 * while preserving native runtime behavior.
 *
 * This component exposes iterator traversal and conversion capabilities through a consistent FireHub Runtime API
 * without altering PHP iterator semantics.
 * @since 1.0.0
 */
final class Iterator extends NativeRuntime {

    /**
     * ### Copy the iterator into an array
     *
     * Copy the elements of an iterator into an array.
     * @since 1.0.0
     *
     * @template TKey
     * @template TValue
     *
     * @param iterable<TKey, TValue> $iterator <p>
     * The iterator being copied.
     * </p>
     * @param bool $preserve_keys [optional] <p>
     * Whether to use the iterator element keys as index.
     *
     * If a key is an array or object, a warning will be generated.
     *
     * Null keys will be converted to an empty string, float keys will be truncated to their int counterpart,
     * resource keys will generate a warning and be converted to their resource ID, and bool keys will be converted
     * to integers.
     * </p>
     *
     * @return ($preserve_keys is true ? array<(int&TKey)|(string&TKey), TValue> : list<TValue>) An array containing
     * items of the iterator.
     *
     * @note If this parameter $preserve_keys is not set or set to true, duplicate keys will be overwritten.
     * The last value with a given key will be in the returned array.
     * Set this parameter as false to get all the values in any case.
     */
    public static function toArray (iterable $iterator, bool $preserve_keys = true):array {

        return iterator_to_array($iterator, $preserve_keys); // @phpstan-ignore return.type

    }

    /**
     * ### Count the elements in an iterator
     *
     * Count the elements in an iterator.
     *
     * Method is not guaranteed to retain the current position of the iterator.
     * @since 1.0.0
     *
     * @param iterable<mixed, mixed> $iterator <p>
     * The iterator being counted.
     * </p>
     *
     * @return non-negative-int Number of elements in iterator.
     */
    public static function count (iterable $iterator):int {

        return iterator_count($iterator);

    }

    /**
     * ### Call a function for every element in an iterator
     * @since 1.0.0
     *
     * @template TKey
     * @template TValue
     *
     * @param Traversable<TKey, TValue> $iterator <p>
     * The iterator objects to iterate over.
     * </p>
     * @param callable(mixed...):bool $callback <p>
     * The callback function to call on every element.
     *
     * The function must return true to continue iterating over the iterator.
     * </p>
     * @param null|array<array-key, mixed> $arguments <p>
     * An array of arguments; each element of args is passed to the callback as a separate argument.
     * </p>
     *
     * @return int Iteration count.
     */
    public static function apply (Traversable $iterator, callable $callback, ?array $arguments = null):int {

        return iterator_apply($iterator, $callback, $arguments);

    }

}