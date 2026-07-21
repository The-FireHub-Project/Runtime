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

namespace FireHub\Runtime\ObjectModel;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function spl_object_hash;
use function spl_object_id;

/**
 * ### Object Identity Management
 *
 * Provides low-level utilities for retrieving unique runtime identifiers and hashes of object instances.
 *
 * This component exposes native PHP object identity operations used for object comparison, tracking, and indexing.
 * @since 1.0.0
 */
final class Identity extends NativeRuntime {

    /**
     * ### Return the integer object handle for a given object
     *
     * This function returns a unique identifier for the object.
     *
     * The object id is unique for the lifetime of the object.
     *
     * Once the object is destroyed, its id may be reused for other objects.
     *
     * This behavior is similar to Identity#hash().
     * @since 1.0.0
     *
     * @param object $object <p>
     * Any object.
     * </p>
     *
     * @return positive-int An integer identifier that is unique for each currently existing object and is always
     * the same for each object.
     *
     * @note When an object is destroyed, its id may be reused for other objects.
     */
    public static function id (object $object):int {

        /** @var positive-int */
        return spl_object_id($object);

    }

    /**
     * ### Return hash id for a given object
     *
     * This function returns a unique identifier for the object.
     *
     * This id can be used as a hash key for storing objects or for identifying an object, as long as the object is
     * not destroyed.
     *
     * Once the object is destroyed, its hash may be reused for other objects.
     * @since 1.0.0
     *
     * @param object $object <p>
     * Any object.
     * </p>
     *
     * @return non-empty-string A string that is unique for each currently existing object and is always the same
     * for each object.
     *
     * @note When an object is destroyed, its hash may be reused for other objects.
     * @note Object hashes should be compared for identity with === and !==, because the returned hash could be a
     * numeric string.
     * For example, 0000000000000e600000000000000000.
     */
    public static function hash (object $object):string {

        /** @var non-empty-string */
        return spl_object_hash($object);

    }

}