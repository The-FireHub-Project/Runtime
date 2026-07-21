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

namespace FireHub\Runtime;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use Countable;

use function is_array;
use function is_bool;
use function is_callable;
use function is_countable;
use function is_float;
use function is_int;
use function is_iterable;
use function is_numeric;
use function is_object;
use function is_resource;
use function is_scalar;
use function is_string;

/**
 * ### PHP Data Type Inspection Runtime Utility
 *
 * Provides low-level runtime utilities for inspecting PHP values and determining their native data types using
 * built-in type checking operations while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for validating value types
 * without introducing conversion, transformation, or additional abstraction logic.
 * @since 1.0.0
 */
final class DataIs extends NativeRuntime {

    /**
     * ### Checks whether the value is an array
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * Value to check.
     * </p>
     *
     * @phpstan-assert array<array-key, mixed> $value
     * @phpstan-assert-if-false !array<array-key, mixed> $value
     *
     * @return bool True if the value is an array, false otherwise.
     */
    public static function array (mixed $value):bool {

        return is_array($value);

    }

    /**
     * ### Checks whether the value is boolean
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * Value to check.
     * </p>
     *
     * @phpstan-assert bool $value
     * @phpstan-assert-if-false !bool $value
     *
     * @return bool True if the value is boolean, false otherwise.
     */
    public static function bool (mixed $value):bool {

        return is_bool($value);

    }

    /**
     * ### Checks whether the value can be called as a function
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * Value to check.
     * </p>
     *
     * @phpstan-assert callable $value
     * @phpstan-assert-if-false !callable $value
     *
     * @return bool True if the value is callable, false otherwise.
     */
    public static function callable (mixed $value):bool {

        return is_callable($value);

    }

    /**
     * ### Checks whether the value is a countable value
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * Value to check.
     * </p>
     *
     * @phpstan-assert array<array-key, mixed>|Countable $value
     * @phpstan-assert-if-false !(array<array-key, mixed>|Countable) $value
     *
     * @return bool True if value is countable, false otherwise.
     */
    public static function countable (mixed $value):bool {

        return is_countable($value);

    }

    /**
     * ### Checks whether the value is a float
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * Value to check.
     * </p>
     *
     * @phpstan-assert float $value
     * @phpstan-assert-if-false !float $value
     *
     * @return bool True if value is float, false otherwise.
     */
    public static function float (mixed $value):bool {

        return is_float($value);

    }

    /**
     * ### Checks whether the value is an integer
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * Value to check.
     * </p>
     *
     * @phpstan-assert int $value
     * @phpstan-assert-if-false !int $value
     *
     * @return bool True if the value is integer, false otherwise.
     */
    public static function int (mixed $value):bool {

        return is_int($value);

    }

    /**
     * ### Checks whether the value is an iterable value
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * Value to check.
     * </p>
     *
     * @phpstan-assert iterable<mixed, mixed> $value
     * @phpstan-assert-if-false !iterable<mixed, mixed> $value
     *
     * @return bool True if value is iterable, false otherwise.
     */
    public static function iterable (mixed $value):bool {

        return is_iterable($value);

    }

    /**
     * ### Checks whether the value is null
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * Value to check.
     * </p>
     *
     * @phpstan-assert null $value
     * @phpstan-assert-if-false !null $value
     *
     * @return bool True if the value is null, false otherwise.
     */
    public static function null (mixed $value):bool {

        return null === $value;

    }

    /**
     * ### Checks whether the value is a number or a numeric string
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * Value to check.
     * </p>
     *
     * @phpstan-assert int|float|numeric-string $value
     * @phpstan-assert-if-false !(int|float|numeric-string) $value
     *
     * @return bool True if the value is numeric, false otherwise.
     */
    public static function numeric (mixed $value):bool {

        return is_numeric($value);

    }

    /**
     * ### Checks whether the value is an object
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * Value to check.
     * </p>
     *
     * @phpstan-assert object $value
     * @phpstan-assert-if-false !object $value
     *
     * @return bool True if value is an object, false otherwise.
     */
    public static function object (mixed $value):bool {

        return is_object($value);

    }

    /**
     * ### Checks whether the value is a resource
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * Value to check.
     * </p>
     *
     * @phpstan-assert resource $value
     * @phpstan-assert-if-false !resource $value
     *
     * @return bool True if value is a resource, false otherwise, or if the resource is closed.
     */
    public static function resource (mixed $value):bool {

        return is_resource($value);

    }

    /**
     * ### Checks whether the value is a scalar
     *
     * Scalar values include: string, int, float, and bool.
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * Value to check.
     * </p>
     *
     * @phpstan-assert scalar $value
     * @phpstan-assert-if-false !scalar $value
     *
     * @return bool True if the value is scalar, false otherwise.
     */
    public static function scalar (mixed $value):bool {

        return is_scalar($value);

    }

    /**
     * ### Checks whether the value is a string
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * Value to check.
     * </p>
     *
     * @phpstan-assert string $value
     * @phpstan-assert-if-false !string $value
     *
     * @return bool True if value is string, false otherwise.
     */
    public static function string (mixed $value):bool {

        return is_string($value);

    }

}