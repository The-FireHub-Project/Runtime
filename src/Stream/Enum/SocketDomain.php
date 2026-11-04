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
 * ### Socket Domain
 *
 * Defines native PHP stream constants for socketdomain operations.
 * @since 1.0.0
 */
enum SocketDomain:int {

    /**
     * ### Uses the IPv4 protocol family.
     * @since 1.0.0
     */
    case IPV4 = STREAM_PF_INET;

    /**
     * ### Uses the IPv6 protocol family.
     * @since 1.0.0
     */
    case IPV6 = STREAM_PF_INET6;

    /**
     * ### Uses the Unix domain socket protocol family.
     * @since 1.0.0
     */
    case UNIX = STREAM_PF_UNIX;

}
