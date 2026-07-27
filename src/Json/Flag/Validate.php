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

namespace FireHub\Runtime\Json\Flag;

/**
 * ### PHP Runtime JSON Validation Flags
 *
 * Provides JSON validation flags used by the native PHP json_validate() function while preserving native runtime
 * behavior.
 *
 * This enum exposes JSON validation configuration options through a consistent FireHub Runtime API without altering
 * PHP JSON validation semantics.
 * @since 1.0.0
 */
enum Validate:int {

    /**
     * ### Ignore invalid UTF-8 characters
     * @since 1.0.0
     */
    case INVALID_UTF8_IGNORE = 1048576;

}