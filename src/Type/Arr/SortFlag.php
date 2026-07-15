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

namespace FireHub\Runtime\Type\Arr;

use const SORT_FLAG_CASE;

/**
 * ### Array Sorting Flag
 *
 * Defines optional modifiers applied to array sorting comparison behavior.
 *
 * Sorting flags can be combined with sorting types using bitwise operations.
 *
 * @since 1.0.0
 */
enum SortFlag:int {

    /**
     * ### Case insensitive comparison
     *
     * Can be combined with SORT_STRING or SORT_NATURAL to compare strings without case sensitivity.
     *
     * @since 1.0.0
     */
    case CASE_INSENSITIVE = SORT_FLAG_CASE;

}