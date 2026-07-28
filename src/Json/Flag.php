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

namespace FireHub\Runtime\Json;

/**
 * ### PHP Runtime JSON Flags
 *
 * Provides common JSON flags shared across native PHP JSON processing functions, including encoding, decoding, and
 * validation operations while preserving native runtime behavior.
 *
 * This enum exposes reusable JSON configuration flags through a consistent FireHub Runtime API without altering PHP
 * JSON semantics.
 * @since 1.0.0
 */
enum Flag:int {

    /**
     * ### Ignore invalid UTF-8 characters
     * @since 1.0.0
     */
    case INVALID_UTF8_IGNORE = 1048576;

    /**
     * ### Convert invalid UTF-8 characters to \0xfffd (Unicode Character 'REPLACEMENT CHARACTER')
     * @since 1.0.0
     */
    case INVALID_UTF8_SUBSTITUTE = 2097152;

    /**
     * ### Throws JsonException if an error occurs instead of setting the global error state
     * @since 1.0.0
     */
    case THROW_ON_ERROR = 4194304;

}