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
 * ### Client Flag
 *
 * Defines native PHP stream constants for clientflag operations.
 * @since 1.0.0
 */
enum ClientFlag:int {

    /**
     * ### Establishes a client socket connection.
     * @since 1.0.0
     */
    case CONNECT = STREAM_CLIENT_CONNECT;

    /**
     * ### Initiates a non-blocking client socket connection.
     * @since 1.0.0
     */
    case ASYNC_CONNECT = STREAM_CLIENT_CONNECT | STREAM_CLIENT_ASYNC_CONNECT;

    /**
     * ### Establishes a persistent client socket connection.
     * @since 1.0.0
     */
    case PERSISTENT_CONNECT = STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT;

    /**
     * ### Initiates a persistent non-blocking client socket connection.
     * @since 1.0.0
     */
    case ASYNC_PERSISTENT_CONNECT = STREAM_CLIENT_CONNECT | STREAM_CLIENT_ASYNC_CONNECT | STREAM_CLIENT_PERSISTENT;

}
