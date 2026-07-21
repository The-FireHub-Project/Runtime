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

namespace FireHub\Runtime\Json\Flag;

/**
 * ### PHP Runtime JSON Error Codes
 *
 * Provides JSON error codes returned by native PHP JSON processing functions while preserving native runtime behavior.
 *
 * This enum exposes JSON error states through a consistent FireHub Runtime API without altering PHP JSON error
 * handling semantics.
 * @since 1.0.0
 */
enum Error:int {

    /**
     * ### No error has occurred
     * @since 1.0.0
     */
    case ERROR_NONE = 0;

    /**
     * ### The maximum stack depth has been exceeded
     * @since 1.0.0
     */
    case ERROR_DEPTH = 1;

    /**
     * ### Occurs with underflow or with the mode mismatch
     * @since 1.0.0
     */
    case ERROR_STATE_MISMATCH = 2;

    /**
     * ### Control character error, possibly incorrectly encoded
     * @since 1.0.0
     */
    case ERROR_CTRL_CHAR = 3;

    /**
     * ### Syntax error
     * @since 1.0.0
     */
    case ERROR_SYNTAX = 4;

    /**
     * ### Malformed UTF-8 characters, possibly incorrectly encoded
     * @since 1.0.0
     */
    case ERROR_UTF8 = 5;

    /**
     * ### The object or array passed to json_encode() include recursive references and can't be encoded
     * @since 1.0.0
     */
    case ERROR_RECURSION = 6;

    /**
     * ### The value passed to json_encode() includes either NAN or INF
     * @since 1.0.0
     */
    case ERROR_INF_OR_NAN = 7;

    /**
     * ### A value of an unsupported type was given to json_encode(), such as a resource
     * @since 1.0.0
     */
    case ERROR_UNSUPPORTED_TYPE = 8;

    /**
     * ### A key starting with \u0000 character was in the string passed to json_decode() when decoding a JSON object into a PHP object
     * @since 1.0.0
     */
    case ERROR_INVALID_PROPERTY_NAME = 9;

    /**
     * ### Single unpaired UTF-16 surrogate in Unicode escape contained in the JSON string passed to json_decode()
     * @since 1.0.0
     */
    case ERROR_UTF16 = 10;

    /**
     * ### The value passed to json_encode() includes a non-backed enum which can't be serialized
     * @since 1.0.0
     */
    case ERROR_NON_BACKED_ENUM = 11;

}