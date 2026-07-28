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
 * ### PHP Runtime Data Type
 *
 * Represents the native data types supported by the PHP runtime.
 *
 * This enum provides a type-safe representation of PHP runtime value types for use throughout the FireHub Runtime
 * layer when inspecting, validating, or classifying values without relying on string literals returned by native
 * PHP functions.
 * @since 1.0.0
 */
enum Type:string {

    /**
     * ### A bool expresses a truth value, it can be either true or false
     * @since 1.0.0
     */
    case BOOL = 'boolean';

    /**
     * ### An int is a number of the set Z = {..., -2, -1, 0, 1, 2, ...}
     * @since 1.0.0
     */
    case INT = 'integer';

    /**
     * ### A floating-point number is represented approximately with a fixed number of significant digits
     * @since 1.0.0
     */
    case FLOAT = 'double';

    /**
     * ### A string is a series of characters, where a character is the same as a byte
     * @since 1.0.0
     */
    case STRING = 'string';

    /**
     * ### An ordered map where map is a type that associates values to keys
     * @since 1.0.0
     */
    case ARRAY = 'array';

    /**
     * ### An object is an individual instance of the data structure defined by a class
     * @since 1.0.0
     */
    case OBJECT = 'object';

    /**
     * ### The special null value represents a variable with no value
     * @since 1.0.0
     */
    case NULL = 'NULL';

    /**
     * ### The special resource type is used to store references to some function call or to external PHP resources
     * @since 1.0.0
     */
    case RESOURCE = 'resource';

    /**
     * ### A closed resource represents a previously valid PHP resource that has been closed
     * @since 1.0.0
     */
    case CLOSED_RESOURCE = 'resource (closed)';

    /**
     * ## Gets the data type category
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Type\Data\Category::SCALAR To check if this enum is a scalar type category.
     * @uses \FireHub\Runtime\Type\Data\Category::COMPOUND To check if this enum is a compound type category.
     * @uses \FireHub\Runtime\Type\Data\Category::SPECIAL To check if this enum is a special type category.
     *
     * @return \FireHub\Runtime\Type\Data\Category::* Data type category.
     */
    public function category ():Category {

        return match ($this) {
            self::BOOL, self::INT, self::FLOAT, self::STRING => Category::SCALAR,
            self::ARRAY, self::OBJECT => Category::COMPOUND,
            self::NULL, self::RESOURCE, self::CLOSED_RESOURCE => Category::SPECIAL
        };

    }

    /**
     * ### Checks if this enum is a scalar type category
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Type\Data\Category::category() To get the data type category.
     * @uses \FireHub\Runtime\Type\Data\Category::SCALAR To check if this enum is a scalar type category.
     *
     * @return bool True if this enum is a scalar type category.
     */
    public function isScalar ():bool {

        return $this->category() === Category::SCALAR;

    }

    /**
     * ### Checks if this enum is a compound type category
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Type\Data\Category::category() To get the data type category.
     * @uses \FireHub\Runtime\Type\Data\Category::COMPOUND To check if this enum is a compound type category.
     *
     * @return bool True if this enum is a compound type category.
     */
    public function isCompound ():bool {

        return $this->category() === Category::COMPOUND;

    }

    /**
     * ### Checks if this enum is a special type category
     * @since 1.0.0
     *
     * @uses \FireHub\Runtime\Type\Data\Category::category() To get the data type category.
     * @uses \FireHub\Runtime\Type\Data\Category::SPECIAL To check if this enum is a special type category.
     *
     * @return bool True if this enum is a special type category.
     */
    public function isSpecial ():bool {

        return $this->category() === Category::SPECIAL;

    }

}