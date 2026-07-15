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

use const SORT_LOCALE_STRING;
use const SORT_NATURAL;
use const SORT_NUMERIC;
use const SORT_REGULAR;
use const SORT_STRING;

/**
 * ### Array Sorting Type
 *
 * Defines the comparison type used by array sorting functions.
 *
 * This enum represents PHP sorting comparison modes and provides a type-safe way to specify how array values are
 * compared during sorting operations.
 *
 * @since 1.0.0
 */
enum SortType:int {

    /**
     * ### Regular comparison
     *
     * Compare items normally.
     * @since 1.0.0
     */
    case REGULAR = SORT_REGULAR;

    /**
     * ### Numeric comparison
     *
     * Compare items numerically.
     * @since 1.0.0
     */
    case NUMERIC = SORT_NUMERIC;

    /**
     * ### String comparison
     *
     * Compare items as strings.
     * @since 1.0.0
     */
    case STRING = SORT_STRING;

    /**
     * ### Locale string comparison
     *
     * Compare items as strings, based on the current locale.
     * @since 1.0.0
     */
    case LOCALE_STRING = SORT_LOCALE_STRING;

    /**
     * ### Natural string comparison
     *
     * Compare items as strings using natural ordering like natsort().
     * @since 1.0.0
     */
    case NATURAL = SORT_NATURAL;

}