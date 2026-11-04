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
 * ### Buffer Mode
 *
 * Defines native PHP stream constants for buffermode operations.
 * @since 1.0.0
 */
enum BufferMode:int {

    /**
     * ### Disables buffering.
     * @since 1.0.0
     */
    case NONE = STREAM_BUFFER_NONE;

    /**
     * ### Enables line buffering.
     * @since 1.0.0
     */
    case LINE = STREAM_BUFFER_LINE;

    /**
     * ### Enables full buffering.
     * @since 1.0.0
     */
    case FULL = STREAM_BUFFER_FULL;

}
