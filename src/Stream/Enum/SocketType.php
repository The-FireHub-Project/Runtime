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
 * ### Socket Type
 *
 * Defines native PHP stream constants for sockettype operations.
 * @since 1.0.0
 */
enum SocketType:int {

    /**
     * ### Provides a sequenced, reliable, bidirectional byte stream.
     * @since 1.0.0
     */
    case STREAM = STREAM_SOCK_STREAM;

    /**
     * ### Provides connectionless datagram messages.
     * @since 1.0.0
     */
    case DATAGRAM = STREAM_SOCK_DGRAM;

    /**
     * ### Provides access to raw network protocols.
     * @since 1.0.0
     */
    case RAW = STREAM_SOCK_RAW;

    /**
     * ### Provides reliably delivered datagram messages.
     * @since 1.0.0
     */
    case RELIABLE_DATAGRAM = STREAM_SOCK_RDM;

    /**
     * ### Provides a sequenced packet socket.
     * @since 1.0.0
     */
    case SEQUENCED_PACKET = STREAM_SOCK_SEQPACKET;

}
