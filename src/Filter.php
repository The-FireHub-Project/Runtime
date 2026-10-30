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

use function filter_has_var;
use function filter_id;
use function filter_input;
use function filter_input_array;
use function filter_list;
use function filter_var;
use function filter_var_array;

/**
 * ### PHP Runtime Filter Utilities
 *
 * Provides low-level wrappers for native PHP filtering functions.
 *
 * Supports validation, sanitization, and inspection of filter types.
 * @since 1.0.0
 */
final readonly class Filter extends NativeRuntime {

    /**
     * ### Filters a variable with a specified filter
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * Value to filter.
     * </p>
     * @param int $filter [optional] <p>
     * The filter to apply. Can be a validation filter by using one of the FILTER_VALIDATE_* constants, a
     * sanitization filter by using one of the FILTER_SANITIZE_* or FILTER_UNSAFE_RAW, or a custom filter by using
     * FILTER_CALLBACK.
     * </p>
     * @param array<string, mixed>|int $options [optional] <p>
     *  Either an associative array of options, or a bitmask of filter flag constants FILTER_FLAG_*.
     *
     * If the filter accepts options, flags can be provided by using the "flags" field of array.
     * </p>
     *
     * @return mixed On success returns the filtered data. On failure false is returned, unless the
     * FILTER_NULL_ON_FAILURE flag is used, in which case null is returned.
     */
    public static function value (mixed $value, int $filter = FILTER_UNSAFE_RAW, array|int $options = 0):mixed {

        return filter_var($value, $filter, $options);

    }

    /**
     * ### Gets multiple variables and optionally filters them
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array <p>
     * An associative array containing the data to filter.
     * </p>
     * @param array<array-key, mixed>|int $options [optional] <p>
     * Either an associative array of options, or the filter to apply to each entry, which can either be a validation
     * filter by using one of the FILTER_VALIDATE_* constants, or a sanitization filter by using one of the
     * FILTER_SANITIZE_* constants.
     *
     * The option array is an associative array where the key corresponds to a key in the input array and the
     * associated value is either the filter to apply to this entry, or an associative array describing how and which
     * filter should be applied to this entry.
     *
     * The associative array describing how a filter should be applied must contain the 'filter' key whose associated
     * value is the filter to apply, which can be one of the FILTER_VALIDATE_*, FILTER_SANITIZE_*, FILTER_UNSAFE_RAW,
     * or FILTER_CALLBACK constants. It can optionally contain the 'flags' key which specifies any flags that apply
     * to the filter, and the 'options' key which specifies any options that apply to the filter.
     * </p>
     * @param bool $add_empty [optional] <p>
     * Add missing keys as null to the return value.
     * </p>
     *
     * @return array<array-key, mixed>|false|null On success, an array containing the values of the requested
     * variables. On failure, false is returned. Missing entries from the input array are added to the returned array
     * as null if add_empty is true, and are omitted entirely if it is false. An entry of the returned array will be
     * false if the filter fails, unless the FILTER_NULL_ON_FAILURE flag is used, in which case it will be null. With
     * the FILTER_FORCE_ARRAY flag, that failure value is wrapped in a one element array like any other result.
     *
     * @phpstan-ignore-next-line
     */
    public static function values (array $array, array|int $options = FILTER_UNSAFE_RAW, bool $add_empty = true):array|false|null {

        return filter_var_array($array, $options, $add_empty);

    }

    /**
     * ### Returns the filter ID belonging to a named filter
     * @since 1.0.0
     *
     * @param string $name <p>
     * Name of a filter to get.
     * </p>
     *
     * @return int|false D of a filter on success or false if filter doesn't exist.
     */
    public static function id (string $name):int|false {

        return filter_id($name);

    }

    /**
     * ### Gets a specific external variable by name and optionally filters it
     * @since 1.0.0
     *
     * @param 0|1|2|4|5 $type <p>
     * One of the INPUT_* constants.
     * </p>
     * @param string $name <p>
     * Name of a variable to filter inside the corresponding type superglobal.
     * </p>
     * @param int $filter [optional] <p>
     * The filter to apply. Can be a validation filter by using one of the FILTER_VALIDATE_* constants, a
     * sanitization filter by using one of the FILTER_SANITIZE_* or FILTER_UNSAFE_RAW, or a custom filter by using
     * FILTER_CALLBACK.
     * </p>
     * @param array<string, mixed>|int $options [optional] <p>
     *  Either an associative array of options, or a bitmask of filter flag constants FILTER_FLAG_*.
     *
     * If the filter accepts options, flags can be provided by using the "flags" field of array.
     * </p>
     *
     * @return mixed Value of the requested variable on success, false if the filter fails, or null if the var_name
     * variable is not set. If the flag FILTER_NULL_ON_FAILURE is used, it returns false if the variable is not set
     * and null if the filter fails.
     */
    public static function input (int $type, string $name, int $filter = FILTER_UNSAFE_RAW, array|int $options = 0):mixed {

        return filter_input($type, $name, $filter, $options);

    }

    /**
     * ### Gets external variables and optionally filters them
     * @since 1.0.0
     *
     * @param 0|1|2|4|5 $type <p>
     * One of the INPUT_* constants.
     * </p>
     * @param array<array-key, mixed>|int $options [optional] <p>
     *  Either an associative array of options, or the filter to apply to each entry, which can either be a
     * validation filter by using one of the FILTER_VALIDATE_* constants, or a sanitization filter by using one of
     * the FILTER_SANITIZE_* constants.
     *
     * The option array is an associative array where the key corresponds to a key in the input array and the
     * associated value is either the filter to apply to this entry, or an associative array describing how and which
     * filter should be applied to this entry.
     *
     * The associative array describing how a filter should be applied must contain the 'filter' key whose associated
     * value is the filter to apply, which can be one of the FILTER_VALIDATE_*, FILTER_SANITIZE_*, FILTER_UNSAFE_RAW,
     * or FILTER_CALLBACK constants. It can optionally contain the 'flags' key which specifies any flags that apply
     * to the filter, and the 'options' key which specifies any options that apply to the filter.
     * </p>
     * @param bool $add_empty [optional] <p>
     * Add missing keys as null to the return value.
     * </p>
     *
     * @return array<array-key, mixed>|false|null  On success, an array containing the values of the requested
     * variables. On failure, false is returned. If the input array designated by type is not populated, null is
     * returned instead. Missing entries from the input array are added to the returned array as null if add_empty is
     * true, and are omitted entirely if it is false. Unlike filter_input(), the FILTER_NULL_ON_FAILURE flag does not
     * change this: a missing entry is always null. An entry of the returned array will be false if the filter fails,
     * unless the FILTER_NULL_ON_FAILURE flag is used, in which case it will be null. With the FILTER_FORCE_ARRAY
     * flag, that failure value is wrapped in a one element array like any other result.
     *
     * @phpstan-ignore-next-line
     */
    public static function inputs (int $type, array|int $options = FILTER_UNSAFE_RAW, bool $add_empty = true):array|false|null {

        return filter_input_array($type, $options, $add_empty);

    }

    /**
     * ### Checks if a variable of the specified type exists
     * @since 1.0.0
     *
     * @param int $type <p>
     * One of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV.
     * </p>
     * @param string $name <p>
     * Name of a variable to check.
     * </p>
     *
     * @return bool Returns true on success or false on failure.
     */
    public static function has (int $type, string $name):bool {

        return filter_has_var($type, $name);

    }

    /**
     * ### Returns a list of all supported filters
     * @since 1.0.0
     *
     * @return list<string> Returns an array of names of all supported filters, empty array if there are no such
     * filters. Indexes of this array are not filter IDs, they can be obtained with filter_id() from a name instead.
     */
    public static function all ():array {

        return filter_list();

    }

}