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

use const CASE_LOWER;
use const CASE_UPPER;

/**
 * ### Array Key Case Style
 *
 * Defines the casing style applied to array string keys during transformation operations.
 *
 * This type represents the supported key casing modes used by runtime utilities when normalizing array keys while
 * preserving PHP native array behavior.
 * @since 1.0.0
 */
enum KeyCase:int {

    /**
     * ### Lower case
     *
     * Converts all characters in a string to the lower case.
     * <code>
     *   "Hello World" → "hello world"
     * </code>
     * @since 1.0.0
     */
    case LOWER = CASE_LOWER;

    /**
     * ### Upper case
     *
     * Converts all characters in a string to the upper case.
     * <code>
     *   "Hello World" → "HELLO WORLD"
     * </code>
     * @since 1.0.0
     */
    case UPPER = CASE_UPPER;

}