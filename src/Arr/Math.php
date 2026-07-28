<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.0
 * @package Runtime
 */

namespace FireHub\Runtime\Arr;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function array_product;
use function array_sum;

/**
 * ### PHP Array Runtime Wrapper Utility - Math
 *
 * Provides runtime wrappers for performing mathematical operations on arrays, including aggregation and calculation
 * of numerical values while preserving native PHP behavior.
 *
 * This component is part of the FireHub Runtime layer and provides a consistent API for array mathematical operations
 * without introducing domain logic, framework coupling, or additional abstraction overhead.
 * @since 1.0.0
 */
final class Math extends NativeRuntime {

    /**
     * ### Calculate the product of values in an array
     *
     * Returns the product of values in an array.
     * @since 1.0.0
     *
     * @template TValue of int|float
     *
     * @param array<array-key, TValue> $array <p>
     * The array.
     * </p>
     *
     * @return int|float The product as an integer or float.
     */
    public static function product (array $array):int|float {

        return array_product($array);

    }

    /**
     * ### Calculate the sum of values in an array
     * @since 1.0.0
     *
     * @template TValue of int|float
     *
     * @param array<array-key, TValue> $array <p>
     * The input array.
     * </p>
     *
     * @return int|float The sum of values as an integer or float; 0 if the array is empty.
     */
    public static function sum (array $array):int|float {

        return array_sum($array);

    }

}