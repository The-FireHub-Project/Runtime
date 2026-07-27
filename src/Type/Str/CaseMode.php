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

namespace FireHub\Runtime\Type\Str;

use const MB_CASE_LOWER;
use const MB_CASE_TITLE;
use const MB_CASE_UPPER;

/**
 * ### String Case Conversion Mode
 *
 * Defines the character case conversion mode supported by PHP string transformation functions.
 *
 * This enum represents the supported conversion modes of PHP's multibyte string case conversion operations.
 * @since 1.0.0
 */
enum CaseMode:int {

    /**
     * ### Lowercase conversion
     *
     * Converts all characters in a string to lowercase.
     * @since 1.0.0
     */
    case LOWER = MB_CASE_LOWER;

    /**
     * ### Uppercase conversion
     *
     * Converts all characters in a string to uppercase.
     * @since 1.0.0
     */
    case UPPER = MB_CASE_UPPER;

    /**
     * ### Title case conversion
     *
     * Converts the first character of each word to uppercase.
     * @since 1.0.0
     */
    case TITLE = MB_CASE_TITLE;

}