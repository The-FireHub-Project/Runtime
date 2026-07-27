<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.4
 * @package Runtime
 */

namespace FireHub\Runtime;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Type\Data\Type;
use FireHub\Runtime\Exception\ {
    ArrayToStringConversionException, CannotSerializeException, CannotUnserializeException,
    FailedToConvertTypeException, ResourceTypeConversionException
};
use Throwable;

use function get_debug_type;
use function gettype;
use function serialize;
use function settype;
use function unserialize;

/**
 * ### PHP Data Runtime Utility
 *
 * Provides low-level runtime utilities for inspecting, converting, serializing, and manipulating native PHP data
 * values while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for common PHP data operations
 * without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Data extends NativeRuntime {

    /**
     * ### Gets the type name of a variable in a way that is suitable for debugging
     *
     * - null
     * - bool
     * - int
     * - float
     * - string
     * - array
     * - resource (stream)
     * - resource (closed)
     * - stdClass
     * - class(at)anonymous
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * The variable being type-checked.
     * </p>
     *
     * @return string Type name.
     */
    public static function getDebugType (mixed $value):string {

        return get_debug_type($value);

    }

    /**
     * ### Gets data type
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * The variable being type-checked.
     * </p>
     *
     * @return \FireHub\Runtime\Type\Data\Type Type of data.
     */
    public static function getType (mixed $value):Type {

        return Type::from(gettype($value));

    }

    /**
     * ### Sets data type
     * @since 1.0.0
     *
     * @uses self::getType() To get the $value type.
     * @uses \FireHub\Runtime\Type\Data\Type::STRING As a data type.
     * @uses \FireHub\Runtime\Type\Data\Type::RESOURCE As a data type.
     * @uses \FireHub\Runtime\Type\Data\Type::CLOSED_RESOURCE As a data type.
     *
     * @param mixed $value <p>
     * The variable being converted to type.
     * </p>
     * @param \FireHub\Runtime\Type\Data\Type $type <p>
     * Type to convert variable to.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ArrayToStringConversionException If the $type is Type::ARRAY.
     * @throws \FireHub\Runtime\Exception\ResourceTypeConversionException If the $type is Type::RESOURCE or Type::CLOSED_RESOURCE.
     * @throws \FireHub\Runtime\Exception\FailedToConvertTypeException If the conversion fails.
     *
     * @return (
     *  $type is Type::ARRAY
     *  ? array<array-key, mixed>
     *  : ($type is Type::STRING
     *    ? string
     *    : ($type is Type::INT
     *      ? int
     *      : ($type is Type::FLOAT
     *        ? float
     *        : ($type is Type::OBJECT
     *          ? object
     *          : ($type is Type::BOOL
     *            ? bool
     *            : ($type is Type::NULL
     *              ? null
     *              : ($type is Type::RESOURCE
     *                ? false
     *                : mixed)))))))
     * ) Converted value.
     */
    public static function setType (mixed $value, Type $type):mixed {

        if ($type === Type::STRING && self::getType($value) === Type::ARRAY)
            throw new ArrayToStringConversionException;

        if ($type === Type::RESOURCE || $type === Type::CLOSED_RESOURCE)
            throw new ResourceTypeConversionException('Cannot convert resource to type.');

        $result = settype($value, $type->value);

        if (!$result) throw new FailedToConvertTypeException('Failed to convert value to type.');

        return $value;

    }

    /**
     * ### Generates storable representation of data
     *
     * Generates a storable representation of a value.
     *
     * This is useful for storing or passing PHP values around without losing their type and structure.
     * To make the serialized string into a PHP value again, use Data::unserialize().
     * @since 1.0.0
     *
     * @param null|scalar|array<array-key, mixed>|object $value <p>
     * The value is to be serialized.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\CannotSerializeException If try to serialize an anonymous class,
     * function, or resource.
     *
     * @return string String containing a byte-stream representation of a value that can be stored anywhere.
     *
     * @warning When Data::serialize() serializes objects, the leading backslash is not included in the class name
     * of namespaced classes for maximum compatibility.
     * @note This is a binary string that may include null bytes and needs to be stored and handled as such.
     * For example, Data::serialize() output should generally be stored in a BLOB field in a database, rather than
     * a CHAR or TEXT field.
     */
    public static function serialize (null|string|int|float|bool|array|object $value):string {

        try {

            return serialize($value);

        } catch (Throwable $error) {

            throw new CannotSerializeException(
                'Failed to serialize value.',
                previous: $error);

        }

    }

    /**
     * ### Creates a PHP value from a stored representation
     * @since 1.0.0
     *
     * @param non-empty-string $data <p>
     * The serialized string.
     * </p>
     * @param bool|class-string[] $allowed_classes [optional] <p>
     * Either an array of class names which should be accepted, false to accept no classes, or true to accept all
     * classes.
     * </p>
     * @param int $max_depth [optional] <p>
     * The maximum depth of structures is permitted during unserialization and is intended to prevent stack overflows.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\CannotUnserializeException If couldn't unserialize data, $data is already
     * false, or $data is NULL.
     *
     * @return mixed The converted value is returned.
     */
    public static function unserialize (string $data, bool|array $allowed_classes = false, int $max_depth = 4096):mixed {

        if ($data === 'b:0;' || $data === 'N;') throw new CannotUnserializeException;

        return ($unserialized_data = unserialize(
            $data,
            ['allowed_classes' => $allowed_classes, 'max_depth' => $max_depth]) // @phpstan-ignore argument.type
        ) !== false
            ? $unserialized_data
            : throw new CannotUnserializeException;

    }

}