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
 * ### Socket Protocol
 *
 * Defines native PHP stream constants for socketprotocol operations.
 * @since 1.0.0
 */
enum SocketProtocol:int {

    /**
     * ### Uses the Internet Protocol.
     * @since 1.0.0
     */
    case IP = STREAM_IPPROTO_IP;

    /**
     * ### Uses the Internet Control Message Protocol.
     * @since 1.0.0
     */
    case ICMP = STREAM_IPPROTO_ICMP;

    /**
     * ### Uses raw IP packets.
     * @since 1.0.0
     */
    case RAW = STREAM_IPPROTO_RAW;

    /**
     * ### Uses the Transmission Control Protocol.
     * @since 1.0.0
     */
    case TCP = STREAM_IPPROTO_TCP;

    /**
     * ### Uses the User Datagram Protocol.
     * @since 1.0.0
     */
    case UDP = STREAM_IPPROTO_UDP;

}
