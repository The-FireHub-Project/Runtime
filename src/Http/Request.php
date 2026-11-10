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

namespace FireHub\Runtime\Http;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function getallheaders;

/**
 * ### Native HTTP Request Utilities
 *
 * Provides low-level wrappers for accessing HTTP request information exposed by the PHP Server API (SAPI).
 *
 * This component preserves native PHP request behavior without introducing HTTP message parsing, validation, or
 * normalization.
 * @since 1.0.0
 */
final readonly class Request extends NativeRuntime {

    /**
     * ### Gets all HTTP request headers
     *
     * Fetches all HTTP request headers from the current request.
     *
     * Header names are returned as provided by the underlying PHP Server API. Header name casing is not normalized.
     * @since 1.0.0
     *
     * @return array<string, string> Associative array of HTTP request headers.
     */
    public static function headers ():array {

        /** @var array<string, string> */
        return getallheaders();

    }

}