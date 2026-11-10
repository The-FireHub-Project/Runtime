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

use function header;
use function header_remove;
use function headers_list;
use function headers_sent;
use function http_response_code;
use function setcookie;
use function setrawcookie;

/**
 * ### Native HTTP Response Utilities
 *
 * Provides low-level wrappers for managing HTTP response headers, status codes, and cookies through the PHP Server
 * API (SAPI).
 *
 * This component preserves native PHP response behavior without introducing HTTP message abstractions, validation,
 * or normalization.
 * @since 1.0.0
 */
final readonly class Response extends NativeRuntime {

    /**
     * ### Sends a raw HTTP header
     *
     * Sends a raw HTTP header to the client.
     *
     * The header is scheduled for transmission when PHP sends the response headers.
     * @since 1.0.0
     *
     * @param string $header <p>
     * Raw HTTP header string.
     * </p>
     * @param bool $replace [optional] <p>
     * Whether to replace a previously defined similar header.
     * </p>
     * @param int $response_code [optional] <p>
     * HTTP response status code. A value of 0 preserves PHP's default behavior.
     * </p>
     *
     * @return void
     */
    public static function sendHeader (string $header, bool $replace = true, int $response_code = 0):void {

        header($header, $replace, $response_code);

    }

    /**
     * ### Removes a previously set HTTP header
     *
     * Removes a previously scheduled HTTP response header.
     *
     * If no header name is provided, all previously scheduled headers are removed.
     * @since 1.0.0
     *
     * @param null|string $name [optional] <p>
     * Header name to remove, or null to remove all headers.
     * </p>
     *
     * @return void
     */
    public static function removeHeader (?string $name = null):void {

        header_remove($name);

    }

    /**
     * ### Gets all response headers
     *
     * Returns a list of HTTP response headers that have been prepared for transmission.
     * @since 1.0.0
     *
     * @return list<string> List of HTTP response headers.
     */
    public static function headers ():array {

        return headers_list();

    }

    /**
     * ### Checks whether HTTP headers have been sent
     *
     * Determines whether HTTP response headers have already been sent to the client.
     *
     * When headers have been sent, the optional output parameters contain the filename and line number where the
     * output started.
     * @since 1.0.0
     *
     * @param string|null $file [optional] <p>
     * Receives the filename where output started.
     * </p>
     * @param int|null $line [optional] <p>
     * Receives the line number where output started.
     * </p>
     *
     * @return bool True if headers have already been sent, false otherwise.
     */
    public static function headersSent (?string &$file = null, ?int &$line = null):bool {

        return headers_sent($file, $line);

    }

    /**
     * ### Gets or sets the HTTP response status code
     *
     * Retrieves the current HTTP response status code or sets a new response status code.
     * @since 1.0.0
     *
     * @param int $code [optional] <p>
     * HTTP response status code to set, or null to retrieve the current status code.
     * </p>
     *
     * @return int|bool Current or previous HTTP response status code, or false if no status code is available.
     */
    public static function statusCode (int $code = 0):int|bool {

        return http_response_code($code);

    }

    /**
     * ### Sends an HTTP cookie
     *
     * Sends a cookie using PHP's native cookie handling.
     *
     * The cookie value is URL-encoded automatically.
     * @since 1.0.0
     *
     * @param string $name <p>
     * Cookie name.
     * </p>
     * @param string $value [optional] <p>
     * Cookie value.
     * </p>
     * @param array{
     *     expires?: int,
     *     path?: string,
     *     domain?: string,
     *     secure?: bool,
     *     httponly?: bool,
     *     samesite?: 'Lax'|'lax'|'None'|'none'|'Strict'|'strict',
     *     partitioned?: bool
     * } $options [optional] <p>
     * Cookie configuration options.
     * </p>
     *
     * @return bool True on success, false otherwise.
     */
    public static function setCookie (string $name, string $value = '', array $options = []):bool {

        return setcookie($name, $value, $options);

    }

    /**
     * ### Sends a raw HTTP cookie
     *
     * Sends a cookie without URL-encoding its value.
     * @since 1.0.0
     *
     * @param string $name <p>
     * Cookie name.
     * </p>
     * @param string $value [optional] <p>
     * Raw cookie value.
     * </p>
     * @param array{
     *     expires?: int,
     *     path?: string,
     *     domain?: string,
     *     secure?: bool,
     *     httponly?: bool,
     *     samesite?: 'Lax'|'lax'|'None'|'none'|'Strict'|'strict',
     *     partitioned?: bool
     * } $options [optional] <p>
     * Cookie configuration options.
     * </p>
     *
     * @return bool True on success, false otherwise.
     */
    public static function setRawCookie (string $name, string $value = '', array $options = []):bool {

        return setrawcookie($name, $value, $options);

    }

}