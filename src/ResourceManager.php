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

namespace FireHub\Runtime;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Type\Resource as ResourceType;

use function get_resource_id;
use function get_resource_type;
use function get_resources;

/**
 * ### PHP Runtime Resource Utilities
 *
 * Provides low-level wrappers for inspecting PHP resources, including retrieving resource identifiers, resource types,
 * and currently active resources while preserving native runtime behavior.
 *
 * This component exposes PHP resource management capabilities through a consistent FireHub Runtime API without
 * altering native resource semantics.
 * @since 1.0.0
 */
final class ResourceManager extends NativeRuntime {

    /**
     * ### Returns an integer identifier for the given resource
     *
     * This function provides a type-safe way of generating the integer identifier for a resource.
     * @since 1.0.0
     *
     * @param resource $resource <p>
     * The evaluated resource handle.
     * </p>
     *
     * @return positive-int The identifier for the given resource.
     *
     * @phpstan-ignore class.nameCase
     */
    public static function id (mixed $resource):int {

        /** @var positive-int */
        return get_resource_id($resource);

    }

    /**
     * ### Gets the resource type
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Type\Resource As return.
     * @uses \FireHub\Runtime\Type\Resource::UNKNOWN If the resource type is unknown.
     *
     * @param resource $resource <p>
     * The evaluated resource handle.
     * </p>
     *
     * @return \FireHub\Runtime\Type\Resource Resource type or null if is not a resource.
     */
    public static function type (mixed $resource):ResourceType {

        return ResourceType::tryFrom(get_resource_type($resource) ?? ResourceType::UNKNOWN->value) // @phpstan-ignore nullCoalesce.expr
            ?? ResourceType::UNKNOWN;

    }

    /**
     * ### Get active resources
     *
     * Returns an array of all currently active resources, optionally filtered by resource type.
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Type\Resource::UNKNOWN If the resource type is unknown.
     * @uses \FireHub\Runtime\Arr\Transform::map() To transform the array of resource identifiers into an array of
     * resource types.
     *
     * @param null|\FireHub\Runtime\Type\Resource $type [optional] <p>
     * If defined, this will cause the method to only return resources of the given type.
     * </p>
     *
     * @return array<int, \FireHub\Runtime\Type\Resource> Resource type or null if is not a resource.
     */
    public static function active (?ResourceType $type = null):array {

        return Arr\Transform::map(
            get_resources($type?->value),
            static fn($value) => ResourceType::tryFrom(get_resource_type($value)) ?? ResourceType::UNKNOWN,
        );

    }

}