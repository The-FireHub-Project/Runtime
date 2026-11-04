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
 * ### Crypto Server Method
 *
 * Defines native PHP stream constants for cryptoservermethod operations.
 * @since 1.0.0
 */
enum CryptoServerMethod:int {

    /**
     * ### Enables TLS 1.2 encryption for server stream connections
     * @since 1.0.0
     */
    case TLSV1_2 = STREAM_CRYPTO_METHOD_TLSv1_2_SERVER;

    /**
     * ### Enables TLS 1.3 encryption for server stream connections
     * @since 1.0.0
     */
    case TLSV1_3 = STREAM_CRYPTO_METHOD_TLSv1_3_SERVER;

    /**
     * ### Allows TLS 1.2 and TLS 1.3 encryption for server stream connections
     *
     * Negotiates a supported TLS version between the client and server.
     * @since 1.0.0
     */
    case TLS_12_13 = STREAM_CRYPTO_METHOD_TLSv1_2_SERVER | STREAM_CRYPTO_METHOD_TLSv1_3_SERVER;

}
