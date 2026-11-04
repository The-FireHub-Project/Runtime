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
 * ### Server Flag
 *
 * Defines native PHP stream constants for serverflag operations.
 * @since 1.0.0
 */
enum ServerFlag:int {

    /**
     * ### Binds a server socket without listening.
     * @since 1.0.0
     */
    case BIND = STREAM_SERVER_BIND;

    /**
     * ### Binds and listens on a connection-oriented server socket.
     * @since 1.0.0
     */
    case BIND_LISTEN = STREAM_SERVER_BIND | STREAM_SERVER_LISTEN;

}
