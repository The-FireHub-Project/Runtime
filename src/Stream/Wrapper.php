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
use FireHub\Runtime\Stream\Enum\WrapperRegistrationFlag;

use function stream_get_wrappers;
use function stream_wrapper_register;
use function stream_wrapper_unregister;
use function stream_wrapper_restore;

/**
 * ### PHP Runtime Stream Wrapper Utilities
 *
 * Provides low-level wrappers for retrieving, registering, unregistering, and restoring PHP stream wrappers.
 *
 * Stream wrappers allow PHP to access resources through custom protocols using standard filesystem and stream
 * functions.
 *
 * This component preserves native PHP stream wrapper behavior.
 * @since 1.0.0
 */
final readonly class Wrapper extends NativeRuntime {

    /**
     * ### Gets registered stream wrappers
     *
     * Returns the names of all stream wrappers registered in the current PHP environment.
     * @since 1.0.0
     *
     * @return list<string> Registered stream wrapper names.
     */
    public static function get ():array {

        return stream_get_wrappers();

    }

    /**
     * ### Registers a stream wrapper
     *
     * Registers a user-defined stream wrapper for the specified protocol.
     *
     * The wrapper class must implement the methods required by the stream operations it intends to support.
     * @since 1.0.0
     *
     * @param string $protocol <p>
     * Protocol name to register.
     * </p>
     * @param class-string $class <p>
     * Fully qualified name of the stream wrapper implementation class.
     * </p>
     * @param WrapperRegistrationFlag $flag [optional] <p>
     * Whether the wrapper represents a URL.
     * </p>
     *
     * @return bool True on success, false on failure.
     */
    public static function register (string $protocol, string $class, WrapperRegistrationFlag $flag = WrapperRegistrationFlag::NONE):bool {

        return stream_wrapper_register($protocol, $class, $flag->value);

    }

    /**
     * ### Unregisters a stream wrapper
     *
     * Removes the stream wrapper associated with the specified protocol.
     *
     * The operation affects later stream operations using that protocol.
     * @since 1.0.0
     *
     * @param string $protocol <p>
     * Protocol name to unregister.
     * </p>
     *
     * @return bool True on success, false on failure.
     */
    public static function unregister (string $protocol):bool {

        return stream_wrapper_unregister($protocol);

    }

    /**
     * ### Restores a previously unregistered stream wrapper
     *
     * Restores a built-in stream wrapper that was previously removed using stream_wrapper_unregister().
     *
     * This function does not restore user-defined stream wrappers.
     * @since 1.0.0
     *
     * @param string $protocol <p>
     * Protocol name to restore.
     * </p>
     *
     * @return bool True on success, false on failure.
     */
    public static function restore (string $protocol):bool {

        return stream_wrapper_restore($protocol);

    }

}