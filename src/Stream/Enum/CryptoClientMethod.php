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
 * ### Crypto Client Method
 *
 * Defines native PHP stream constants for cryptoclientmethod operations.
 * @since 1.0.0
 */
enum CryptoClientMethod:int {

    /**
     * ### Enables TLS 1.2 encryption for client stream connections
     * @since 1.0.0
     */
    case TLSV1_2 = STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;

    /**
     * ### Enables TLS 1.3 encryption for client stream connections
     * @since 1.0.0
     */
    case TLSV1_3 = STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT;

    /**
     * ### Allows TLS 1.2 and TLS 1.3 encryption for client stream connections
     *
     * Negotiates a supported TLS version between the client and server.
     * @since 1.0.0
     */
    case TLS_12_13 = STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT | STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT;

}
