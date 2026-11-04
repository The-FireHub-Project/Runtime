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

namespace FireHub\Runtime\Stream;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Stream\Enum\FilterFlag;

use function stream_filter_append;
use function stream_filter_prepend;
use function stream_filter_remove;
use function stream_get_filters;
use function stream_filter_register;

/**
 * ### PHP Runtime Stream Filter Utilities
 *
 * Provides low-level wrappers for managing PHP stream filters.
 *
 * Stream filters allow data to be processed while reading from or writing to a stream. Filters can transform,
 * encode, decode, or otherwise modify data passing through a stream.
 *
 * This component preserves native PHP stream filter behavior.
 * @since 1.0.0
 */
final readonly class Filter extends NativeRuntime {

    /**
     * ### Appends a filter to a stream
     *
     * Adds a filter to the end of the specified stream's filter chain.
     *
     * The filter processes data when the stream is read from or written to, depending on the specified read/write mode.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource to which the filter will be attached.
     * </p>
     * @param string $filter_name <p>
     * Name of the filter to append.
     * </p>
     * @param \FireHub\Runtime\Stream\Enum\FilterFlag $flag [optional] <p>
     * Read and write filter modes.
     * </p>
     * @param mixed $params [optional] <p>
     * Optional filter parameters.
     * </p>
     *
     * @return resource|false Filter resource on success, false on failure.
     */
    public static function append (mixed $stream, string $filter_name, FilterFlag $flag = FilterFlag::READ_WRITE, mixed $params = null):mixed {

        return stream_filter_append($stream, $filter_name, $flag->value, $params);

    }

    /**
     * ### Prepends a filter to a stream
     *
     * Adds a filter to the beginning of the specified stream's filter chain.
     *
     * The filter processes data before filters are already attached to the same filter chain.
     * @since 1.0.0
     *
     * @param resource $stream <p>
     * Stream resource to which the filter will be attached.
     * </p>
     * @param string $filter_name <p>
     * Name of the filter to prepend.
     * </p>
     * @param \FireHub\Runtime\Stream\Enum\FilterFlag $flag [optional] <p>
     * Read and write filter modes.
     * </p>
     * @param mixed $params [optional] <p>
     * Optional filter parameters.
     * </p>
     *
     * @return resource|false Filter resource on success, false on failure.
     */
    public static function prepend (mixed $stream, string $filter_name, FilterFlag $flag = FilterFlag::READ_WRITE, mixed $params = null):mixed {

        return stream_filter_prepend($stream, $filter_name, $flag->value, $params);

    }

    /**
     * ### Removes a filter from a stream
     *
     * Removes a previously attached filter from its stream.
     *
     * Any buffered data remaining in the filter may be flushed before the filter is removed.
     * @since 1.0.0
     *
     * @param resource $filter <p>
     * Filter resource returned by append() or prepend().
     * </p>
     *
     * @return bool True on success, false on failure.
     */
    public static function remove (mixed $filter):bool {

        return stream_filter_remove($filter);

    }

    /**
     * ### Gets registered stream filters
     *
     * Returns the names of all stream filters registered in the current PHP environment.
     * @since 1.0.0
     *
     * @return list<string> Registered stream filter names.
     */
    public static function get ():array {

        return stream_get_filters();

    }

    /**
     * ### Registers a user-defined stream filter
     *
     * Registers a custom stream filter under the specified name.
     *
     * The filter class must extend the native PHP php_user_filter class.
     * @since 1.0.0
     *
     * @param string $filter_name <p>
     * Name under which the filter will be registered.
     * </p>
     * @param class-string<\php_user_filter> $class <p>
     * Fully qualified name of the filter implementation class.
     * </p>
     *
     * @return bool True on success, false on failure.
     */
    public static function register (string $filter_name, string $class):bool {

        return stream_filter_register($filter_name, $class);

    }

}