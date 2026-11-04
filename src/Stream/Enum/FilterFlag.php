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

namespace FireHub\Runtime\Stream\Enum;

/**
 * ### Filter Flag
 *
 * Defines native PHP stream constants for filterflag operations.
 * @since 1.0.0
 */
enum FilterFlag:int {

    /**
     * ### Applies a stream filter during reading.
     * @since 1.0.0
     */
    case READ = STREAM_FILTER_READ;

    /**
     * ### Applies a stream filter during writing.
     * @since 1.0.0
     */
    case WRITE = STREAM_FILTER_WRITE;

    /**
     * ### Applies a stream filter during reading and writing.
     * @since 1.0.0
     */
    case READ_WRITE = STREAM_FILTER_ALL;

}
