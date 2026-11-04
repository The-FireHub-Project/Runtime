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
 * ### Shutdown Mode
 *
 * Defines native PHP stream constants for shutdownmode operations.
 * @since 1.0.0
 */
enum ShutdownMode:int {

    /**
     * ### Disables further reception of data.
     * @since 1.0.0
     */
    case READ = STREAM_SHUT_RD;

    /**
     * ### Disables further transmission of data.
     * @since 1.0.0
     */
    case WRITE = STREAM_SHUT_WR;

    /**
     * ### Disables further reception and transmission of data.
     * @since 1.0.0
     */
    case READ_WRITE = STREAM_SHUT_RDWR;

}
