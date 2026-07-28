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

namespace FireHub\Runtime\Type\Data;

/**
 * ### PHP Runtime Data Category
 *
 * Represents the category classification of native PHP runtime data types.
 *
 * This enum groups PHP data types by their value structure and runtime behavior, allowing consistent
 * classification of values across the FireHub Runtime layer.
 * @since 1.0.0
 */
enum Category {

    /**
     * ### Scalar data category
     *
     * Represents data types that contain a single value:
     * booleans, integers, floats, and strings.
     * @since 1.0.0
     */
    case SCALAR;

    /**
     * ### Compound data category
     *
     * Represents data types that can contain multiple values or structures:
     * arrays and objects.
     * @since 1.0.0
     */
    case COMPOUND;

    /**
     * ### Special data category
     *
     * Represents data types with special runtime behavior:
     * null and resources.
     * @since 1.0.0
     */
    case SPECIAL;

}