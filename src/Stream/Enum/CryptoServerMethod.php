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
     * ### Enables the ANY cryptographic method for server streams.
     * @since 1.0.0
     */
    case ANY = STREAM_CRYPTO_METHOD_ANY_SERVER;

    /**
     * ### Enables the SSLv2 cryptographic method for server streams.
     * @since 1.0.0
     */
    case SSLV2 = STREAM_CRYPTO_METHOD_SSLv2_SERVER;

    /**
     * ### Enables the SSLv3 cryptographic method for server streams.
     * @since 1.0.0
     */
    case SSLV3 = STREAM_CRYPTO_METHOD_SSLv3_SERVER;

    /**
     * ### Enables the TLS cryptographic method for server streams.
     * @since 1.0.0
     */
    case TLS = STREAM_CRYPTO_METHOD_TLS_SERVER;

    /**
     * ### Enables the TLSv1_0 cryptographic method for server streams.
     * @since 1.0.0
     */
    case TLSV1_0 = STREAM_CRYPTO_METHOD_TLSv1_0_SERVER;

    /**
     * ### Enables the TLSv1_1 cryptographic method for server streams.
     * @since 1.0.0
     */
    case TLSV1_1 = STREAM_CRYPTO_METHOD_TLSv1_1_SERVER;

    /**
     * ### Enables the TLSv1_2 cryptographic method for server streams.
     * @since 1.0.0
     */
    case TLSV1_2 = STREAM_CRYPTO_METHOD_TLSv1_2_SERVER;

    /**
     * ### Enables the TLSv1_3 cryptographic method for server streams.
     * @since 1.0.0
     */
    case TLSV1_3 = STREAM_CRYPTO_METHOD_TLSv1_3_SERVER;

    /**
     * ### Allows TLS versions 1.0, 1.1 for server streams.
     * @since 1.0.0
     */
    case TLS_10_11 = STREAM_CRYPTO_METHOD_TLSv1_0_SERVER | STREAM_CRYPTO_METHOD_TLSv1_1_SERVER;

    /**
     * ### Allows TLS versions 1.0, 1.2 for server streams.
     * @since 1.0.0
     */
    case TLS_10_12 = STREAM_CRYPTO_METHOD_TLSv1_0_SERVER | STREAM_CRYPTO_METHOD_TLSv1_2_SERVER;

    /**
     * ### Allows TLS versions 1.0, 1.3 for server streams.
     * @since 1.0.0
     */
    case TLS_10_13 = STREAM_CRYPTO_METHOD_TLSv1_0_SERVER | STREAM_CRYPTO_METHOD_TLSv1_3_SERVER;

    /**
     * ### Allows TLS versions 1.1, 1.2 for server streams.
     * @since 1.0.0
     */
    case TLS_11_12 = STREAM_CRYPTO_METHOD_TLSv1_1_SERVER | STREAM_CRYPTO_METHOD_TLSv1_2_SERVER;

    /**
     * ### Allows TLS versions 1.1, 1.3 for server streams.
     * @since 1.0.0
     */
    case TLS_11_13 = STREAM_CRYPTO_METHOD_TLSv1_1_SERVER | STREAM_CRYPTO_METHOD_TLSv1_3_SERVER;

    /**
     * ### Allows TLS versions 1.2, 1.3 for server streams.
     * @since 1.0.0
     */
    case TLS_12_13 = STREAM_CRYPTO_METHOD_TLSv1_2_SERVER | STREAM_CRYPTO_METHOD_TLSv1_3_SERVER;

    /**
     * ### Allows TLS versions 1.0, 1.1, 1.2 for server streams.
     * @since 1.0.0
     */
    case TLS_10_11_12 = STREAM_CRYPTO_METHOD_TLSv1_0_SERVER | STREAM_CRYPTO_METHOD_TLSv1_1_SERVER | STREAM_CRYPTO_METHOD_TLSv1_2_SERVER;

    /**
     * ### Allows TLS versions 1.0, 1.1, 1.3 for server streams.
     * @since 1.0.0
     */
    case TLS_10_11_13 = STREAM_CRYPTO_METHOD_TLSv1_0_SERVER | STREAM_CRYPTO_METHOD_TLSv1_1_SERVER | STREAM_CRYPTO_METHOD_TLSv1_3_SERVER;

    /**
     * ### Allows TLS versions 1.0, 1.2, 1.3 for server streams.
     * @since 1.0.0
     */
    case TLS_10_12_13 = STREAM_CRYPTO_METHOD_TLSv1_0_SERVER | STREAM_CRYPTO_METHOD_TLSv1_2_SERVER | STREAM_CRYPTO_METHOD_TLSv1_3_SERVER;

    /**
     * ### Allows TLS versions 1.1, 1.2, 1.3 for server streams.
     * @since 1.0.0
     */
    case TLS_11_12_13 = STREAM_CRYPTO_METHOD_TLSv1_1_SERVER | STREAM_CRYPTO_METHOD_TLSv1_2_SERVER | STREAM_CRYPTO_METHOD_TLSv1_3_SERVER;

}
