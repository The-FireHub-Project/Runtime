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

namespace FireHub\Runtime\Stream;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function stream_context_create;
use function stream_context_get_default;
use function stream_context_get_options;
use function stream_context_get_params;
use function stream_context_set_default;
use function stream_context_set_options;
use function stream_context_set_params;

/**
 * ### PHP Runtime Stream Context Utilities
 *
 * Provides low-level wrappers for creating, retrieving, and configuring PHP stream contexts.
 *
 * Stream contexts define options and parameters used by stream wrappers when opening or operating on streams.
 *
 * This class preserves native PHP stream context behavior.
 * @since 1.0.0
 */
final readonly class Context extends NativeRuntime {

    /**
     * ### Creates a stream context
     *
     * Creates a stream context with the specified options and parameters.
     * @since 1.0.0
     *
     * @param array<string, array<string, mixed>> $options [optional] <p>
     * Associative array of wrapper-specific context options.
     * </p>
     * @param array<string, mixed> $params [optional] <p>
     * Associative array of context parameters.
     * </p>
     *
     * @return resource Stream context resource.
     */
    public static function create (array $options = [], array $params = []):mixed {

        return stream_context_create($options, $params);

    }

    /**
     * ### Gets the default stream context
     *
     * Returns the default stream context, optionally updating its options.
     * @since 1.0.0
     *
     * @param array<string, array<string, mixed>> $options [optional] <p>
     * Context options to apply to the default context.
     * </p>
     *
     * @return resource Default stream context resource.
     */
    public static function getDefault (array $options = []):mixed {

        return stream_context_get_default($options);

    }

    /**
     * ### Gets stream context options
     *
     * Returns the options configured for the specified stream or context.
     * @since 1.0.0
     *
     * @param resource $context <p>
     * Stream or stream context resource.
     * </p>
     *
     * @return array<string, array<string, mixed>> Stream context options.
     */
    public static function getOptions (mixed $context):array {

        /** @var array<string, array<string, mixed>> */
        return stream_context_get_options($context);

    }

    /**
     * ### Gets stream context parameters
     *
     * Returns the parameters and options associated with a stream or stream context.
     * @since 1.0.0
     *
     * @param resource $context <p>
     * Stream or stream context resource.
     * </p>
     *
     * @return array<string, mixed> Stream context parameters.
     */
    public static function getParams (mixed $context):array {

        return stream_context_get_params($context);

    }

    /**
     * ### Sets the default stream context
     *
     * Updates the default stream context using the specified options.
     *
     * The changes affect later operations that use the default stream context.
     * @since 1.0.0
     *
     * @param array<string, array<string, mixed>> $options <p>
     * Wrapper-specific context options.
     * </p>
     *
     * @return resource Default stream context resource.
     */
    public static function setDefault (array $options):mixed {

        return stream_context_set_default($options);

    }

    /**
     * ### Sets a stream context option
     *
     * Configures an option for the specified stream context.
     * @since 1.0.0
     *
     * @param resource $context <p>
     * Stream or stream context resource.
     * </p>
     * @param array<string, array<string, mixed>> $options <p>
     * Associative array of context options.
     * </p>
     *
     * @return true Always returns true.
     */
    public static function setOptions (mixed $context, array $options):true {

        return stream_context_set_options($context, $options);

    }

    /**
     * ### Sets stream context parameters
     *
     * Updates the parameters associated with the specified stream context.
     * @since 1.0.0
     *
     * @param resource $context <p>
     * Stream or stream context resource.
     * </p>
     * @param array<string, mixed> $params <p>
     * Context parameters to apply.
     * </p>
     *
     * @return true Always returns true.
     */
    public static function setParams (mixed $context, array $params):true {

        return stream_context_set_params($context, $params);

    }

}