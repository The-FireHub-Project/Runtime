<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.3
 * @package Runtime
 */

namespace FireHub\Runtime\Arr;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Exception\ {
    InvalidArrayLengthException, InvalidChunkLengthException, InvalidRangeStepException
};

use function array_chunk;
use function array_fill;
use function array_fill_keys;
use function array_pad;
use function array_slice;
use function array_splice;
use function range;

/**
 * ### PHP Array Runtime Wrapper Utility - Transform
 *
 * The Structure class provides lightweight, deterministic wrappers for creating and restructuring PHP arrays.
 *
 * It contains common runtime operations for defining array shapes, combining arrays, filling arrays with values,
 * padding arrays, extracting segments, replacing portions, and generating sequential value ranges while preserving
 * native PHP behavior and performance.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for array structure operations
 * without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Structure extends NativeRuntime {

    /**
     * ### Split an array into chunks
     *
     * Chunks an array into arrays with $length elements.
     *
     * The last chunk may contain less than $length elements.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * The array.
     * </p>
     * @param positive-int $length <p>
     * The size of each chunk.
     * Must be greater than zero.
     * </p>
     * @param bool $preserve_keys [optional] <p>
     * When set to true, keys will be preserved.
     *
     * Default is false that will reindex the chunk numerically.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidChunkLengthException If the length is less than 1.
     *
     * @return ($preserve_keys is true ? list<array<TKey, TValue>> : list<list<TValue>>) Multidimensional numerically
     * indexed array, starting with zero, with each dimension contains $length elements.
     */
    public static function chunk (array $array, int $length, bool $preserve_keys = false):array {

        if ($length < 1) {
            throw new InvalidChunkLengthException(
                'The length of each chunk must be a positive integer.',
                [
                    'length' => $length,
                    'minimum' => 1,
                ]
            );
        }

        return array_chunk($array, $length, $preserve_keys);

    }

    /**
     * ### Fill an array with values
     *
     * Fills an array with $length entries of the value for the $value parameter, keys starting at the $start_index
     * parameter.
     * @since 1.0.0
     *
     * @template TValue
     *
     * @param TValue $value <p>
     * Value to use for filling.
     * </p>
     * @param int $start_index <p>
     * The first index of the returned array.
     * </p>
     * @param positive-int $length <p>
     * Number of elements to insert. Must be greater than or equal to zero.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidArrayLengthException If $length is invalid.
     *
     * @return array<int, TValue> Filled array.
     */
    public static function fill (mixed $value, int $start_index, int $length):array {

        if ($length < 1) {
            throw new InvalidArrayLengthException(
                'The array length must be greater than zero.',
                [
                    'length' => $length,
                    'minimum' => 1,
                ]
            );
        }

        return array_fill($start_index, $length, $value);

    }

    /**
     * ### Fill an array with values, specifying keys
     *
     * Fills an array with the value of the $value parameter, using the values of the $keys array as keys.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<array-key, TKey> $keys <p>
     * Array of values that will be used as keys.
     *
     * Illegal values for a key will be converted to string.
     * </p>
     * @param TValue $value <p>
     * Value to use for filling.
     * </p>
     *
     * @return array<TKey, TValue> The filled array.
     */
    public static function fillKeys (array $keys, mixed $value):array {

        return array_fill_keys($keys, $value);

    }

    /**
     * ### Pad array to the specified length with a value
     *
     * Returns a copy of the array padded to the size specified by $length with $value.
     * If the length is positive, then the array is padded on the right if it is negative, then on the left.
     * If the absolute value of a length is less than or equal to the length of the array, then no padding takes place.
     * @since 1.0.0
     *
     * @template TValue
     * @template TPaddedValue
     *
     * @param array<array-key, TValue> $array <p>
     * Initial array of values to pad.
     * </p>
     * @param int $length <p>
     * New size of the array.
     * If the length is positive, then the array is padded on the right if it is negative, then on the left.
     *
     * If the absolute value of a length is less than or equal to the length of the array, then no padding takes place.
     *
     * </p>
     * @param TPaddedValue $value <p>
     * Value to pad if input is less than length.
     * </p>
     *
     * @return array<array-key, TValue|TPaddedValue> A copy of the input padded to the size specified by $length with
     * value $value.
     *
     * @caution Keys can be re-numbered.
     */
    public static function pad (array $array, int $length, mixed $value):array {

        return array_pad($array, $length, $value);

    }

    /**
     * ### Extract a slice of the array
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * The input array.
     * </p>
     * @param int $offset <p>
     * If the offset is non-negative, the sequence will start at that offset in the array.
     *
     * If the offset is negative, the sequence will start that far from the end of the array.
     * </p>
     * @param null|int $length [optional] <p>
     * If length is given and is positive, then the sequence will have that many elements in it.
     *
     * If length is given and is negative, then the sequence will stop that many elements from the end of the array.
     *
     * If it is omitted, then the sequence will have everything from offset up until the end of the array.
     * </p>
     * @param bool $preserve_keys [optional] <p>
     * Note that array_slice will reorder and reset the array indices by default.
     *
     * You can change this behavior by setting preserve_keys to true.
     * </p>
     *
     * @return ( $preserve_keys is true
     *  ? array<TKey, TValue>
     *  : ($array is list
     *    ? list<TValue>
     *    : array<array-key, TValue>)
     * ) Converted value.
     *
     * @note Named keys will always retain their name.
     */
    public static function slice (array $array, int $offset, ?int $length = null, bool $preserve_keys = false):array {

        return array_slice($array, $offset, $length, $preserve_keys);

    }

    /**
     * ### Remove a portion of the array and replace it with something else
     *
     * Removes the elements designated by offset and length from the parameter $array and replaces them with the
     * elements of the replacement array, if supplied.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     * @template TReplacedValue
     *
     * @param array<TKey, TValue> &$array <p>
     * Array to splice.
     * </p>
     * @param int $offset <p>
     * If the offset is positive, then the start of the removed portion is at that offset from the beginning of the
     * input array.
     *
     * If the offset is negative, then it starts that far from the end of the input array.
     * </p>
     * @param null|int $length [optional] <p>
     * If the length is omitted, removes everything from offset to the end of the array.
     *
     * If the length is specified and is positive, then that many elements will be removed.
     *
     * If the length is specified and is negative, then the end of the removed portion will be that many elements from
     * the end of the array.
     * </p>
     * @param TReplacedValue $replacement [optional] <p>
     * If a replacement array is specified, then the removed elements will be replaced with elements from this array.
     *
     * If offset and length are such that nothing is removed, then the elements from the replacement array or array
     * are inserted in the place specified by the offset.
     *
     * Keys in a replacement array aren't preserved.
     * </p>
     * @phpstan-param-out ($array is list ? list<TValue|TReplacedValue> : array<TValue|TReplacedValue>) $array
     *
     * @return array<TKey, TValue> Spliced array.
     *
     * @note Numerical keys in an array aren't preserved.
     *
     * @note If the replacement is not an array, it will be typecast to one (in other words (array) $replacement).
     *
     * This may result in unexpected behavior when using an object or null replacement.
     */
    public static function splice (array &$array, int $offset, ?int $length = null, mixed $replacement = []):array {

        return array_splice($array, $offset, $length, $replacement); // @phpstan-ignore paramOut.type

    }

    /**
     * ### Create an array containing a range of elements
     * @since 1.0.0
     *
     * @template TStart of int|float|string
     * @template TEnd of int|float|string
     * @template TStep of int|float
     *
     * @param TStart $start <p>
     * First value of the sequence.
     * </p>
     * @param TEnd $end <p>
     * The sequence is ended upon reaching the end value.
     * </p>
     * @param TStep $step [optional] <p>
     * If a step value is given, it will be used as the increment between elements in the sequence.
     *
     * Step should be given as a positive number. If not specified, a step will default to 1.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidRangeStepException If the step is zero or range step must be greater
     * than zero when the start is greater than the end.
     *
     * @return (TStart is string
     *  ? array<int, string>
     *    : (TEnd is string
     *      ? array<int, string>
     *      : (TStart is float
     *        ? array<int, float>
     *        : (TEnd is float
     *          ? array<int, float>
     *          : (TStep is float
     *            ? array<int, float>
     *            : array<int, int>))))
     * ) Sequence of elements as an array with the first element being start going up to end, with each value of the
     * sequence being step values apart.
     *
     * @note Character sequence values are limited to a length of one.
     *
     * If a length greater than one is entered only the first character is used.
     */
    public static function range (int|float|string $start, int|float|string $end, int|float $step = 1):array {

        if ($step === 0) throw new InvalidRangeStepException('The range step must not be zero.');

        if ($end > $start && $step < 0) {
            throw new InvalidRangeStepException(
                'The range step must be greater than zero when the start is greater than the end.'
            );
        }

        return range($start, $end, $step);

    }

}